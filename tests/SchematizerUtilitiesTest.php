<?php

use jpuck\etl\Schemata\Schematizer;

/**
 * @testdox Schematizer Utilities
 */
class SchematizerUtilitiesTest extends PHPUnit_Framework_TestCase
{
	public $providerDir = __DIR__.'/data/providers';

	public function namespaceDataProvider(){
		return [
			["{http://example.com}EXAMPLE",   "EXAMPLE"],
			["{}EXAMPLE",                     "EXAMPLE"],
			["EXAMPLE",                       "EXAMPLE"],
			["{http://example.com}EXA{M}PLE", "EXA{M}PLE"],
			["{http://example.com}EXA{MPLE",  "EXA{MPLE"],
			["{http://example.com}EXAM}PLE",  "EXAM}PLE"],
			["EXA{M}PLE",                     "EXA{M}PLE"],
			["EXAM}PLE",                      "EXAM}PLE"],
			["EXA{MPLE",                      "EXA{MPLE"],
			[1,                               "1"],
		];
	}

	/**
	 *  @dataProvider namespaceDataProvider
	 */
	public function testCanStripNamespace($value, $expected){
		$actual = Schematizer::stripNamespace($value);
		$this->assertSame($expected,$actual);
	}

	public function precisionDataProvider(){
		return [
			[0,           [1,0]],
			[12.21,       [2,2]],
			[12,          [2,0]],
			[ 111.000,    [3,0]], // raw floats lose precision
			['111.000',   [3,3]], // but not strings!
			[ 333.300,    [3,1]],
			['333.300',   [3,3]],
			[-23.45,      [2,2]],
			[-69,         [2,0]],
			["one",       [false,false]],
			["something", [false,false]],
			[false,       [false,false]],
			[true,        [false,false]],
		];
	}

	/**
	 *  @dataProvider precisionDataProvider
	 */
	public function testCanGetPrecision($value, $expected){
		$actual = Schematizer::getPrecision($value);
		$this->assertSame($expected,$actual);
	}

	public function comparisonDataProvider(){
		return require "{$this->providerDir}/ValueComparisonDataProvider.php";
	}

	/**
	 *  @dataProvider comparisonDataProvider
	 */
	public function testCanGetComparison($champion, $contender, $expected, $opts=null){
		$describer = new Schematizer;
		$class     = new ReflectionClass($describer);

		$method = $class->getMethod('compare');
		$method->setAccessible(true);

		$actual = $method->invoke($describer, $champion, $contender, $opts);

		$this->assertSame($expected,$actual);
	}

}
