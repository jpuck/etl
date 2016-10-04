<?php
use jpuck\etl\Data\ParseValidator;

/**
 *  @testdox Parse Validator
 */
class ParseValidatorTest extends PHPUnit_Framework_TestCase {
	public $providerDir = __DIR__.'/data/providers';

	public function invalidDataProvider(){
		return require "{$this->providerDir}/ParsedInvalidDataProvider.php";
	}

	/**
	 *  @testdox Can invalidate parsed data with
	 *  @dataProvider invalidDataProvider
	 */
	public function testCanInvalidateParsedData($code, $parsed){
		$validator = new ParseValidator;
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionCode($code);
		$this->assertFalse($validator->validate($parsed));
	}

	public function validDataProvider(){
		return require "{$this->providerDir}/ParsedValidDataProvider.php";
	}

	/**
	 *  @testdox Can validate parsed data with
	 *  @dataProvider validDataProvider
	 */
	public function testCanValidateParsedData($parsed){
		$validator = new ParseValidator;
		$this->assertTrue($validator->validate($parsed));
	}
}
