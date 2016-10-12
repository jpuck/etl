<?php
namespace jpuck\etl\Utilities;
use jpuck\etl\Schemata\Schema;

trait Options {
	protected $options = [];
	public function options(...$options) : Array {
		if (isset($options)){
			foreach ($options as $option){
				switch (true){
					case ($option instanceof Schema):
						$this->schema = $option;
						break;
					case (is_array($option)):
						$this->options = array_replace_recursive(
							$this->options, $option
						);
						break;
				}
			}
		}
		return $this->options;
	}
}
