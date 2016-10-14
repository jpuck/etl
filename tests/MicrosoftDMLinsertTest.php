<?php
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;
use jpuck\etl\Data\XML;
use jpuck\etl\Schemata\Schema;
use jpuck\phpdev\Functions as jp;

/**
 * @testdox Microsoft DML Insert
 */
class MicrosoftDMLinsertTest extends PHPUnit_Framework_TestCase {
	public static $dataDir = __DIR__.'/data';
	public static $pdo;

	public static function setUpBeforeClass(){
		$data = self::$dataDir;
		// maybe create a symlink for some of these files
		self::$pdo = require "$data/pdos/pdo.php";
		jp::CleanMsSQLdb(static::$pdo);
		$ddl  = file_get_contents("$data/sql/sample.ddl.sql");
		$ddl .= file_get_contents("$data/sql/sample.mssql.tmp.ddl.sql");
		self::$pdo->exec($ddl);
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

	/**
	 *  @testdox Can insert XML into DB
	 */
	public function testCanInsertXMLintoDB(){
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new MicrosoftSQLServer(self::$pdo, ['identity'=>true]);

		$this->assertTrue($db->insert($xml));
	}

	/**
	 *  @testdox Can insert XML into prefixed DB
	 */
	public function testCanInsertXMLintoPrefixedDB(){
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new MicrosoftSQLServer(
			self::$pdo,
			['prefix'=>'tmp','identity'=>true]
		);

		$this->assertTrue($db->insert($xml));

		$sql = 'SELECT COUNT(*) AS cntdata FROM tmpDataRecordSAMPLESUPP_DEPDEP';
		foreach (self::$pdo->query($sql) as $result){
			$count = $result['cntdata'];
		}

		$this->assertSame('3',$count);
	}

	/**
	 *  @testdox Can insert XML with generated surrogate keys
	 */
	public function testCanInsertXMLwithGeneratedSurrogateKeys(){
		jp::CleanMsSQLdb(static::$pdo);
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new MicrosoftSQLServer(
			self::$pdo,
			['stage'=>false,'identity'=>false]
		);

		$ddl = $db->toSQL($xml->schema())['create'];

		$this->assertNotFalse(static::$pdo->exec($ddl));
		$this->assertTrue($db->insert($xml));
	}

	/**
	 *  @testdox Can insert XML with generated custom surrogate key
	 */
	public function testCanInsertXMLwithGeneratedCustomSurrogateKey(){
		jp::CleanMsSQLdb(static::$pdo);
		$opts = [
			self::$pdo,
			[
				'stage'     =>  false,
				'surrogate' => 'test_sid',
				'identity'  =>  false,
			]
		];
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new MicrosoftSQLServer(...$opts);

		$sql = $db->toSQL($xml->schema());
		$ddl = $sql['create'];
		$dml = $sql['delete'];

		$this->assertNotFalse(static::$pdo->exec($ddl));
		$this->assertTrue($db->insert($xml));

		$sql = 'SELECT MAX(test_sid) AS maxid FROM DataRecordSAMPLE';
		foreach (self::$pdo->query($sql) as $result){
			$maxid = $result['maxid'];
		}

		$this->assertSame('6',$maxid);

		// test same values used (no identity continuation after delete)
		$db  = new MicrosoftSQLServer(...$opts);
		$this->assertNotFalse(static::$pdo->exec($dml));
		$this->assertTrue($db->insert($xml));

		$sql = 'SELECT MAX(test_sid) AS maxid FROM DataRecordSAMPLE';
		foreach (self::$pdo->query($sql) as $result){
			$maxid = $result['maxid'];
		}

		$this->assertSame('6',$maxid);
	}

	/**
	 *  @testdox Can insert XML with identity custom surrogate key
	 */
	public function testCanInsertXMLwithIdentityCustomSurrogateKey(){
		jp::CleanMsSQLdb(static::$pdo);
		$opts = [
			self::$pdo,
			[
				'stage'     =>  false,
				'surrogate' => 'test_sid',
				'identity'  =>  true,
			]
		];
		$data = self::$dataDir;
		$xml = new XML(file_get_contents("$data/xml/sample.xml"));
		$db  = new MicrosoftSQLServer(...$opts);

		$sql = $db->toSQL($xml->schema());
		$ddl = $sql['create'];
		$dml = $sql['delete'];

		$this->assertNotFalse(static::$pdo->exec($ddl));
		$this->assertTrue($db->insert($xml));

		$sql = 'SELECT MAX(test_sid) AS maxid FROM DataRecordSAMPLE';
		foreach (self::$pdo->query($sql) as $result){
			$maxid = $result['maxid'];
		}

		$this->assertSame('6',$maxid);

		// test identity doesn't restart
		$db  = new MicrosoftSQLServer(...$opts);
		$this->assertNotFalse(static::$pdo->exec($dml));
		$this->assertTrue($db->insert($xml));

		$sql = 'SELECT MAX(test_sid) AS maxid FROM DataRecordSAMPLE';
		foreach (self::$pdo->query($sql) as $result){
			$maxid = $result['maxid'];
		}

		$this->assertSame('12',$maxid);
	}

	/**
	 *  @testdox Can insert XML into DB ignoring extra data
	 */
	public function testCanInsertXMLintoDBignoringExtraData(){
		jp::CleanMsSQLdb(static::$pdo);
		$db = new MicrosoftSQLServer(self::$pdo,
			['stage'=>false, 'identity'=>true]
		);
		$data = self::$dataDir;
		$schema = new Schema("$data/schemata/sample.schema.reduced.php");
		$xml = new XML(file_get_contents("$data/xml/sample.xml"), $schema);

		$this->assertNotFalse(static::$pdo->exec(
			$db->toSQL($schema)['create']
		));
		$this->assertTrue($db->insert($xml));
	}
}
