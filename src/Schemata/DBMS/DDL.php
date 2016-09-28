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

	public function __construct(...$options){
		foreach ($options as $option){
			if (is_array($option) && isset($option['prefix'])){
				$this->prefix($option['prefix']);
			}
			if (is_array($option) && isset($option['stage'])){
				$this->stage($option['prefix']);
			}
		}
	}

	public function stage(Bool $stage) : Bool {
		if (isset($stage)){
			$this->stage = $stage;
		}
		return $stage;
	}

	public function generate(Schema $schema, ...$options) : String {
		$ddl = $this->build($schema->toArray());
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

		foreach ($nodes as $name => $node){
			// drop table definition
			$parent = $this->quote($prefix.$path);
			$table  = $this->quote($prefix.$path.$name);
			$drop   = "\nDROP TABLE $table;";
			$drops .= $this->wrapCheckIfExists($prefix.$path.$name,$drop);

			// open table definition
			$create = "\nCREATE TABLE $table (\n";

			// surrogate parent foreign key
			// TODO: use natural key if unique values
			if (!empty($path)){
				$create .= "	jpetl_pid int,\n";
				$create .= "	CONSTRAINT fk_$prefix$path$name\n";
				$create .= "		FOREIGN KEY (jpetl_pid)\n";
				$create .= "		REFERENCES $parent(jpetl_id),\n";
			}

			// get attributes
			if (isset($node['attributes'])){
				foreach ($node['attributes'] as $key => $attribute){
					$column  = $this->quote($key);
					$create .= "	$column ".$this->getDatatype($attribute);
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
						$column  = $this->quote($key);
						$create .= "	$column ".$this->getDatatype($element);
						// flatten single child attributes
						if (isset($element['attributes'])){
							foreach ($element['attributes'] as $k => $att){
								$column  = $this->quote($key.$k);
								$create .= "	$column ".$this->getDatatype($att);
							}
						}
					}
				}
			} else {
				// get childless element value
				$column  = $this->quote($name);
				$create .= "	$column ".$this->getDatatype($node);
			}

			// close table definition with surrogate primary key
			// TODO: use natural key if unique values
			$create .= "	jpetl_id int IDENTITY PRIMARY KEY\n);";
			$creates .= $this->wrapCheckIfNotExists($prefix.$path.$name,$create);

			// get children and multi-values
			if (isset($recurse)){
				$children = $this->build($recurse, $path.$name);
				$drops = $children['drop'] . $drops;
				$creates .= $children['create'];
				unset($recurse);
			}
		}
		return ['drop' => $drops, 'create' => $creates];
	}

	protected function getDatatype(Array $attribute) : String {
		// TODO: set default datatype
		// TODO: check if 'datatype' override set

		if ($this->validateDatetimes($attribute)){
			$datatype = $attribute['datetime']['max']['value'];
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
		} else {
			return true;
		}

		return ($max === $min);
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
}
