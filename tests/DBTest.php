<?php
use jpuck\etl\Sources\DB;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Datatypes\MicrosoftSQLServer;

/**
 * @testdox DB
 */
class DBTest extends PHPUnit_Framework_TestCase {
	public static $dataDir = __DIR__.'/data';
	public static $pdo;

	public static function setUpBeforeClass(){
		$data = self::$dataDir;
		// maybe create a symlink for some of these files
		self::$pdo = require "$data/pdos/pdo.php";
		$ddl  = file_get_contents("$data/sql/sample.ddl.sql");
		self::$pdo->exec($ddl);
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
		$expected = self::$pdo;

		$db = new DB($expected);
		$actual = $db->uri();

		$this->assertEquals($expected, $actual);
	}

	/**
	 *  @testdox Can insert XML into DB
	 */
	public function testCanInsertXMLintoDB(){
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new DB(self::$pdo, new MicrosoftSQLServer);

		$this->assertTrue($db->insert($xml));
	}
}
