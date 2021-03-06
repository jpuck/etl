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

		if (is_array($array['name'])){
			throw new InvalidArgumentException(
				'Name value cannot be an array.', 5
			);
		}

		if (empty($array['name'])){
			throw new InvalidArgumentException(
				'Name value cannot be empty.', 6
			);
		}

		if (is_numeric($array['name'])){
			throw new InvalidArgumentException(
				'Name cannot be numeric.', 7
			);
		}

		if (!is_string($array['name'])){
			throw new InvalidArgumentException(
				'Name must be a string.', 8
			);
		}

		if (!array_key_exists('value',$array)){
			throw new InvalidArgumentException(
				'Array must have "value" index.', 2
			);
		}

		if (isset($array['attributes'])){
			if (!is_array($array['attributes'])){
				throw new InvalidArgumentException(
					'Attributes must be an array.', 3
				);
			}

			foreach ($array['attributes'] as $key=>$val){
				if (is_numeric($key)){
					throw new InvalidArgumentException(
						'Attributes must not be numerically indexed.', 4
					);
				}
			}
		}

		if (is_array($array['value'])){
			foreach ($array['value'] as $value){
				$this->validate($value);
			}
		}

		return true;
	}
}
