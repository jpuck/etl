<?php
namespace jpuck\etl\Data;

use Sabre\Xml\Reader;

class XML extends Datum {
	protected function parse($raw) : Array {
		$reader = new Reader();
		$reader->xml($raw);
		return $reader->parse();
	}
}
