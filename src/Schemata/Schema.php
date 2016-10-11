<?php
namespace jpuck\etl\Schemata;

use InvalidArgumentException;

class Schema {
	/*
		methodName(Type $parameter)            ReturnType $description

		// public
		__construct($schema)                   Schema $schema
		toArray()                              Array  $schema
		toJSON(...$options)                    String $schema
		__toString()                           String $schema
		filter(String ...$filters)             Schema $schema

		// protected
		recurse(&Array, Function)              null
		sort(&Array)                           null

		// // filters
		varchar(&Array, String $key)           null
		mins   (&Array, String $key)           null
		singles(&Array, String $key)           null
		minmax (&Array, String $key)           null
	*/

	protected $complete = [];
	protected $filtered = [];

	public function __construct($schema){
		if (is_string($schema)){
			$schema = json_decode($schema, true);
			if (!is_array($schema)){
				throw new InvalidArgumentException(
					"Bad JSON: ".json_last_error_msg()
				);
			}
		}
		if (is_array($schema)){
			(new Validator)->validate($schema);
			$this->sort($schema);
			$this->filtered = $this->complete = $schema;
		} else {
			throw new InvalidArgumentException(
				"Cannot parse Schema to Array."
			);
		}
	}

	public function toArray(){
		return $this->filtered;
	}

	public function toJSON(...$options){
		return json_encode($this->filtered, ...$options);
	}

	public function __toString(){
		return $this->toJSON(JSON_PRETTY_PRINT);
	}

	public function filter(String ...$filters) : Schema {
		foreach ($filters as $filter){
			if ($filter === 'singles'){
				$this->recurse($this->filtered[key($this->filtered)]['elements'], $filter);
				if (isset($this->filtered[key($this->filtered)]['attributes'])){
					$this->filtered[key($this->filtered)]['attributes'] = [];
				}
			} else {
				$this->recurse($this->filtered, $filter);
			}
		}
		return $this;
	}

	protected static $keys = [
		'unique','distinct','count',
		'max','min','measure','value',
		'datetime','int','decimal','scale','precision','varchar',
		'attributes','children','elements'
	];

	protected function recurse(&$array, $function){
		foreach ($array as $key => $value){
			if (isset($array[$key]['elements'])){
				$this->recurse($array[$key]['elements'], $function);
			}
			if (isset($array[$key]['attributes'])){
				foreach ($array[$key]['attributes'] as $k => $v){
					$this->$function($array[$key]['attributes'], $k);
				}
			}
			if (!($function === 'singles' && isset($array[$key]['elements']))){
				$this->$function($array, $key);
			}
		}
	}

	protected function sort(&$array){
		if (is_array($array)){
			uksort($array, function($a, $b){
				return
					array_search($a,self::$keys)
						<=>
					array_search($b,self::$keys);
			});
			foreach ($array as $key => $value){
				$this->sort($array[$key]);
			}
		}
	}

	//
	// filters
	//

	private function varchar(&$array, $key){
		foreach (['int','decimal','datetime'] as $noVarchar){
			if (
				isset($array[$key][$noVarchar]['max']['value']) &&
					$array[$key][$noVarchar]['max']['value'] !== false
			){
				unset($array[$key]['varchar']);
			}
		}
	}

	private function mins(&$array, $key){
		foreach (self::$keys as $metric){
			if (isset($array[$key][$metric]['min'])){
				unset($array[$key][$metric]['min']);
			}
		}
	}

	private function singles(&$array, $key){
		if (
			!isset($array[$key]['count']['max']['measure']) ||
			       $array[$key]['count']['max']['measure'] <= 1
		){
			 unset($array[$key]);
		}
		if (isset($array[$key]['attributes'])){
			      $array[$key]['attributes'] = [];
		}
	}

	private function minmax(&$array, $key){
		foreach (self::$keys as $metric){
			if (
				isset($array[$key][$metric]['max']['measure']) &&
				isset($array[$key][$metric]['min']['measure']) &&
				(
					$array[$key][$metric]['max']['measure'] ===
					$array[$key][$metric]['min']['measure']
				)
			){
				unset($array[$key][$metric]['min']);
			} elseif (
				!isset($array[$key][$metric]['max']['measure']) &&
					isset($array[$key][$metric]['max'][ 'value' ]) &&
					isset($array[$key][$metric]['min'][ 'value' ]) &&
					(
					$array[$key][$metric]['max']['value'] ===
					$array[$key][$metric]['min']['value']
					)
			){
				unset($array[$key][$metric]['min']);
			}
		}
	}
}
