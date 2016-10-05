<?php
namespace jpuck\etl\Data;
use InvalidArgumentException;

class JSON extends Datum {
	protected function parse($raw) : Array {
		$json = json_decode($raw, true);
		if (!is_array($json)){
			throw new InvalidArgumentException(
				"Bad JSON: ".json_last_error_msg()
			);
		}

		$parsed = ['name'=>'root'];

		$this->parseRecursively($json, $parsed);

		return $parsed;
	}

	protected function parseRecursively(Array &$json, Array &$parsed){
		foreach ($json as $key => $value){
			if (is_numeric($key)){
				$name = 'root';
			} else {
				$name = $key;
			}
			if (!is_array($value)){
				$parsed['value'] []= ['name'=>$name,'value'=>$value];
			} else {
				// check if key-value pairs
				foreach ($value as $k => $v){
					if (is_numeric($k) && !is_array($v)){
						$kv = true;
					} else {
						$kv = false;
						break;
					}
				}
				if ($kv){
					// check if plain numerically indexed array
					if ((count($value)-1) === max(array_keys($value))){
						foreach ($value as $k => $v){
							$parsed['value'] []= ['name'=>$name,'value'=>$v];
						}
					} else {
						// else preserve custom keys
						if (isset($parsed['value']) && is_array($parsed['value'])){
							$parsed['value'] = array_merge($parsed['value'],$this->kvflip($name, $value));
						} else {
							$parsed['value'] = $this->kvflip($name, $value);
						}
					}
				} else {
					$parsed['value'] []= ['name'=>$name];
					$index = max(array_keys($parsed['value']));
					$this->parseRecursively($json[$key], $parsed['value'][$index]);
				}
			}
		}
	}

	protected function kvflip(String $name, Array $array) : Array {
		$return = [];
		foreach ($array as $key => $value){
			$return []= [
				'name'  => $name,
				'value' => [
					['name'=>'key',  'value'=>$key],
					['name'=>'value','value'=>$value],
				]
			];
		}
		return $return;
	}
}
