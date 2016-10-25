<?php
namespace jpuck\etl\Sources;

use jpuck\phpdev\Exceptions\Unimplemented;
use jpuck\phpdev\Functions as jp;
use jpuck\etl\Data\Datum;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\DDL;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Utilities\Options;
use PDO;
use InvalidArgumentException;

abstract class DB extends Source {
	use DDL;
	protected $surrogateCount = [];
	protected $statements = '';

	public function __construct(PDO $uri = null, ...$options){
		parent::__construct($uri);
		if(isset($uri)){
			$uri->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		$defaults = [
			'identity'  => false,
			'stage'     => true,
			'prefix'    => '',
			'surrogate' => 'jpetl_id',
		];
		$this->options($defaults);
		$this->options(...$options);
		$this->identity($this->options['identity']);
	}

	// use PHP7 strict type
	protected function validateURI($uri) : Bool {
		return true;
	}

	public function insert  (Datum $datum) : bool {
	/*
		foreach nodes as node
			if isset(lastInsertedID)
				insert []= lastInsertedID
			foreach attributes as attribute
				insert []= attribute
			if value
				insert []= value
			else foreach elements as element
				if element['count']['max']['measure'] === 1
					insert []= element
			exec insert
			get lastInsertedID
			foreach elements as element
				if element['count']['max']['measure'] > 1
					recurse(lastInsertedID)
	*/
		$schema = $datum->schema()->toArray();
		$data   = $datum->parsed();
		$this->insertData($data, $schema, ['']);
		if(!empty($this->statements)){
			$this->uri->beginTransaction();
			try {
				$statement = $this->uri->query($this->statements);
				while ($statement->nextRowset()) {
					/* https://bugs.php.net/bug.php?id=61613 */
				};
				$this->uri->commit();
			} catch (\PDOException $e) {
				$this->uri->rollBack();
				throw $e;
			} finally {
				if(isset($statement)){
					$statement->closeCursor();
				}
			}
			$this->statements = '';
		}
		return true;
	}

	protected function insertData(Array $node, Array $schema, Array $query){
			// append table name and push the stack
			$name = Schematizer::stripNamespace($node['name']);
			if(!$this->uses($node, $name, $query, $schema)){
				return;
			}
			$query[0] .= $query[] = $name;

			$primaryKey = $this->getAttributes($node, $query, $schema);

			// get the children
			if (isset($node['value'])){
				if (is_array($node['value'])){
					foreach ($node['value'] as $key => $value){
						// if grandchildren, then recurse
						$key = Schematizer::stripNamespace($node['value'][$key]['name']);
						if ($this->hasGrandChildren($node['value'], $key, $schema, $query)){
							$recurse []= $value;
						} else {
							$tmpa = $this->getAttributes($value, $query, $schema, $key);
							$tmpb = $this->setValues($value,$key,$query,$schema);
							$primaryKey = $primaryKey ?? $tmpa ?? $tmpb;
						}
					}
				} else {
					$tmp = $this->setValues($node,$name,$query,$schema);
					$primaryKey = $primaryKey ?? $tmp;
				}
			}

			// generate surrogate key, or use DB identity
			if(empty($this->options['identity'])){
				$count =& $this->surrogateCount;
				$table = $query[0];

				// check for existing records
				if(empty($count[$table])){
					$sql = "SELECT MAX({$this->options['surrogate']}) AS id FROM $table";
					$res = $this->uri->query($sql);
					$row = $res->fetch(PDO::FETCH_ASSOC);
					$count[$table] = $row['id'] ?? 0;
					$res->closeCursor();
				}
				$query[$this->options['surrogate']] = ++$count[$table];
			}

			// execute query
			$this->insertExecute($query, $primaryKey);

			// recurse children
			if (isset($recurse)){
				foreach ($recurse as $child){
					$this->insertData($child, $schema, $query);
				}
			}
	}

	protected function insertExecute(Array &$query, String $primaryKey = null){
		$surrogate = $this->options['surrogate'];
		$table = $this->quote($this->options['prefix'].$query[0]);
		$sql   = " INSERT INTO $table ";

		if (isset($primaryKey)) {
			$primaryVal = $query[$primaryKey];
		}

		foreach ($query as $key => $value) {
			if (!is_int($key)) {
				$cols []= $key;
				$vals []= str_replace("'","''",$value); // escape SQL
				// filter out parent columns for children
				unset($query[$key]);
			}
		}

		if (!empty($cols)){
			$qo   = $this->quote('',true)[0];
			$qc   = $this->quote('',true)[1];
			$sql .= "($qo".implode("$qc,$qo",$cols)."$qc)";
		}

		if (!isset($primaryKey) && !empty($this->options['identity'])) {
			$sql .= " OUTPUT INSERTED.$surrogate ";
		}

		if (empty($cols)){
			$sql .= " DEFAULT VALUES ";
		} else {
			$sql .= " VALUES ('".implode("','",$vals)."'); ";
		}

		if(!empty($this->options['identity'])){
			try {
				$stmt = $this->uri->query($sql);
			} catch (\PDOException $e) {
				echo $sql.PHP_EOL;
				throw $e;
			}
		} else {
			$this->statements .= $sql;
		}

		// pass parent id for child
		if (isset($primaryKey)) {
			$query[$primaryKey.'fk'] = $primaryVal;
		} elseif(!empty($this->options['identity'])) {
			$query[$surrogate.'fk'] = $stmt->fetch(PDO::FETCH_ASSOC)[$surrogate];
			while ($stmt->nextRowset()) {/* https://bugs.php.net/bug.php?id=61613 */};
			$stmt->closeCursor();
		} else {
			$query[$surrogate.'fk'] = $this->surrogateCount[$query[0]];
		}
	}

	protected function setValues(Array &$node, String $nsname, Array &$query, Array $schema, String $prefix=''){
		$name = Schematizer::stripNamespace($nsname);
		if($this->uses($node,$name,$query,$schema)){
			$value = $node[$nsname] ?? $node['value'] ?? null;
			if(is_numeric($value) || !empty($value)){
				$query[$prefix.$name] = $value;
				if($this->isPrimaryKey($name, $schema, $query)){
					$primaryKey = $name;
				}
			}
		}
		return $primaryKey ?? null;
	}

	protected function uses(Array &$node, String $name, Array &$query, Array $schema) : Bool {
		// if this is the root node, then return true
		if(count($query) === 1 && $name === key($schema)){
			return true;
		}

		$stack = $this->walkSchema($schema, $query);

		if(isset($stack['attributes'])){
			foreach($stack['attributes'] as $key => $value){
				if($key === $name){
					return true;
				}
			}
		}

		if(!empty($stack['elements'][$name])){
			return true;
		}

		// don't waste any more time exploring this node
		unset($node[$name]);
		return false;
	}

	protected function getAttributes(Array &$node, Array &$query, Array $schema, String $prefix=''){
		// get the node attributes as column values
		if (isset($node['attributes'])){
			foreach ($node['attributes'] as $key => $value){
				$tmp = $this->setValues($node['attributes'], $key, $query, $schema, $prefix);
				$primaryKey = $primaryKey ?? $tmp;
			}
		}
		return $primaryKey ?? null;
	}

	protected function walkSchema(Array $schema, Array $query) : Array {
		// copy schema from root node
		$attrs = $schema[$query[1]]['attributes'] ?? null;
		$elems = $schema[$query[1]]['elements'];

		// walk down schema popping the stack
		foreach ($query as $key => $value){
			// ignore associative keys (columns)
			if (is_numeric($key) && $key > 1){
				// pop & walk
				$attrs = $elems[$query[$key]]['attributes'] ?? null;
				$elems = $elems[$query[$key]][ 'elements' ] ?? null;
			}
		}

		return [
			'attributes' => $attrs,
			 'elements'  => $elems,
		];
	}

	protected function hasGrandChildren(Array &$node, String $name, Array $schema, Array $query){
		if(!$this->uses($node, $name, $query, $schema)){
			return false;
		}

		$elements = $this->walkSchema($schema, $query)['elements'];

		// check if single leaf
		if (
			$elements[$name]['count']['max']['measure'] > 1 ||
			isset($elements[$name]['children'])
		){
			return true;
		} else {
			return false;
		}
	}

	protected function isPrimaryKey(String $name, Array $schema, Array $query){
		$stack = $this->walkSchema($schema, $query);

		if (isset($stack['attributes'])) {
			foreach ($stack['attributes'] as $k => $v) {
				if (!empty($stack['attributes'][$name]['primaryKey'])) {
					return true;
				}
			}
		}

		// check if single leaf
		if (!empty($stack['elements'][$name]['primaryKey'])) {
			return true;
		} else {
			return false;
		}
	}
}
