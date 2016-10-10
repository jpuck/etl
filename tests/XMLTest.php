<?php
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Schema;

/**
 * @testdox XML
 */
class XMLTest extends PHPUnit_Framework_TestCase {
	public $xmlDir = __DIR__.'/data/xml';
	public $schemataDir = __DIR__.'/data/schemata';

	/**
	 * @testdox Can create XML
	 */
	public function testCanCreateXML(){
		$raw = file_get_contents("{$this->xmlDir}/sample.xml");
		$xml = new XML($raw);
		$this->assertTrue($xml instanceof XML);
	}

	/**
	 * @testdox Can create XML with Schema
	 */
	public function testCanCreateXMLwithSchema(){
		$schema = require "{$this->schemataDir}/sample.schema.php";
		$schema = new Schema($schema);
		$raw = file_get_contents("{$this->xmlDir}/sample.xml");

		$xml = new XML($raw, $schema);

		$this->assertTrue($xml instanceof XML);
	}

	/**
	 * @testdox Can create XML without uniques
	 */
	public function testCanCreateXMLwithoutUniques(){
		$raw      = file_get_contents("{$this->xmlDir}/sample.xml");
		$expected = require "{$this->schemataDir}/sample.schema.nounique.php";
		$xml      = new XML($raw, ['schematizer'=>['unique'=>false]]);
		$actual   = $xml->schema()->toArray();

		$this->assertTrue($xml instanceof XML);
		$this->assertSame($expected, $actual);
	}
}
