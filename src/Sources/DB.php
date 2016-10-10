<?php
namespace jpuck\etl\Sources;

use jpuck\phpdev\Exceptions\Unimplemented;
use jpuck\phpdev\Functions as jp;
use jpuck\etl\Data\Datum;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Schemata\DBMS\MicrosoftSQLServerTrait;
use jpuck\etl\Schemata\DBMS\PrefixTrait;
use PDO;
use InvalidArgumentException;

class DB extends Source {
	use MicrosoftSQLServerTrait;
	use PrefixTrait;

	public function __construct(PDO $uri, ...$options){
		parent::__construct($uri);
		foreach ($options as $option){
			if (is_array($option) && isset($option['prefix'])){
				$this->prefix($option['prefix']);
			}
		}
	}

	/**
	 * @throws InvalidArgumentException
	 */
	protected function validateURI($uri) : Bool {
		if (!$uri instanceof PDO){
			throw new InvalidArgumentException(
				'DB uri must be instance of PDO.'
			);
		}
		return true;
	}
	public function fetch(String $endpoint, String $datumClass, Schema $schema = null) : Datum {
		throw new Unimplemented(__METHOD__);
		return new XML;
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
		return true;
	}

	public function replace (Datum $data) : bool {
		throw new Unimplemented(__METHOD__);
		return false;
	}

	protected function insertData(Array $node, Array $schema, Array $query){
			// append table name and push the stack
			$name = Schematizer::stripNamespace($node['name']);
			$query[0] .= $query[] = $name;

			$primaryKey = $this->getAttributes($node, $query, '', $schema);

			// get the children
			if (isset($node['value'])){
				if (is_array($node['value'])){
					foreach ($node['value'] as $key => $value){
						// if grandchildren, then recurse
						$key = Schematizer::stripNamespace($node['value'][$key]['name']);
						if ($this->hasGrandChildren($key, $schema, $query)){
							$recurse []= $value;
						} else {
							$primaryKey = $primaryKey ?? $this->getAttributes($value, $query, $key, $schema);
							$primaryKey = $primaryKey ?? $this->setValues($value,$key,$query,$schema);
						}
					}
				} else {
					$primaryKey = $primaryKey ?? $this->setValues($node,$name,$query,$schema);
				}
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
		$table = $this->quote($this->prefix().$query[0]);
		$sql   = "INSERT INTO $table ";

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

		if (!isset($primaryKey)) {
			$sql .= ' OUTPUT INSERTED.jpetl_id ';
		}

		if (empty($cols)){
			$sql .= " DEFAULT VALUES";
		} else {
			$sql .= " VALUES ('".implode("','",$vals)."')";
		}

		try {
			$stmt = $this->uri->query($sql);
		} catch (\PDOException $e) {
			echo $sql.PHP_EOL;
			throw $e;
		}

		// pass parent id for child
		if (isset($primaryKey)) {
			$query[$primaryKey.'fk'] = $primaryVal;
		} else {
			$query['jpetl_pid'] = $stmt->fetch(PDO::FETCH_ASSOC)['jpetl_id'];
		}
	}

	protected function setValues($node,$name,&$query,$schema){
		$primaryKey = null;
		if (is_numeric($node['value']) || !empty($node['value'])){
			$query[$name] = $node['value'];
			if ($this->isPrimaryKey($name, $schema, $query)){
				$primaryKey = $name;
			}
		}
		return $primaryKey;
	}

	protected function getAttributes(Array &$node, Array &$query, String $prefix='', $schema){
		$primaryKey = null;
		// get the node attributes as column values
		if (isset($node['attributes'])){
			foreach ($node['attributes'] as $key => $value){
				$key = Schematizer::stripNamespace($key);
				$query[$prefix.$key] = $value;
				if ($this->isPrimaryKey($key, $schema, $query)){
					$primaryKey = $prefix.$key;
				}
			}
		}
		return $primaryKey;
	}

	protected function hasGrandChildren(String $node, Array $schema, Array $query){
		// copy schema from root node
		$stack = $schema[$query[1]]['elements'];

		// walk down schema popping the stack
		foreach ($query as $key => $value){
			// ignore associative keys (columns)
			if (is_numeric($key) && $key > 1){
				// pop & walk
				$stack = $stack[$query[$key]]['elements'];
			}
		}

		// check if single leaf
		if (
			$stack[$node]['count']['max']['measure'] > 1 ||
			isset($stack[$node]['children'])
		){
			return true;
		} else {
			return false;
		}
	}

	protected function isPrimaryKey(String $node, Array $schema, Array $query){
		// copy schema from root node
		$attrs = $schema[$query[1]]['attributes'] ?? null;
		$stack = $schema[$query[1]]['elements'];

		// walk down schema popping the stack
		foreach ($query as $key => $value){
			// ignore associative keys (columns)
			if (is_numeric($key) && $key > 1){
				// pop & walk
				$attrs = $stack[$query[$key]]['attributes'] ?? null;
				$stack = $stack[$query[$key]][ 'elements' ] ?? null;
			}
		}

		if (isset($attrs)) {
			foreach ($attrs as $k => $v) {
				if (!empty($attrs[$node]['primaryKey'])) {
					return true;
				}
			}
		}

		// check if single leaf
		if (!empty($stack[$node]['primaryKey'])) {
			return true;
		} else {
			return false;
		}
	}
}
