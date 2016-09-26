<?php
namespace jpuck\etl\Schemata;

class Merger {
	public function merge(Schema $a, Schema $b) : Schema {
		$temp = $this->array_compare_recursive($a->toArray(),$b->toArray());
		return new Schema($temp);
	}

	// http://php.net/manual/en/function.array-replace-recursive.php#92574
	protected function array_compare_recursive($base, $replacements){
		// handle the arguments, merge one by one
		$args = func_get_args();
		$array = $args[0];
		if (!is_array($array)) {
			return $array;
		}
		for ($i = 1; $i < count($args); $i++) {
			if (is_array($args[$i])) {
				$array = $this->recurse($array, $args[$i]);
			}
		}
		return $array;
	}

	protected function recurse($array, $array1) {
		foreach ($array1 as $key => $value) {
			// create new key in $array, if it is empty
			if (!isset($array[$key])) {
				$array[$key] = null;
			}

			// overwrite the value in the base array
			if (
				is_array($value) &&
				!(isset($value['max']) && isset($array[$key]['max']))
			) {
				$value = $this->recurse($array[$key], $value);
			}

			// compare optional minimums
			if (isset($value['min']) && isset($array[$key]['min'])) {
				$a = $array[$key]['min']['measure'] ?? $array[$key]['min']['value'];
				$b = $value['min']['measure'] ?? $value['min']['value'];
				if (($a <=> $b) > 0) {
					$array[$key]['min'] = $value['min'];
				}
			}

			// compare max if exists
			if (isset($value['max']) && isset($array[$key]['max'])) {
				$a = $array[$key]['max']['measure'] ?? $array[$key]['max']['value'];
				$b = $value['max']['measure'] ?? $value['max']['value'];
				if (($a <=> $b) < 0) {
					$array[$key]['max'] = $value['max'];
				}
			} else {
				if ($key === 'distinct') {
					$array[$key] = max($array[$key],$value);
				} else {
					$array[$key] = $value;
				}
			}
		}

		return $array;
	}
}
