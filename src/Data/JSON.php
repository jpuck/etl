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
			if (!is_array($value)){
				$parsed['value'] []= ['name'=>$key,'value'=>$value];
			} else {
				// TODO: check if numerically indexed array
				$parsed['value'] []= ['name'=>$key];
				$index = max(array_keys($parsed['value']));
				$this->parseRecursively($json[$key], $parsed['value'][$index]);
			}
		}
	}
}
