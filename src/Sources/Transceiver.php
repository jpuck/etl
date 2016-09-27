<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Data\Datum;
use jpuck\etl\Schemata\Schema;

interface Transceiver {
	public function fetch  (String $endpoint, String $datumClass, Schema $schema = null) : Datum;
	public function insert (Datum  $data)     : Bool;
	public function replace(Datum  $data)     : Bool;
}
