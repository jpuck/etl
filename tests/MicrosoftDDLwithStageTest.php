<?php
use jpuck\etl\Schemata\DDL;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\DBMS\MicrosoftSQLServer;

/**
 * @testdox Microsoft DDL with stage
 */
class MicrosoftDDLwithStageTest extends PHPUnit_Framework_TestCase {
	public $dataDir = __DIR__.'/data';

	/**
	 *  @testdox Can generate staging and production DDL from Schema
	 */
	public function testCanGenerateStagingAndProductionDDLfromSchema(){
		$expected['drop'] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.drop.ddl.sql"
		);
		$expected['create'] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.create.ddl.sql"
		);
		$expected['insert'] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.insert.sql"
		);

		$schema = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema = new Schema($schema);
		$dbms   = new MicrosoftSQLServer;

		$actual = $dbms->toSQL($schema);

		$this->assertSame($expected,$actual);
	}
}
