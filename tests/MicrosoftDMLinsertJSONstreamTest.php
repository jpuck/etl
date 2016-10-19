<?php
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;
use jpuck\etl\Data\JSONstream;
use jpuck\phpdev\Functions as jp;

/**
 * @testdox Microsoft DML Insert JSON Stream
 */
class MicrosoftDMLinsertJSONstreamTest extends PHPUnit_Framework_TestCase {
	public static $data = __DIR__.'/data';
	public static $list;
	public static $pdo;

	public static function setUpBeforeClass(){
		// maybe create a symlink for some of these files
		static::$pdo = require static::$data."/pdos/pdo.php";
		jp::CleanMsSQLdb(static::$pdo);
		$ddl = file_get_contents(static::$data."/sql/item.ddl.sql");
		static::$pdo->exec($ddl);
		static::$list = static::$data."/json/item.json.lst";
	}

	/**
	 *  @testdox Can insert JSON into DB
	 */
	public function testCanInsertJSONintoDB(){
		$js   = new JSONstream(static::$list, ['name'=>'item']);
		$db   = new MicrosoftSQLServer(self::$pdo);
		while($json = $js->fetch(2)){
			$this->assertTrue($db->insert($json));
		}
	}

	/**
	 *  @testdox Can insert second batch of JSON into DB
	 */
	public function testCanInsertSecondBatchOfJSONintoDB(){
		$js   = new JSONstream(static::$list, ['name'=>'item']);
		$db   = new MicrosoftSQLServer(self::$pdo);
		while($json = $js->fetch(1)){
			$this->assertTrue($db->insert($json));
		}
	}
}
