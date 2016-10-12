<?php
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;

/**
 * @testdox Microsoft DDL With Stage
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
		$expected['delete']['tmp'] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.delete.tmp.sql"
		);
		$expected['delete'][''] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.delete.prod.sql"
		);
		$expected['insert'] = file_get_contents(
			"{$this->dataDir}/sql/sample.mssql.stage.insert.sql"
		);

		$schema = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema = new Schema($schema);
		$dbms   = new MicrosoftSQLServer(null,['identity'=>true]);

		$actual = $dbms->toSQL($schema);

		$this->assertEquals($expected,$actual);
	}
}
