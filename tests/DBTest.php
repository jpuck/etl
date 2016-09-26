<?php
use jpuck\etl\Sources\DB;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Datatypes\MicrosoftSQLServer;

/**
 * @testdox DB
 */
class DBTest extends PHPUnit_Framework_TestCase {
	public $dataDir = __DIR__.'/data';
	public $pdo;

	public function setUp(){
		// create a symlink for these files
		$this->pdo = require "{$this->dataDir}/pdos/pdo.php";
		$ddl = file_get_contents("{$this->dataDir}/sql/sample.ddl.sql");
		$this->pdo->exec($ddl);
	}

	/**
	 *  @testdox Can invalidate DB URI in constructor
	 */
	public function testCanInvalidateDBURIinConstructor(){
		$this->expectException(InvalidArgumentException::class);
		$db = new DB(['username'=>'user','password'=>'pass']);
	}

	/**
	 *  @testdox Can validate DB URI in constructor
	 */
	public function testCanValidateDBURIinConstructor(){
		$expected = $this->pdo;

		$db = new DB($expected);
		$actual = $db->uri();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can insert XML into DB
	 */
	public function testCanInsertXMLintoDB(){
		$xml = new XML(file_get_contents("{$this->dataDir}/xml/sample.xml"));
		$db  = new DB($this->pdo, new MicrosoftSQLServer);

		$this->assertTrue($db->insert($xml));
	}
}
