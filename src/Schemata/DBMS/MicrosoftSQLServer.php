<?php
namespace jpuck\etl\Schemata\DBMS;

use InvalidArgumentException;

class MicrosoftSQLServer extends DDL {
	use MicrosoftSQLServerTrait;

	public function getInteger ($value) : String {
		$value = str_replace(',','',$value);

		if (!is_numeric($value)){
			throw new InvalidArgumentException("$value is not numeric.");
		}

		$getVarchar = function($val){
			$size = strlen($val);
			return "varchar($size)";
		};

		// https://msdn.microsoft.com/en-us/library/ms187745.aspx
		$msints = [
			 '9223372036854775807' => 'bigint',
			          '2147483647' => 'int',
			               '32767' => 'smallint',
			                 '255' => 'tinyint',
			                  '-1' => 'smallint',
			              '-32769' => 'int',
			         '-2147483649' => 'bigint',
			'-9223372036854775809' => '',
		];

		$last = '9223372036854775807';
		if ($value > $last){
			return $getVarchar($value);
		}

		foreach ($msints as $max => $type){
			if ($value > $max){
				return $msints[$last];
			}
			$last = $max;
		}
		return $getVarchar($value);
	}

	public function getDatetime($value){
		// https://msdn.microsoft.com/en-us/library/ms187819.aspx

		// filter out alphabetic chars per relative format symbols
		// except for 'T' per ISO8601 and '+' for timezone offset
		// http://php.net/manual/en/datetime.formats.relative.php
		if (preg_match('/^[\s\dT+:\/-]*$/', $value) !== 1){
			return false;
		}

		if (strtotime($value) === false){
			return false;
		}

		if (strpos($value, '+') !== false){
			return 'datetimeoffset';
		}

		return 'datetime';
	}

	public function getVarchar ($length = null) : String {
		if (empty($length)){
			$length = $this->default_varchar_size;
		}

		if (!is_int($length) || $length < 0){
			throw new InvalidArgumentException("$length is not a positive integer.");
		}

		if ($length > 8000){
			return 'varchar(MAX)';
		}

		return "varchar($length)";
	}

	public function identity(Bool $enabled = null) : String {
		if ($enabled === true){
			$this->identity = 'IDENTITY';
		} elseif ($enabled === false){
			$this->identity = '';
		}
		return $this->identity;
	}
}
