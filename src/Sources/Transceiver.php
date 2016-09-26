<?php
namespace jpuck\etl\Sources;

use jpuck\etl\Data\Datum;

interface Transceiver {
	public function fetch  (String $endpoint, String $datumClass) : Datum;
	public function insert (Datum  $data)     : Bool;
	public function replace(Datum  $data)     : Bool;
}
