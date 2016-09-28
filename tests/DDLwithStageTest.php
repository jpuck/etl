<?php
use jpuck\etl\Schemata\DDL;
use jpuck\etl\Schemata\Schema;
use jpuck\etl\Schemata\Datatypes\MicrosoftSQLServer;

/**
 * @testdox DDL with stage
 */
class DDLwithStageTest extends PHPUnit_Framework_TestCase {
	public $dataDir = __DIR__.'/data';

	/**
	 *  @testdox Can generate staging and production DDL from Schema
	 */
	public function testCanGenerateStagingAndProductionDDLfromSchema(){
		$expected = file_get_contents("{$this->dataDir}/sql/sample.mssql.stage.ddl.sql");
		$schema   = require "{$this->dataDir}/schemata/sample.schema.php";
		$schema   = new Schema($schema);
		$ddl      = new DDL;

		$actual   = $ddl->generate($schema);

		$this->assertSame($expected,$actual);
	}
}
