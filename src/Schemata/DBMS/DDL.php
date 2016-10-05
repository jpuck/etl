<?php
namespace jpuck\etl\Schemata\DBMS;

use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\DBMS\PrefixTrait;
use InvalidArgumentException;

abstract class DDL {
	use PrefixTrait;

	protected $default_varchar_size = 100;
	// TODO: set minimum size
	protected $stage = true;
	protected $identity;

	public function __construct(...$options){
		foreach ($options as $option){
			$this->set($option, 'prefix');
			$this->set($option, 'stage');
			$this->set($option, 'identity');
		}
		if (is_null($this->identity)){
			$this->identity(true);
		}
	}

	protected function set($option, String $function){
		if (is_array($option) && isset($option["$function"])){
			$this->$function($option["$function"]);
		}
	}

	public function stage(Bool $stage = null) : Bool {
		if (isset($stage)){
			$this->stage = $stage;
		}
		return $this->stage;
	}

	public function toSQL(Schema $schema) : Array {
		$prefix = $this->prefix();
		if ($this->stage()){
			if (empty($prefix)){
				$prefix = $this->prefix('tmp');
			}
			$stage = $this->build($schema->toArray());
			$this->prefix('');
			$this->identity(false);
		}

		$prod = $this->build($schema->toArray());

		if (isset($stage)){
			$sql['drop']   = $stage['drop']   . $prod['drop'];
			$sql['create'] = $stage['create'] . $prod['create'];

			$sql['delete'][$prefix] = $stage['delete'];
			$sql['delete'][  ''   ] = $prod ['delete'];

			$sql['insert'] = $stage['insert'] . $prod['insert'];
		} else {
			$sql = $prod;
		}

		return $sql;
	}

	// convenience method for single drop/create DDL script
	public function generate(Schema $schema, ...$options) : String {
		$ddl = $this->toSQL($schema);

		if (empty($options) || empty($options[0])){
			return $ddl['drop'].$ddl['create'];
		}
		$return = '';
		if (in_array('drop', $options)){
			$return .= $ddl['drop'];
		}
		if (in_array('create', $options)){
			$return .= $ddl['create'];
		}
		return $return;
	}

	protected function build(Array $nodes, String $path='') : Array {
		$prefix = $this->prefix();

		// initialize recursor
		$drops = '';
		$creates = '';
		$deletes = '';
		$inserts = '';

		foreach ($nodes as $name => $node){
			// entity names
			$parent = $this->quote($prefix.$path);
			$table  = $this->quote($prefix.$path.$name);

			// drop table definition
			$drop   = "\nDROP TABLE $table;";
			$drops .= $this->wrapCheckIfExists($prefix.$path.$name,$drop);

			// create table definition
			$create = "\nCREATE TABLE $table (\n";

			// delete
			$deletes .= "DELETE FROM $table;\n";
			$insert  = '';

			// surrogate parent foreign key
			// TODO: use natural key if unique values
			if (!empty($path)){
				$create .= "	jpetl_pid int,\n";
				$create .= "	CONSTRAINT fk_$prefix$path$name\n";
				$create .= "		FOREIGN KEY (jpetl_pid)\n";
				$create .= "		REFERENCES $parent(jpetl_id),\n";

				$insert .= "\tjpetl_pid,\n";
			}

			// get attributes
			if (isset($node['attributes'])){
				foreach ($node['attributes'] as $key => $attribute){
					$create .= $this->columnize($key, $attribute);
					$insert .= "\t".$this->quote($key).",\n";
				}
			}

			// if children
			if (isset($node['elements'])){
				// flatten singular leaves or recurse
				foreach ($node['elements'] as $key => $element){
					// if no grandchildren or multi-values
					if (
						$element['count']['max']['measure'] > 1 ||
						isset($element['children'])
					){
						$recurse[$key] = $element;
					} else {
						// get single, childless child-element value
						$create .= $this->columnize($key, $element);
						$insert .= "\t".$this->quote($key).",\n";
						// flatten single child attributes
						if (isset($element['attributes'])){
							foreach ($element['attributes'] as $k => $att){
								$create .= $this->columnize($key.$k, $att);
								$insert .= "\t".$this->quote($key.$k).",\n";
							}
						}
					}
				}
			} else {
				// get childless element value
				$create .= $this->columnize($name, $node);
				$insert .= "\t".$this->quote($name).",\n";
			}

			// close table definition with surrogate primary key
			// TODO: use natural key if unique values
			$identity = $this->identity();
			$create  .= "	jpetl_id int $identity PRIMARY KEY\n);";
			$creates .= $this->wrapCheckIfNotExists($prefix.$path.$name,$create);
			$insert  .= "\tjpetl_id\n";

			// insert
			if (!empty($prefix)){
				$stage = $this->quote($prefix.$path.$name);
				$prod  = $this->quote($path.$name);
				$inserts .= "\nINSERT INTO $prod (\n";
				$inserts .= $insert;
				$inserts .= ") SELECT\n";
				$inserts .= $insert;
				$inserts .= "FROM $stage;\n";
			}

			// get children and multi-values
			if (isset($recurse)){
				$children = $this->build($recurse, $path.$name);
				$drops = $children['drop'] . $drops;
				$creates .= $children['create'];
				$inserts .= $children['insert'];
				$deletes = $children['delete'] . $deletes;
				unset($recurse);
			}
		}

		return [
			'drop'   => $drops,
			'create' => $creates,
			'delete' => $deletes,
			'insert' => $inserts,
		];
	}

