<?php
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\DBMS\MicrosoftSQLServer;
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

	/**
	 *  @testdox Can generate DDL with primary key from Schema
	 */
	public function testCanGenerateDDLwithPrimaryKeyfromSchema(){
		$expected = file_get_contents(
			self::$data."/sql/sample.mssql.primaryKey.ddl.sql"
		);
		$schema =
			require self::$data."/schemata/sample.schema.primaryKey.php";
		$schema   = new Schema($schema);
		$ddl      = new MicrosoftSQLServer;
		$ddl->stage(false);

		$actual   = $ddl->generate($schema);

		$this->assertSame($expected,$actual);
		$this->assertNotFalse(self::$pdo->exec($actual));
	}
}
