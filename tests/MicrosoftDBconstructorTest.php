<?php
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;

/**
 * @testdox Microsoft DB constructor
 */
class MicrosoftDBconstructorTest extends PHPUnit_Framework_TestCase {
	public static $dataDir = __DIR__.'/data';
	public static $pdo;

	public static function setUpBeforeClass(){
		$data = self::$dataDir;
		// maybe create a symlink for some of these files
		self::$pdo = require "$data/pdos/pdo.php";
	}

	/**
	 *  @testdox Can invalidate DB URI in constructor
	 */
	public function testCanInvalidateDBURIinConstructor(){
		$this->expectException(TypeError::class);
		$db = new MicrosoftSQLServer(['username'=>'user','password'=>'pass']);
	}

	/**
	 *  @testdox Can validate DB URI in constructor
	 */
	public function testCanValidateDBURIinConstructor(){
		$expected = self::$pdo;

		$db = new MicrosoftSQLServer($expected);
		$actual = $db->uri();

		$this->assertEquals($expected, $actual);
	}
}
