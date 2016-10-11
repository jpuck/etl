<?php
use jpuck\etl\Data\JSON;
use jpuck\etl\Data\JSONstream;
use jpuck\etl\Schemata\Schema;

/**
 * @testdox JSON stream
 */
class JSONstreamTest extends PHPUnit_Framework_TestCase {
	protected static $data = __DIR__.'/data';

	/**
	 * @testdox Can get count of JSON list
	 */
	public function testCanGetCountOfJSONlist(){
		$expected = 3;
		$list     = self::$data."/json/items.json.lst";

		$jstream  = new JSONstream($list);
		$actual   = $jstream->count();

		$this->assertSame($expected, $actual);
	}

	/**
	 * @testdox Can create schema from list of JSON
	 */
	public function testCanCreateSchemaFromListOfJSON(){
		$expected = file_get_contents(
			self::$data."/schemata/items.schema.json"
		);
		$expected = json_decode($expected, true);
		$list     = self::$data."/json/items.json.lst";

		$jstream  = new JSONstream($list);
		$actual   = $jstream->schematize()->toArray();

		$this->assertEquals($expected, $actual);
	}

	/**
	 * @testdox Can fetch list of JSON
	 */
	public function testCanFetchListOfJSON(){
		$list    = self::$data."/json/items.json.lst";

		$jstream = new JSONstream($list);
		while($json = $jstream->fetch()){
			$this->assertTrue($json instanceof JSON);
		}
	}

	/**
	 * @testdox Can fetch chunked list of JSON
	 */
	public function testCanFetchChunkedListOfJSON(){
		$list  = self::$data."/json/items.json.lst";
		$count = 2;
		$i = 0;

		$jstream = new JSONstream($list);
		while($json = $jstream->fetch($count)){
			$this->assertTrue($json instanceof JSON);
			$i++;
		}
		$this->assertSame($i,$count);
	}

	/**
	 * @testdox Can fetch list of JSON with Schema
	 */
	public function testCanFetchListOfJSONwithSchema(){
		$expected = file_get_contents(
			self::$data."/schemata/items.schema.json"
		);
		$expected = new Schema($expected);
		$list     = self::$data."/json/items.json.lst";

		$jstream  = new JSONstream($list, $expected);
		while($json = $jstream->fetch()){
			$this->assertEquals($expected, $json->schema());
		}
	}
}
