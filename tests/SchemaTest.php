<?php
use jpuck\etl\Schemata\Schema;

class SchemaTest extends PHPUnit_Framework_TestCase {
	public $schemataDir = __DIR__.'/data/schemata';

	public function validSchemaDataProvider(){
		return [
			['sample'],
		];
	}

	/**
	 *  @dataProvider validSchemaDataProvider
	 */
	public function testCanCreateSchema($endpoint){
		$schemaArray = require "{$this->schemataDir}/$endpoint.schema.php";
		$schema = new Schema($schemaArray);
		$this->assertTrue($schema instanceof Schema);
	}

	/**
	 *  @dataProvider validSchemaDataProvider
	 */
	public function testCanShowSchemaArray($endpoint){
		$expected = require "{$this->schemataDir}/$endpoint.schema.php";
		$schema   = new Schema($expected);

		$actual = $schema->toArray();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can export and import JSON
	 *  @dataProvider validSchemaDataProvider
	 */
	public function testCanExportAndImportJSON($endpoint){
		$expected = require "{$this->schemataDir}/$endpoint.schema.php";
		$orig     = new Schema($expected);

		$new      = new Schema($orig->toJSON());
		$actual   = $new->toArray();

		$this->assertEquals($expected, $actual);
	}

	public function filterDataProvider(){
		return [
			'varchar'           => ['varchar'],
			'varchar & mins'    => ['varchar', 'mins'],
			'varchar & singles' => ['varchar', 'singles'],
		];
	}

	/**
	 *  @dataProvider filterDataProvider
	 */
	public function testCanFilter(...$filters){
		$schema = require "{$this->schemataDir}/sample.schema.php";
		$schema = new Schema($schema);

		$expected = 'sample.schema';
		foreach ($filters as $filter){
			$expected .=  ".$filter"; // arrange
			$schema->filter($filter); // act
		}
		$expected = require "{$this->schemataDir}/$expected.php";

		$actual = $schema->toArray();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @dataProvider filterDataProvider
	 */
	public function testCanFilterSplat(...$filters){
		$schema = require "{$this->schemataDir}/sample.schema.php";
		$schema = new Schema($schema);

		$expected = 'sample.schema';
		foreach ($filters as $filter){
			$expected .=  ".$filter";
		}
		$expected = require "{$this->schemataDir}/$expected.php";

		$actual = $schema->filter(...$filters)->toArray();

		$this->assertEquals($expected, $actual);
	}

	public function schemaFormatDataProvider(){
		return [
			'php array'   => [
				require "{$this->schemataDir}/sample.schema.php"
			],
			'php file'    => [
				"{$this->schemataDir}/sample.schema.php"
			],
			'json string' => [
				file_get_contents("{$this->schemataDir}/items.schema.json")
			],
			'json file'   => [
				"{$this->schemataDir}/items.schema.json"
			],
		];
	}

	/**
	 *  @dataProvider schemaFormatDataProvider
	 */
	public function testCanMakeSchemaFromFormat($schema){
		$this->assertTrue(new Schema($schema) instanceof Schema);
	}
}
