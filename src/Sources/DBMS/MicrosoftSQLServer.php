<?php
namespace jpuck\etl\Sources\DBMS;

use jpuck\etl\Sources\DB;
use InvalidArgumentException;
use DateTime;

class MicrosoftSQLServer extends DB {

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
		// TODO: require leading zero for days & months.
		// http://php.net/manual/en/datetime.createfromformat.php
		// Day of the month, 2 digits with *or without* leading zeros
		$formats = [
			// Dates
			// [0]4/15/[19]96 -- (mdy)
			'm/d/y' => 'datetime',
			'm/d/Y' => 'datetime',
			// [0]4-15-[19]96 -- (mdy)
			'm-d-y' => 'datetime',
			'm-d-Y' => 'datetime',
			// [0]4.15.[19]96 -- (mdy)
			'm.d.y' => 'datetime',
			'm.d.Y' => 'datetime',
			// [0]4/[19]96/15 -- (myd)
			'm/y/d' => 'datetime',
			'm/Y/d' => 'datetime',
			// 15/[0]4/[19]96 -- (dmy)
			'd/m/y' => 'datetime',
			'd/m/Y' => 'datetime',
			// 15/[19]96/[0]4 -- (dym)
			'd/y/m' => 'datetime',
			'd/Y/m' => 'datetime',
			// [19]96/15/[0]4 -- (ydm)
			'y/d/m' => 'datetime',
			'Y/d/m' => 'datetime',
			// [19]96/[0]4/15 -- (ymd)
			'y/m/d' => 'datetime',
			'Y/m/d' => 'datetime',
			// undocumented
			'Y-m-d' => 'datetime',

			// ISO8601
			// YYYY-MM-DDThh:mm:ss[.mmm]
			'Y-m-d\TH:i:s'   => 'datetime',
			'Y-m-d\TH:i:s.u' => 'datetime2',
			// YYYYMMDD[ hh:mm:ss[.mmm]]
			'Ymd'         => 'datetime',
			'Ymd H:i:s'   => 'datetime',
			'Ymd H:i:s.u' => 'datetime2',

			// undocumented
			'Y-m-d H:i:s' => 'datetime',
			'm/d/Y H:i:s' => 'datetime',

			// timezone offset
			// YYYY-MM-DDThh:mm:ss[.nnnnnnn][{+|-}hh:mm]
			'Y-m-d\TH:i:s\+H:i'   => 'datetimeoffset',
			'Y-m-d\TH:i:s\-H:i'   => 'datetimeoffset',
			'Y-m-d\TH:i:s.u\+H:i' => 'datetimeoffset',
			'Y-m-d\TH:i:s.u\-H:i' => 'datetimeoffset',
			'Y-m-d H:i:s \+H:i'   => 'datetimeoffset',
			'Y-m-d H:i:s \-H:i'   => 'datetimeoffset',
			'Y-m-d H:i:s.u \+H:i' => 'datetimeoffset',
			'Y-m-d H:i:s.u \-H:i' => 'datetimeoffset',
			// YYYY-MM-DDThh:mm:ss[.nnnnnnn]Z (UTC)
		];

		foreach($formats as $format => $datatype){
			if(DateTime::createFromFormat($format, $value) !== false){
				return $datatype;
			}
		}

		return false;
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
		$identity = &$this->options['identity'];
		$identity = $enabled = $enabled ?? $identity;
		if ($enabled){
			$this->identity = 'IDENTITY';
		} else {
			$this->identity = '';
		}
		return $this->identity;
	}

	public function quote(String $entity, Bool $chars = false){
		if ($chars) {
			return ['[',']'];
		}
		return "[$entity]";
	}
}
