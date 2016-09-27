<?php
use jpuck\etl\Schemata\DDL;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Datatypes\MicrosoftSQLServer;

/**
 * @testdox DDL
 */
class DDLTest extends PHPUnit_Framework_TestCase {
	public $dataDir = __DIR__.'/data';

	public function createAndDropParametersDataProvider(){
		return [
			'default no parameters' => [null],
			'create, drop' => ['create','drop'],
			'drop, create' => ['drop','create'],
		];
	}

	/**
	 *  @testdox Can generate DDL from Schema with
	 *  @dataProvider createAndDropParametersDataProvider
	 */
	public function testCanGenerateDDLfromSchema(...$params){
		$expected = file_get_contents("{$this->dataDir}/sql/sample.mssql.ddl.sql");
		$schema   = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema   = new Schema($schema);
		$ddl      = new DDL;

		$actual   = $ddl->generate($schema, ...$params);

		$this->assertSame($expected,$actual);
	}

	/**
	 *  @testdox Can generate Drop DDL from Schema
	 */
	public function testCanGenerateDropDDLfromSchema(){
		$expected = file_get_contents("{$this->dataDir}/sql/sample.mssql.drop.ddl.sql");
		$schema   = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema   = new Schema($schema);
		$ddl      = new DDL(new MicrosoftSQLServer);

		$actual   = $ddl->generate($schema, 'drop');

		$this->assertSame($expected,$actual);
	}

	/**
	 *  @testdox Can generate Create DDL from Schema
	 */
	public function testCanGenerateCreateDDLfromSchema(){
		$expected = file_get_contents("{$this->dataDir}/sql/sample.mssql.create.ddl.sql");
		$schema   = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema   = new Schema($schema);
		$ddl      = new DDL(new MicrosoftSQLServer);

		$actual   = $ddl->generate($schema, 'create');

		$this->assertSame($expected,$actual);
	}

	public function tablePrefixOptionsDataProvider(){
		return [
			'(datatyper, prefix)' => [new MicrosoftSQLServer, ['prefix'=>'tmp']],
			'(prefix, datatyper)' => [['prefix'=>'tmp'], new MicrosoftSQLServer],
			'(prefix)'            => [['prefix'=>'tmp']],
		];
	}

	/**
	 *  @testdox Can generate prefixed DDL from Schema with options
	 *  @dataProvider tablePrefixOptionsDataProvider
	 */
	public function testCanGeneratePrefixedDDLfromSchema(...$params){
		$expected = file_get_contents("{$this->dataDir}/sql/sample.mssql.tmp.ddl.sql");
		$schema   = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema   = new Schema($schema);
		$ddl      = new DDL(...$params);

		$actual   = $ddl->generate($schema);

		$this->assertSame($expected,$actual);
	}
}
