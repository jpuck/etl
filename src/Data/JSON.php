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

		foreach ($json as $key => $value){
			if (!is_array($value)){
				$parsed['value'] []= ['name'=>$key,'value'=>$value];
			}
		}

		return $parsed;
	}
}
