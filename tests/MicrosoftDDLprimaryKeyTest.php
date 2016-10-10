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
		jp::CleanMsSQLdb(self::$pdo);
	}

	public function primaryKeyDataProvider(){
		return [
			'attributes' =>
			[
				'sample.mssql.primaryKey.ddl.sql','sample.schema.primaryKey.php'
			],
		];
	}

	/**
	 *  @testdox Can generate DDL with primary key from Schema
	 *  @dataProvider primaryKeyDataProvider
	 */
	public function testCanGenerateDDLwithPrimaryKeyfromSchema($ddl, $schema){
		$expected = file_get_contents(self::$data."/sql/$ddl");
		$schema   = require self::$data."/schemata/$schema";
		$schema   = new Schema($schema);
		$ddl      = new MicrosoftSQLServer;
		$ddl->stage(false);

		$actual   = $ddl->generate($schema);

		$this->assertSame($expected,$actual);
		$this->assertNotFalse(self::$pdo->exec($actual));
	}

	/**
	 *  @testdox Can insert records with primary key in Schema
	 */
	public function testCanInsertRecordsWithPrimaryKeyInSchema(){
		$schema =
			require self::$data."/schemata/sample.schema.primaryKey.php";
		$schema = new Schema($schema);
		$xml = file_get_contents(self::$data."/xml/sample.xml");
		$xml = new XML($xml, $schema);
		$db  = new DB(self::$pdo);

		$this->assertTrue($db->insert($xml));
	}
}
