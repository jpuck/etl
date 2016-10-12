<?php
namespace jpuck\etl\Sources;

abstract class Source {
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
