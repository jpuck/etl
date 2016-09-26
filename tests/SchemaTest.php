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
}
