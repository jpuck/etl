<?php
namespace jpuck\etl\Data;

use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Data\ParseValidator;

abstract class Datum {
	protected $raw;
	protected $parsed;
	protected $schema;
	protected $options = [
		'validate' => [
			'parse' => true
		]
	];

	public function __construct($raw, ...$options){
		if (isset($options)){
			foreach ($options as $option){
				switch (true){
					case ($option instanceof Schema):
						$schema = $option;
						break;
					case (is_bool($option)):
						$this->options['validate']['parse'] = $option;
						break;
					case (is_array($option)):
						$this->options($option);
						break;
				}
			}
		}
		$schema = $schema ?? null;
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

	public function options(Array $options = null) : Array {
		if (isset($options)){
			$this->options = array_replace_recursive($this->options, $options);
		}
		return $this->options;
	}

	abstract protected function parse($raw) : Array;
}
