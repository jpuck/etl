<?php
namespace jpuck\etl\Schemata\DBMS;

trait MicrosoftSQLServerTrait {
	public function quote(String $entity, Bool $chars = false){
		if ($chars) {
			return ['[',']'];
		}
		return "[$entity]";
	}
}
