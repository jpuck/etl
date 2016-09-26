<?php
namespace jpuck\etl\Sources;

use InvalidArgumentException;

use jpuck\phpdev\Exceptions\Unimplemented;
use jpuck\etl\Data\Datum;
use jpuck\etl\Data\XML;

class Folder extends Source {
	/**
	 * @throws InvalidArgumentException
	 */
	protected function validateURI($uri) : Bool {
		if (!isset($uri['path'])){
			throw new InvalidArgumentException('URI requires a path.');
		}
		if (!is_dir($uri['path'])){
			throw new InvalidArgumentException('URI path does not exist.');
		}
		return true;
	}

	public function fetch (String $endpoint, String $datumClass) : Datum {
		if ($datumClass !== XML::class){
			throw new InvalidArgumentException(
				XML::class." required, $datumClass given."
			);
		}

		return new XML(file_get_contents("{$this->uri['path']}/$endpoint"));
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
