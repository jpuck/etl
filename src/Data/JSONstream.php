<?php
namespace jpuck\etl\Data;
use InvalidArgumentException;
use jpuck\phpdev\Functions as jp;

class JSONstream {
	protected $file;

	public function __construct(String $file){
		$this->file = fopen($file, 'r');
		if (!$this->file){
			throw new InvalidArgumentException("Failed to open $file");
		}
		$this->assertResource($this->file);
	}

	public function __destruct() {
		fclose($this->file);
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
