<?php
namespace jpuck\etl\Sources;

use jpuck\phpdev\Exceptions\Unimplemented;
use jpuck\phpdev\Functions as jp;
use jpuck\etl\Data\Datum;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Schemata\Datatypes\Datatyper;
use PDO;
use InvalidArgumentException;

class DB extends Source {
	private $DEBUG = false;

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

	public function debug(Bool $on = null){
		if (isset($on)){
			$this->DEBUG = $on;
		}
		return $this->DEBUG;
	}

	protected function insertData(Array $node, Array $schema, Array $query){
			// append table name and push the stack
			$name = Schematizer::stripNamespace($node['name']);
			$query[0] .= $query[] = $name;

			$this->getAttributes($node, $query);

			// get the children
			if (isset($node['value'])){
				if (is_array($node['value'])){
					foreach ($node['value'] as $key => $value){
						// if grandchildren, then recurse
						$key = Schematizer::stripNamespace($node['value'][$key]['name']);
						if ($this->hasGrandChildren($key, $schema, $query)){
							$recurse []= $value;
						} else {
							$this->getAttributes($value, $query, $key);
							if (is_numeric($value['value']) || !empty($value['value'])){
								$query[$key] = $value['value'];
							}
						}
					}
				} else {
					if (is_numeric($node['value']) || !empty($node['value'])){
						$query[$name] = $node['value'];
					}
				}
			}

			// execute query
			$this->insertExecute($query);

			// recurse children
			if (isset($recurse)){
				foreach ($recurse as $child){
					$this->insertData($child, $schema, $query);
				}
			}
	}

	protected function insertExecute(Array &$query){
		$table = $this->quote($this->prefix().$query[0]);
		$sql   = "INSERT INTO $table ";
		foreach ($query as $key => $value) {
			if (!is_int($key)) {
				$cols []= $key;
				$vals []= str_replace("'","''",$value); // escape SQL
				// filter out parent columns for children
				unset($query[$key]);
			}
		}
		$qo   = $this->quote('',true)[0];
		$qc   = $this->quote('',true)[1];
		$sql .= "($qo".implode("$qc,$qo",$cols)."$qc)";
		$sql .= ' OUTPUT INSERTED.jpetl_id ';
		$sql .= "VALUES ('".implode("','",$vals)."')";

		try {
			$stmt = $this->uri->prepare($sql);
			$stmt->execute();
		} catch (\PDOException $e) {
			if ($this->debug()) {
				echo $sql.PHP_EOL;
			}
			throw $e;
		}

		// pass parent id for child
		$query['jpetl_pid'] = $stmt->fetch(PDO::FETCH_ASSOC)['jpetl_id'];
	}

	protected function getAttributes(Array &$node, Array &$query, String $prefix=''){
		// get the node attributes as column values
		if (isset($node['attributes'])){
			foreach ($node['attributes'] as $key => $value){
				$key = Schematizer::stripNamespace($key);
				$query[$prefix.$key] = $value;
			}
		}
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
}
