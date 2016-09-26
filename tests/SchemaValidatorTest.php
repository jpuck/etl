<?php
use jpuck\etl\Schemata\Validator;

/**
 *  @testdox Schema Validator
 */
class SchemaValidatorTest extends PHPUnit_Framework_TestCase {
	public $schemataDir = __DIR__.'/data/schemata';
	public $providerDir = __DIR__.'/data/providers';

	public function invalidSchemaDataProvider(){
		return require "{$this->providerDir}/InvalidSchemaDataProvider.php";
	}

	/**
	 *  @testdox Can invalidate Schema with
	 *  @dataProvider invalidSchemaDataProvider
	 */
	public function testCanInvalidateSchema($code, $invalid){
		$validator = new Validator;
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionCode($code);
		$this->assertFalse($validator->validate($invalid));
	}

	public function validSchemaDataProvider(){
		return [
			['sample'],
		];
	}

	/**
	 *  @testdox Can validate Schema
	 *  @dataProvider validSchemaDataProvider
	 */
	public function testCanValidateSchema($schema){
		$validator = new Validator;
		$schema = require "{$this->schemataDir}/$schema.schema.php";
		$this->assertTrue($validator->validate($schema));
	}
}
