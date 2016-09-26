<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Data\Datum;
use Exception;
use InvalidArgumentException;
use jpuck\phpdev\Exceptions\Unimplemented;

class REST extends Source {
	/**
	 * @throws InvalidArgumentException
	 */
	protected function validateURI($uri) : Bool {
		if (empty($uri['url'])){
			// TODO: validate URL
			// http://stackoverflow.com/q/206059/4233593
			throw new InvalidArgumentException(
				'base url required.'
			);
		}
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
