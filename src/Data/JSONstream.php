<?php
namespace jpuck\etl\Data;
use InvalidArgumentException;
use jpuck\etl\Schemata\Merger;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Utilities\Options;
use jpuck\phpdev\Functions as jp;

class JSONstream {
	use Options;
	protected $file;
	protected $schema;
	protected $cursor = 0;

	public function __construct(String $file, ...$options){
		$this->options(...$options);
		$this->file = fopen($file, 'r');
		if (!$this->file){
			throw new InvalidArgumentException("Failed to open $file");
		}
		$this->assertResource($this->file);
	}

	public function __destruct() {
		fclose($this->file);
	}

	public function fetch(Int $count = null){
		$opts []= $this->schema ?? ['schematizer'=>['unique'=>false]];
		if(isset($this->options['name'])){
			$opts []= ['name' => $this->options['name']];
		}
		while (($line = fgets($this->file)) !== false){
			$this->cursor++;
			if(isset($count) && $this->cursor > $count){
				break;
			}
			return new JSON($line, ...$opts);
		}
		fseek($this->file, 0);
		$this->cursor = 0;
		return false;
	}

	public function schematize(Int $count = null) : Schema {
		$merger = new Merger;
		while($json = $this->fetch($count)){
			if(empty($schema)){
				$schema = $json->schema();
			} else {
				$schema = $merger->merge($schema,$json->schema());
			}
		}
		return $this->schema = $schema;
	}

	public function combine(Int $count = null){
		$i = 1;
		$json = "[";
		while (($row = fgets($this->file)) !== false){
			$json .= $row;
			if (isset($count) && ++$i > $count){
				break;
			} else {
				$json .= ',';
			}
		}
		$json .= "]";
		fseek($this->file, 0);
		return $json;
	}

	public function count(String $elem = null) : Int {
		if (!isset($elem)){
			return $this->countLines();
		}
		$max = 0;
		while (($row = fgets($this->file)) !== false) {
			$arr = json_decode($row, true);
			if (isset($arr[$elem])){
				$max = max($max,count($arr[$elem]));
			}
		}
		fseek($this->file, 0);
		return $max;
	}

	public function countLines() : Int {
		$i = 0;
		while (($row = fgets($this->file)) !== false) {
			$i++;
		}
		fseek($this->file, 0);
		return $i;
	}

	public function print(Int $count = null){
		$i = 1;
		while (($row = fgets($this->file)) !== false){
			$arr = json_decode($row, true);
			jp::print_rt($arr);
			if (isset($count) && ++$i > $count){
				break;
			}
		}
		fseek($this->file, 0);
	}

	protected function assertResource($resource){
		// http://stackoverflow.com/a/38430606/4233593
		if (false === is_resource($resource)) {
			throw new InvalidArgumentException(
				sprintf(
					'Argument must be a valid resource type. %s given.',
					gettype($resource)
				)
			);
		}
	}
}
