<?php
namespace jpuck\etl\Schemata\Datatypes;

trait DatatyperHandler {
	protected $datatyper;
	public function datatyper(Datatyper $dt = null){
		if (isset($dt)){
			$this->datatyper = $dt;
		}
		return $this->datatyper;
	}
}
