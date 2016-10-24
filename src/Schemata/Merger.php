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
			$this->resolveDatatypeConflicts($base, $acquisition);
		}

		foreach ($acquisition as $key => $aValue) {
			// create new key in $base, if it is empty
			if (!isset($base[$key])) {
				$base[$key] = null;
			}

			// overwrite the value in the base array
			if (
				is_array($aValue) &&
				!(isset($aValue['max']) && isset($base[$key]['max']))
			) {
				$aValue = $this->array_compare_recursive($base[$key], $aValue);
			}

			// compare max if exists
			if (isset($aValue['max']) && isset($base[$key]['max'])) {
				$oldBaseMax = $base[$key]['max'];
				$bMax = $base[$key]['max']['measure'] ?? $base[$key]['max']['value'];
				$aMax = $aValue['max']['measure'] ?? $aValue['max']['value'];
				if (($bMax <=> $aMax) < 0) {
					$base[$key]['max'] = $aValue['max'];
				}
			} else {
				if ($key === 'distinct') {
					$base[$key] = max($base[$key],$aValue);
				} else {
					$base[$key] = $aValue;
				}
				continue;
			}

			// compare optional minimums
			$bMin = $base[$key]['min']['measure'] ?? $base[$key]['min']['value'] ?? null;
			$aMin = $aValue['min']['measure'] ?? $aValue['min']['value'] ?? null;

			// if both min set
			if (isset($aMin, $bMin)) {
				if (($bMin <=> $aMin) > 0) {
					$base[$key]['min'] = $aValue['min'];
				}
				continue;
			}

			// if only acquisition min and no base min
			// if old base max < acquisition min,
			// then base min = old base max
			if(isset($aMin)){
				if (($bMax <=> $aMin) < 0) {
					$base[$key]['min'] = $oldBaseMax;
				} else {
					$base[$key]['min'] = $aValue['min'];
				}
				continue;
			}

			// if only $base min,
			// if acquisition max is less than base min,
			// then set acquisition max as new min
			if(isset($bMin)){
				if (($bMin <=> $aMax) > -1) {
					$base[$key]['min'] = $aValue['max'];
				}
				continue;
			}

			// if no min, then compare maxes to set min
			if($bMax !== $aMax){
				if($bMax < $aMax){
					$base[$key]['min'] = $oldBaseMax;
				} else {
					$base[$key]['min'] = $aValue['max'];
				}
			}
		}

		return $base;
	}

	protected function resolveDatatypeConflicts(Array &$a, Array &$b){
		$this->unsetDatetimeConflicts($a, $b);
		$this->unsetDatetimeConflicts($b, $a);
		$this->unsetNumericConflicts($a, $b);
		$this->unsetNumericConflicts($b, $a);
		$this->mergeIntegerDecimalMeasures($a, $b);
		$this->mergeIntegerDecimalMeasures($b, $a);
	}

	protected function unsetDatetimeConflicts(Array &$a, Array &$b){
		foreach ( ['int', 'decimal'] as  $datatype){
			if (isset($a['datetime'], $b[$datatype])){
				unset($a['datetime'], $b[$datatype]);
			}
		}
	}

	protected function unsetNumericConflicts(Array &$a, Array &$b){
		foreach(['int','decimal'] as $number){
			if(isset($a[$number])){
				if(!is_numeric($b['varchar']['max']['value'])){
					unset($a[$number]);
					break;
				}
				if(!isset($b['varchar']['min']['value'])){
					continue;
				}
				if(!is_numeric($b['varchar']['min']['value'])){
					unset($a[$number]);
					return;
				}
			}
		}
	}

	protected function mergeIntegerDecimalMeasures(Array &$a, Array &$b){
		if (isset($a['int'], $b['decimal'])){
			$a['decimal'] = [];

			$this->setValues($a['int'], $b['decimal'], $a['decimal']);
			$this->setScales($a, $b);

			// max precision is the same
			$a['precision'] = $b['precision'];
			// min precision is: measure = 0, value = max(int)
			$a['precision']['min']['measure'] = 0;
			$a['precision']['min']['value'] = $a['int']['max']['value'];

			// unset int
			$b['decimal'] = $a['decimal'];
			unset($a['int']);
		}
	}

	protected function setValues(Array &$int, Array &$dec, Array &$fin){
		// max value
		$fin['max']['value'] = max(
			$int['max']['value'],
			$dec['max']['value']
		);

		// min value
		// if both mins set
		if(isset($int['min']['value'], $dec['min']['value'])){
			$fin['min']['value'] = min(
				$int['min']['value'],
				$dec['min']['value']
			);
		}
		// if only int min set, compare with decimal max
		elseif(isset($int['min']['value'])){
			$fin['min']['value'] = min(
				$int['min']['value'],
				$dec['max']['value']
			);
		}
		// if only decimal min set, compare with int max
		elseif(isset($dec['min']['value'])){
			$fin['min']['value'] = min(
				$int['max']['value'],
				$dec['min']['value']
			);
		}
	}

	protected function setScales(Array &$a, Array &$b){
		// max
		// if int min
		if(isset($a['int']['min']['value'])){
			$maxScale = $this->evaluateScale(
				$a['int']['max']['value'],
				$a['int']['min']['value']
			);
		} else {
			$maxScale = [$a['int']['max']['value']];
		}
		// compare decimal
		$maxScale = $this->evaluateScale(
			$maxScale[0],
			$b['scale']['max']['value']
		);
		$a['scale']['max'][ 'value' ] = $maxScale[0];
		$a['scale']['max']['measure'] = $maxScale[1];

		// min
		// if int min
		if(isset($a['int']['min']['value'])){
			$minScale = $this->evaluateScale(
				$a['int']['max']['value'],
				$a['int']['min']['value'],
				true
			);
		} else {
			$maxVal = $a['int']['max']['value'];
			$minScale = [$maxVal, Schematizer::getPrecision($maxVal)[0]];
		}
		// compare decimal
		if(isset($b['scale']['min']['value'])){
			$minScale = $this->evaluateScale(
				$minScale[0],
				$b['scale']['min']['value'],
				true
			);
		} else {
			$minScale = $this->evaluateScale(
				$minScale[0],
				$b['scale']['max']['value'],
				true
			);
		}
	}

	protected function evaluateScale(Float $a, Float $b, Bool $min = false) : Array {
		$scale[0] = $scale[1] = [$a, Schematizer::getPrecision($a)[0]];
		$scale[-1] = [$b, Schematizer::getPrecision($b)[0]];

		$champion = $scale[1][1] <=> $scale[-1][1];

		if($min){
			$champion = 0 - $champion;
		}

		return $scale[$champion];
	}
}
