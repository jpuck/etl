<?php
namespace jpuck\etl\Data;

use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Data\ParseValidator;
use jpuck\etl\Utilities\Options;
use Exception;

abstract class Datum {
	use Options;
	protected $raw;
	protected $parsed;
	protected $schema;

	public function __construct($raw, ...$options){
		$defaults = [
			'validate' => [
				'parse' => true
			]
		];
		$this->options($defaults);
		$this->options(...$options);
		$schema = $this->schema ?? null;
		$this->raw($raw, $schema);
	}

	public function raw($raw=null, Schema $override=null){
		if (isset($raw)){
			$this->parsed = $this->parse($raw);

			if ($this->options['validate']['parse']){
				(new ParseValidator)->validate($this->parsed);
			}

			$this->raw = $raw;

			if (isset($override)){
				$this->schema($override);
			} else {
				$schematizer = new Schematizer;
				if(isset($this->options['schematizer'])){
					$schematizer->options($this->options['schematizer']);
				}
				$this->schema($schematizer->schematize($this));
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
