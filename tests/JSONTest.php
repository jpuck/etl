<?php
use jpuck\etl\Data\JSON;

/**
 * @testdox JSON
 */
class JSONTest extends PHPUnit_Framework_TestCase {
	public $jsonDir = __DIR__.'/data/json';

	/**
	 * @testdox Can create JSON
	 */
	public function testCanCreateJSON(){
		$raw  = file_get_contents("{$this->jsonDir}/item.json");
		$json = new JSON($raw);
		$this->assertTrue($json instanceof JSON);
	}

	/**
	 * @testdox Can create JSON from array of objects
	 */
	public function testCanCreateJSONfromArrayOfObjects(){
		$raw  = file_get_contents("{$this->jsonDir}/items.json");
		$json = new JSON($raw);
		$this->assertTrue($json instanceof JSON);
	}

	/**
	 * @testdox Can create JSON with name
	 */
	public function testCanCreateJSONwithName(){
		$raw = file_get_contents("{$this->jsonDir}/item.json");
		$schema = "{$this->jsonDir}/../schemata/item.schema.json";
		$expected = file_get_contents($schema);

		$json = new JSON($raw, ['name'=>'item']);
		$actual = $json->schema()->filter('minmax')->toJSON(JSON_PRETTY_PRINT);

		$this->assertSame($expected, $actual);
	}
}
