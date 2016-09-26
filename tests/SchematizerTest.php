<?php
use jpuck\etl\Schemata\Schematizer;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Data\XML;

class SchematizerTest extends PHPUnit_Framework_TestCase {
	public $schemataDir = __DIR__.'/data/schemata';
	public $xmlDir = __DIR__.'/data/xml';

	/**
	 *  @testdox Can Schematize XML
	 */
	public function testCanSchematizeXML(){
		$raw = file_get_contents("{$this->xmlDir}/sample.xml");
		$xml = new XML($raw);
		$expected = require "{$this->schemataDir}/sample.schema.php";

		$schema = (new Schematizer)->schematize($xml);
		$actual = $schema->toArray();

		$this->assertTrue($schema instanceof Schema);
		$this->assertEquals($expected, $actual);
	}
}
