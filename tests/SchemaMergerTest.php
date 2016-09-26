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
}
