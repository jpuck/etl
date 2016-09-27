<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Sources\Transceiver;

abstract class Source implements Transceiver {
	protected $uri;

	public function __construct($uri){
		$this->uri($uri);
	}

	public function uri($uri=null){
		if (isset($uri)){
			if ($this->validateURI($uri)){
				$this->uri = $uri;
			}
		}
		return $this->uri;
	}

	/**
	 * @throws InvalidArgumentException
	 */
	abstract protected function validateURI($uri) : Bool;
}
