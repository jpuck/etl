<?php
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Merger;

class SchemaMergerTest extends PHPUnit_Framework_TestCase {
	public $schemataDir = __DIR__.'/data/schemata';

	public function testCanMergeSchemas(){
		$admin = require "{$this->schemataDir}/admin.schema.php";
		$admin = new Schema($admin);
		$sample = require "{$this->schemataDir}/sample.schema.php";
		$sample = new Schema($sample);
		$expected = require "{$this->schemataDir}/admin.sample.schema.php";

		$merger = new Merger;
		$merged = $merger->merge($admin,$sample);
		$actual = $merged->toArray();

		$this->assertEquals($expected, $actual);
	}

	public function testCanMergeSchemasWithConflicts(){
		$a = require "{$this->schemataDir}/a.schema.php";
		$a = new Schema($a);
		$b = require "{$this->schemataDir}/b.schema.php";
		$b = new Schema($b);
		$expected = require "{$this->schemataDir}/ab.schema.php";

		$merger = new Merger;
		$merged = $merger->merge($a,$b);
		$actual = $merged->toArray();

		$this->assertEquals($expected, $actual);
	}

	public function testCanMergeSchemasWithIntDecimalConflicts(){
		$c = require "{$this->schemataDir}/c.schema.php";
		$c = new Schema($c);
		$d = require "{$this->schemataDir}/d.schema.php";
		$d = new Schema($d);
		$expected = require "{$this->schemataDir}/cd.schema.php";

		$merger = new Merger;
		$merged = $merger->merge($c,$d);
		$actual = $merged->toArray();

		$this->assertEquals($expected, $actual);
	}
}
