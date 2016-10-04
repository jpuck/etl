<?php
namespace jpuck\etl\Schemata;

use jpuck\etl\Data\Datum;

class Schematizer {
	/*
		methodName(Type $parameter)            ReturnType $description

		// public static
		stripNamespace (String  $string)       String $stripped
		getPrecision   (Numeric $value)        Array(Int $scale, Int $precision)

		// public
		schematize (String $xml, ...$options)  Array $result

		// private
		measure (Array &$array, Array &$result)                            null
			evaluate  ($value, &$result)                                   null
			setMinMax (&$array, Array $candidate)                          null
			compare   (Arr $incumbent, Arr $contender, Arr $options=null)  Array
		filter  (&$array, $function)                                       null
			dropFalseElements    (Array &$array, $key)                     null
			dropDateIfNum        (Array &$array, $key)                     null
			dropDateMeasures     (Array &$array, $key)                     null
			setIntOrDecimal      (Array &$array, $key)                     null
			dropMinIfEqualsMax   (Array &$array, $key)                     null
	*/
	protected $datum;

	public static function stripNamespace(String $string){
		return preg_replace("/(^{.*?})/", "", $string);
	}

	public static function getPrecision($value){
		if (!is_numeric($value)){
			return [false,false];
		}

		$precision = (strrpos($value,'.') === false) ? 0 : strlen(
			substr(
				$value,
				strrpos($value,'.')+1
			)
		);

		$scale = strlen(
			str_replace(
				['-','.'],
				'',
				$value
			)
		) - $precision;

		return [(int)$scale,(int)$precision];
	}

	public function schematize(Datum $datum) : Schema {
		$array[0] = $datum->parsed();

		// get root node name
		$root = $this->stripNamespace($array[0]['name']);

		$this->measure($array, $result);

		$this->filter($result, 'countDistinctChildren');

		$this->filter($result, 'dropFalseElements');

		$this->filter($result, 'dropDateIfNum');

		$this->filter($result, 'dropDateMeasures');

		$this->filter($result, 'setIntOrDecimal');

			$this->filter($result, 'dropMinIfEqualsMax');

		$this->filter($result, 'unique');

		return new Schema($result);
	}

	//
	// PRIVATE
	//

	private static $keys = [
		'count','varchar','datetime','int','decimal','scale','precision',
		'attributes','children','elements'
	];

	private function measure(&$array, &$result){
		$local = [];
		// get collection of subnodes
		foreach ($array as $node){
			$name = $this->stripNamespace($node['name']);

			// get count of distinct subnodes
			if (empty($local[$name]['count']['max']['measure'])){
				      $local[$name]['count']['max']['measure'] = 1;
			} else {
				      $local[$name]['count']['max']['measure']++;
			}

			// get attributes
			if (!empty($node['attributes'])){
				foreach ($node['attributes'] as $key => $val){
					$key = $this->stripNamespace($key);
					$this->evaluate($val, $result[$name]['attributes'][$key]);
				}
			}

			// recurse or evaluate
			if (is_array($node['value'])){
				$this->measure( $node['value'], $result[$name]['elements']);
			} else {
				$this->evaluate($node['value'], $result[$name]);
			}
		}

		// max and min count
		if (is_array($result)){
			$local = array_merge($result,$local);
		}
		foreach ($local as $name => $value){
			$candidate['measure'] = $local[$name]['count']['max']['measure'] ?? 0;
			$this->setMinMax($result[$name]['count'], $candidate);
		}
	}

		private function evaluate($value, &$result){
			if (isset($value)){
				$candidate['value'] = $value;
				$result['unique'] []= $value;

				// varchar
				$candidate['measure'] = strlen($value);
				$this->setMinMax($result['varchar'], $candidate);

				// datetime
				    $candidate['measure'] = strtotime($value);
				if ($candidate['measure'] === false){
					$result['datetime'] = false;
				} else {
					$this->setMinMax($result['datetime'], $candidate);
				}

				// skip to next if non-numeric
				$numeric_attributes = ['number','scale','precision'];
				if (!is_numeric($value)){
					foreach ($numeric_attributes as $attribute) {
						$result[$attribute] = false;
					}
					return;
				}
				// skip if any previous are non-numeric
				foreach ($numeric_attributes as $attribute) {
					if (
						isset($result[$attribute]) &&
							$result[$attribute] === false
					){
						return;
					}
				}

				// number
				unset($candidate['measure']);
				$this->setMinMax($result['number'], $candidate);

				// scale and precision
				foreach (['scale','precision'] as $index => $sp) {
					$candidate['measure'] = $this->getPrecision($value)[$index];
					$this->setMinMax($result[$sp], $candidate);
				}
			}
		}