	protected function columnize(String $col, Array $type) : String {
		$column = $this->quote($col);
		return "	$column ".$this->getDatatype($type);
	}

	protected function getDatatype(Array $attribute) : String {
		// TODO: set default datatype
		// TODO: check if 'datatype' override set

		if ($this->validateDatetimes($attribute)){
			// check longer varchar value first in case of mixed timezone offset
			$datatype =
				$attribute['varchar' ]['max']['value'] ??
				$attribute['datetime']['max']['value'];
			$datatype = $this->getDatetime($datatype);
			$datatype = "$datatype,\n";
		} elseif (isset($attribute['int'])){
			$datatype = $this->getInteger($attribute['int']['max']['value']);
			$datatype = "$datatype,\n";
		} elseif (isset($attribute['decimal'])){
			$precision = $attribute['precision']['max']['measure'];
			$scale = $attribute['scale']['max']['measure'] + $precision;
			$datatype = "decimal($scale,$precision),\n";
		} else {
			$vsize = $attribute['varchar']['max']['measure'] ?? null;
			$datatype = $this->getVarchar($vsize);
			$datatype = "$datatype,\n";
		}
		return $datatype;
	}

	protected function validateDatetimes(Array $attribute) : Bool {
		if (!isset($attribute['datetime'])){
			return false;
		}

		$max = $this->getDatetime($attribute['datetime']['max']['value']);
		if ($max === false){
			return   false;
		}

		$min = $attribute['datetime']['min']['value'] ?? null;
		if (isset($min)){
			$min = $this->getDatetime($min);
			if ($min === false){
				return   false;
			}
		}

		return true;
	}

	protected function wrapCheckIfExists(String $table, String $stmt, String $not=null) : String {
		$wrapper  = "\nIF (\n	";
		if (isset($not) && strtoupper($not) === 'NOT'){
			$wrapper .= "NOT ";
		}
		$wrapper .= "EXISTS (";
		$wrapper .= "\n		SELECT *";
		$wrapper .= "\n		FROM INFORMATION_SCHEMA.TABLES";
		$wrapper .= "\n		WHERE TABLE_NAME = '$table'";
		$wrapper .= "\n		-- AND TABLE_SCHEMA = 'dbo'";
		$wrapper .= "\n	)";
		$wrapper .= "\n)";
		$wrapper .= "\nBEGIN";

		$stmt = str_replace("\n","\n	",$stmt);

		return "$wrapper$stmt\nEND\n";
	}

	protected function wrapCheckIfNotExists(String $table, String $stmt) : String {
		return $this->wrapCheckIfExists($table,$stmt,'NOT');
	}

	abstract public function getInteger($value) : String;
	abstract public function getDatetime($value);
	abstract public function getVarchar($length = null) : String;
	abstract public function quote(String $entity, Bool $chars = false);
	abstract public function identity(Bool $enabled = null) : String;
}
