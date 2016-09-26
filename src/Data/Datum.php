<?php
namespace jpuck\etl\Data;

use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;

abstract class Datum {
	protected $raw;
	protected $parsed;
	protected $schema;

	public function __construct($raw, Schema $override=null){
		$this->raw($raw, $override);
	}

	public function raw($raw=null, Schema $override=null){
		if (isset($raw)){
			$this->parsed = $this->parse($raw);
			$this->raw = $raw;
			if (isset($override)){
				$this->schema($override);
			} else {
				$this->schema((new Schematizer)->schematize($this));
			}
		}
		return $this->raw;
	}

	public function parsed() : Array {
		return $this->parsed;
	}

	public function schema(Schema $schema=null) : Schema {
		if (isset($schema)){
			$this->schema = $schema;
		}
		return $this->schema;
	}

	abstract protected function parse($raw) : Array;
}
