<?php
use jpuck\etl\Data\XML;
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;

/**
 * @testdox Microsoft DDL Datetime
 */
class MicrosoftDDLdatetimeTest extends PHPUnit_Framework_TestCase {
	public function testCanEvaluateMixedDatetimeTypes(){
		$expected = file_get_contents(
			__DIR__.'/data/sql/datetime.mssql.create.ddl.sql'
		);

		$xml = file_get_contents(__DIR__.'/data/xml/datetime.xml');
		$xml = new XML($xml);

		$gen = new MicrosoftSQLServer;
		$gen->stage(false);

		$actual = $gen->toSQL($xml->schema())['create'];

		$this->assertSame($expected, $actual);
	}
}
