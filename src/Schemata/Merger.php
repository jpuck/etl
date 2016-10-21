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
	protected function array_compare_recursive(Array &$base = null, Array $acquisition) : Array {
		if(isset($base)){
			$this->unsetDatatypeConflicts($base, $acquisition);
		}
		foreach ($acquisition as $key => $value) {
			// create new key in $base, if it is empty
			if (!isset($base[$key])) {
				$base[$key] = null;
			}

			// overwrite the value in the base array
			if (
				is_array($value) &&
				!(isset($value['max']) && isset($base[$key]['max']))
			) {
				$value = $this->array_compare_recursive($base[$key], $value);
			}

			// compare optional minimums
			if (isset($value['min']) && isset($base[$key]['min'])) {
				$a = $base[$key]['min']['measure'] ?? $base[$key]['min']['value'];
				$b = $value['min']['measure'] ?? $value['min']['value'];
				if (($a <=> $b) > 0) {
					$base[$key]['min'] = $value['min'];
				}
			}

			// compare max if exists
			if (isset($value['max']) && isset($base[$key]['max'])) {
				$a = $base[$key]['max']['measure'] ?? $base[$key]['max']['value'];
				$b = $value['max']['measure'] ?? $value['max']['value'];
				if (($a <=> $b) < 0) {
					$base[$key]['max'] = $value['max'];
				}
			} else {
				if ($key === 'distinct') {
					$base[$key] = max($base[$key],$value);
				} else {
					$base[$key] = $value;
				}
			}
		}

		return $base;
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
