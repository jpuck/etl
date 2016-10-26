<?php
namespace jpuck\etl\Schemata;

use InvalidArgumentException;

class Validator {

	/**
	 * @throws InvalidArgumentException
	 */
	public function validate(Array $schema) : Bool {
	/*
		must be array [3] with only 1 root node [1]
		must have non-numeric name(s) [2]
			must have *count [4]
				must have max measure [4]
				may  have max value
				may  have min measure, value
			may  have *attributes
				must have non-numeric name(s) [2]
					may  have unique
					may  have datatype(s)
						may  be varchar
							must have max measure, value [5]
							may  have min measure, value
						may  be int, datetime
							must have max value [6]
							may  have min value
						may  be decimal
							must have max value [6]
							may  have min value
							must have scale, precision [7]
								must have max measure, value [7]
								may  have min measure, value
						must not be more than 1 of int, decimal, or datetime [9]
			may  have children
				must have distinct [8]
				must satisfy count [4]
			may  have elements
				must satisfy attributes [2],[5],[6],[7]
				must satisfy count [4]
	*/

		if (count($schema) !== 1){
			throw new InvalidArgumentException(
				'Schema must have only 1 root node.', 1
			);
		}

		$this->recurse($schema);

		return true;
	}

	protected function recurse(&$array){
		foreach ($array as $key => $value){
			$this->validateAttribute([$key => $value]);

			$max_count = $value['count']['max']['measure'] ?? null;
			if (!is_int($max_count) || $max_count < 1){
				throw new InvalidArgumentException(
					'Node must have a positive integer count.', 4
				);
			}

			if (isset($value['attributes'])){
				foreach ($value['attributes'] as $k => $attribute){
					$this->validateAttribute([$k => $attribute]);
				}
			}

			if (isset($value['children'])){
				$distinct = $value['children']['distinct'] ?? null;
				if (!is_int($distinct) || $distinct < 1){
					throw new InvalidArgumentException(
						"children requires distinct positive integer count.", 8
					);
				}

				$count = $value['children']['count']['max']['measure'] ?? null;
				if (!is_int($count) || $count < 1){
					throw new InvalidArgumentException(
						'Node must have a positive integer count.', 4
					);
				}
			}

			if (isset($value['elements'])){
				$this->recurse($value['elements']);
			}
		}
	}

	protected function validateAttribute($attribute){
		foreach ($attribute as $key => $value){
			$this->validateAlphabetic($key);

			if (!is_array($value)){
				throw new InvalidArgumentException(
					'Node value must be an array.', 3
				);
			}

			$this->oneDatatype($value);

			if (isset($value['varchar'])){
				if (
					!isset($value['varchar']['max']['measure']) ||
					!isset($value['varchar']['max']['value'])
				){
					throw new InvalidArgumentException(
						'varchar requires max measure and value.', 5
					);
				}
			}

			foreach (['datetime','int','decimal'] as $datatype){
				if (isset($value[$datatype])){
					if (!isset($value[$datatype]['max']['value'])){
						throw new InvalidArgumentException(
							"$datatype requires max value.", 6
						);
					}
				}
			}

			if (isset($value['decimal'])){
				if (
					!isset($value['scale']['max']['measure']) ||
					!isset($value['scale']['max']['value']) ||
					!isset($value['precision']['max']['measure']) ||
					!isset($value['precision']['max']['value'])
				){
					throw new InvalidArgumentException(
						"decimal requires scale & precision max measure & value.", 7
					);
				}
			}
		}
	}

	protected function validateAlphabetic($num){
		if (is_numeric($num)){
			throw new InvalidArgumentException(
				'Node name cannot be numeric.', 2
			);
		}
	}

	protected function oneDatatype(Array $value){
		// int/decimal & int/datetime
		foreach(['decimal','datetime'] as $datatype){
			if(isset($value['int'], $value[$datatype])){
				throw new InvalidArgumentException(
					"Cannot have both int and $datatype in Schema.", 9
				);
			}
		}

		// decimal/datetime
		if(isset($value['decimal'], $value['datetime'])){
			throw new InvalidArgumentException(
				"Cannot have both decimal and datetime in Schema.", 9
			);
		}
	}
}
