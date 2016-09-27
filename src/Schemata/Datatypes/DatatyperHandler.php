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

	protected $prefix = '';
	public function prefix(String $prefix = null) : String {
		if (isset($prefix)){
			$this->prefix = $prefix;
		}
		return $this->prefix;
	}
}
