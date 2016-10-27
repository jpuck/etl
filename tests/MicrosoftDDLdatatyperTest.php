<?php
use jpuck\etl\Sources\DBMS\MicrosoftSQLServer;

/**
 * @testdox Microsoft DDL Datatyper
 */
class MicrosoftDDLdatatyperTest extends PHPUnit_Framework_TestCase {
	public function testCanInvalidateIntegerDatatype(){
		$this->expectException(InvalidArgumentException::class);

		(new MicrosoftSQLServer)->getInteger('NaN');
	}

	public function microsoftIntegerTypesDataProvider(){
		// https://msdn.microsoft.com/en-us/library/ms187745.aspx
		return [
			['varchar(20)',  '10,000,000,000,000,000,000'],
			['varchar(19)',   '9,223,372,036,854,775,808'],
			['bigint',        '9,223,372,036,854,775,807'],
			['bigint',              '100,000,000,000,000'],
			['bigint',                    '2,147,483,648'],
			['int',                       '2,147,483,647'],
			['int',                         '100,000,000'],
			['int',                              '32,768'],
			['smallint',                         '32,767'],
			['smallint',                          '1,000'],
			['smallint',                            '256'],
			['tinyint',                             '255'],
			['tinyint',                             '100'],
			['tinyint',                               '0'],
			['smallint',                             '-1'],
			['smallint',                         '-1,000'],
			['smallint',                        '-32,768'],
			['int',                             '-32,769'],
			['int',                        '-100,000,000'],
			['int',                      '-2,147,483,648'],
			['bigint',                   '-2,147,483,649'],
			['bigint',             '-100,000,000,000,000'],
			['bigint',       '-9,223,372,036,854,775,808'],
			['varchar(20)',  '-9,223,372,036,854,775,809'],
			['varchar(21)', '-10,000,000,000,000,000,000'],
		];
	}

	/**
	 *  @dataProvider microsoftIntegerTypesDataProvider
	 */
	public function testCanGetIntegerDatatype($expected, $value){
		$ms = new MicrosoftSQLServer;

		$actual = $ms->getInteger($value);

		$this->assertSame($expected,$actual);
	}

	public function microsoftValidateDatetimeDataProvider(){
		// https://msdn.microsoft.com/en-us/library/ms187819.aspx
		return [
			['12 months',                  false],
			['12:12:12',                   false],
			['12/12/2012',                'datetime'],
			['12/12/2012 12:12:12',       'datetime'],
			['2012-12-12',                'datetime'],
			['2012-12-12 12:12:12',       'datetime'],
			['2012-12-12T12:12:12+05:00', 'datetimeoffset'],
			['2015-11-12 14:29:08 -0700',  false],
			['2015-11-12 14:29:08 -07:00','datetimeoffset'],
		];
	}

	/**
	 *  @dataProvider microsoftValidateDatetimeDataProvider
	 */
	public function testCanValidateDatetime($value, $expected){
		$ms = new MicrosoftSQLServer;

		$actual = $ms->getDatetime($value);

		$this->assertSame($expected,$actual);
	}

	public function microsoftVarcharDataProvider(){
		// 1 through 8,000
		// https://msdn.microsoft.com/en-us/library/ms176089.aspx
		return [
			[8,     'varchar(8)'   ],
			[800,   'varchar(800)' ],
			[8000,  'varchar(8000)'],
			[8001,  'varchar(MAX)' ],
			[80000, 'varchar(MAX)' ],
		];
	}

	/**
	 *  @dataProvider microsoftVarcharDataProvider
	 */
	public function testCanGetVarchar($value, $expected){
		$ms = new MicrosoftSQLServer;

		$actual = $ms->getVarchar($value);

		$this->assertSame($expected,$actual);
	}
}
