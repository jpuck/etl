<?php

namespace jpuck\etl\Schemata\Datatypes;

interface Datatyper {
	public function getInteger($value) : String;
	public function getDatetime($value);
	public function getVarchar($length = null) : String;
	public function quote(String $entity, Bool $chars = false);
}
