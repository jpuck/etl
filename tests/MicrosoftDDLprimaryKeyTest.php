<?php
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\DBMS\MicrosoftSQLServer;
use jpuck\etl\Data\XML;
use jpuck\etl\Sources\DB;
use jpuck\phpdev\Functions as jp;

/**
 * @testdox Microsoft DDL with primary keys
 */
class MicrosoftDDLprimaryKeyTest extends PHPUnit_Framework_TestCase {
	public static $data = __DIR__.'/data';
	public static $pdo;

	public static function setUpBeforeClass(){
		self::$pdo = require self::$data."/pdos/pdo.php";
	}

	public function setUp(){
		jp::CleanMsSQLdb(self::$pdo);
	}

	public function primaryKeyDataProvider(){
		return [
			'attributes' =>
			[
				'sample.xml',
				'sample.schema.primaryKey.php',
				'sample.mssql.primaryKey.ddl.sql',
			],
			'elements' =>
			[
				'sample.pkeid.xml',
				'sample.schema.pkeid.php',
				'sample.mssql.pkeid.ddl.sql',
			],
		];
	}

	/**
	 *  @testdox Can generate DDL and insert with primary key from Schema
	 *  @dataProvider primaryKeyDataProvider
	 */
	public function testCanGenerateDDLandInsertWithPrimaryKeyfromSchema($xml, $schema, $ddl){
		$expected = file_get_contents(self::$data."/sql/$ddl");
		$schema   = require self::$data."/schemata/$schema";
		$schema   = new Schema($schema);
		$ddl      = new MicrosoftSQLServer;
		$ddl->stage(false);
		$xml = file_get_contents(self::$data."/xml/$xml");
		$xml = new XML($xml, $schema);
		$db  = new DB(self::$pdo);

		$actual   = $ddl->generate($schema);

		$this->assertSame($expected,$actual);
		$this->assertNotFalse(self::$pdo->exec($actual));
		$this->assertTrue($db->insert($xml));
	}
}
