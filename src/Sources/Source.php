<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Sources\Transceiver;
use jpuck\etl\Schemata\Datatypes\Datatyper;

abstract class Source implements Transceiver {
	protected $uri;
	protected $datatyper;

	public function __construct($uri, ...$options){
		$this->uri($uri);
		foreach ($options as $option){
			if ($option instanceof Datatyper){
				$this->datatyper($option);
			}
		}
	}

	public function uri($uri=null){
		if (isset($uri)){
			if ($this->validateURI($uri)){
				$this->uri = $uri;
			}
		}
		return $this->uri;
	}

	public function datatyper(Datatyper $dt = null){
		if (isset($dt)){
			$this->datatyper = $dt;
		}
		return $this->datatyper;
	}

	protected function quote(String $entity, Bool $chars = false){
		if (isset($this->datatyper)){
			return $this->datatyper->quote($entity, $chars);
		}
		if ($chars){
			return ['',''];
		}
		return $entity;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	abstract protected function validateURI($uri) : Bool;
}
