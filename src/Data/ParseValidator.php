<?php
namespace jpuck\etl\Data;
use InvalidArgumentException;

class ParseValidator {
	public function validate(Array $array) : Bool {
		if (!array_key_exists('name',$array)){
			throw new InvalidArgumentException(
				'Array must have "name" index.', 1
			);
		}

		if (!array_key_exists('value',$array)){
			throw new InvalidArgumentException(
				'Array must have "value" index.', 2
			);
		}

		return true;
	}
}
