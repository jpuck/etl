<?php
namespace jpuck\etl\Sources;

use jpuck\phpdev\Exceptions\Unimplemented;
use jpuck\etl\Data\Datum;
use jpuck\etl\Data\XML;

class REST extends Source {
	/**
	 * @throws InvalidArgumentException
	 * @throws Unimplemented
	 */
	protected function validateURI($uri) : Bool {
		throw new Unimplemented(__METHOD__);
		return true;
	}
	public function fetch (String $endpoint, String $datumClass) : Datum {
		throw new Unimplemented(__METHOD__);
		return new XML;
	}
	public function insert  (Datum $data) : bool {
		throw new Unimplemented(__METHOD__);
		return false;
	}
	public function replace (Datum $data) : bool {
		throw new Unimplemented(__METHOD__);
		return false;
	}
}