		private function setMinMax(&$array, Array $candidate){
			// no max
			if(empty($array['max'])){
				$array['max'] = $candidate;
				$array['min'] = $candidate;
				return;
			}

			// new max
			if ($candidate === $this->compare($array['max'],$candidate)){
				$array['max'] = $candidate;
				return;
			}

			// new min
			if($candidate === $this->compare($array['min'],$candidate,['min'])){
				$array['min'] = $candidate;
				return;
			}
		}

			private function compare($incumbent, $contender, $options=null){
				// use measure if set, else use value
				$metric = 'measure';
				if (!isset($incumbent['measure'])){
					$metric = 'value';
				}

				// evaluate
				$champion = $contender[$metric] <=> $incumbent[$metric];

				// optional minimum
				if (is_array($options) && in_array('min', $options)){
					if ($champion < 0){
						return $contender;
					} else {
						return $incumbent;
					}
				}

				// default maximum
				if ($champion > 0){
					return $contender;
				} else {
					return $incumbent;
				}
			}

	private function filter(&$array, $function){
		foreach ($array as $key => $value){
			if (isset($array[$key]['elements'])){
				$this->filter($array[$key]['elements'], $function);
			}
			if (isset($array[$key]['attributes'])){
				foreach ($array[$key]['attributes'] as $k => $v){
					$this->$function($array[$key]['attributes'], $k);
				}
			}
			$this->$function($array, $key);
		}
	}

		private function unique(&$array, $key){
			if (isset($array[$key]['unique'])){
				if (
					count(              $array[$key]['unique']) ===
					count( array_unique($array[$key]['unique']) )
				){
						$array[$key]['unique'] = 1;
				} else {
					unset($array[$key]['unique']);
				}
			}
		}

		private function dropMinIfEqualsMax(&$array, $key){
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

		private function dropFalseElements(&$array, $key){
			foreach ($array[$key] as $k => $v){
				if ($v === false){
					unset($array[$key][$k]);
				}
			}
		}

		private function dropDateIfNum(&$array, $key){
			if (isset($array[$key]['number']['max']['value'])){
				unset($array[$key]['datetime']);
			}
		}

		private function dropDateMeasures(&$array, $key){
			if (isset($array[$key]['datetime']['max']['measure'])){
				unset($array[$key]['datetime']['max']['measure']);
			}
			if (isset($array[$key]['datetime']['min']['measure'])){
				unset($array[$key]['datetime']['min']['measure']);
			}
		}

		private function setIntOrDecimal(&$array, $key){
			// validate number
			if (
				!isset($array[$key]['number']['max']['value']) ||
					   $array[$key]['number']['max']['value'] === false
			){
				return;
			}

			// int
			if ($array[$key]['precision']['max']['measure'] === 0){
				$array[$key]['int'] = $array[$key]['number'];
				                unset($array[$key]['number']);
				unset($array[$key]['scale']);
				unset($array[$key]['precision']);
				return;
			}

			// decimal
			$array[$key]['decimal'] = $array[$key]['number'];
			                    unset($array[$key]['number']);
		}

		private function countDistinctChildren(&$array, $key){
			if (isset($array[$key]['elements'])){
				// distinct
				$array[$key]['children']['distinct'] = count($array[$key]['elements']);
				// counts
				$max = $min = 0;
				foreach ($array[$key]['elements'] as $element){
					$max += $element['count']['max']['measure'];
					if (isset(  $element['count']['min']['measure'])){
						$min += $element['count']['min']['measure'];
					} else {
						$min += $element['count']['max']['measure'];
					}
				}
				$array[$key]['children']['count']['max']['measure'] = $max;
				if ($max !== $min){
					$array[$key]['children']['count']['min']['measure'] = $min;
				}
			}
		}
}
