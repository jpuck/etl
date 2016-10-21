<?php
namespace jpuck\etl\Schemata;

class Merger {
	public function merge(Schema $base, Schema ...$acquisitions) : Schema {
		// handle the arguments, merge one by one
		$merged = $base->toArray();
		foreach($acquisitions as $acquisition) {
			$merged = $this->array_compare_recursive(
				$merged,
				$acquisition->toArray()
			);
		}
		return new Schema($merged);
	}

	// http://php.net/manual/en/function.array-replace-recursive.php#92574
	protected function array_compare_recursive(&$array, $array1) {
		if(isset($array)){
			$this->unsetDatatypeConflicts($array, $array1);
		}
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
				$value = $this->array_compare_recursive($array[$key], $value);
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

	protected function unsetDatatypeConflicts(Array &$a, Array &$b){
		foreach(['int','decimal'] as $datatype){
			if (isset($a['datetime'], $b[$datatype])){
				unset($a['datetime'], $b[$datatype]);
			}
			if (isset($a[$datatype], $b['datetime'])){
				unset($a[$datatype], $b['datetime']);
			}
		}
	}
}
