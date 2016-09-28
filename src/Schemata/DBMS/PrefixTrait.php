<?php
namespace jpuck\etl\Schemata\DBMS;

trait PrefixTrait {
	protected $prefix = '';

	public function prefix(String $prefix = null) : String {
		if (isset($prefix)){
			$this->prefix = $prefix;
		}
		return $this->prefix;
	}
}
