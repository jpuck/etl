# PHP tools for ETL

This is a collection of PHP 7 classes useful for
[extracting, transforming, and loading][1] data between sources.

Branch      | Tests
----------- | ------
[master][9] | [![Build Status][12]][11]
[dev][10]   | [![Build Status][13]][11]

## Requirements

PHP >= 7.0

## Installation

This library is registered on [packagist][5] and can be easily installed into
your project using [composer][2].

    php composer.phar require jpuck/etl

--------------

# Getting Started

There are 3 basic groups of interrelated classes:
*Sources* provide *Data* which have *Schemata*.

1. Sources

	Sources extend the `Source` class and implement the `Tranceiver` interface.
	A Source also has an optional property object that implements the
	`Datatyper` interface, which is most useful for the `DB` class.

2. Data

	Data classes extend `Datum` and must implement the `Parser` interface.
	It uses the `Schematizer` to construct the object from raw data.

3. Schemata

	A `Schema` is a concrete class with a `Validator` to enforce structure.
	The `Merger` class is for combining Schemas to create super-set Schemas.
	The `DDL` class generates [SQL Data Definition Language][6] with guidance
	from a class that implements the `Datatyper` interface.

## Schematizer

The `Schematizer` class is for surveying the structure of the data.
It includes node names, the [count of distinct element groupings][7],
numeric cardinality for relationships between subnodes, and descriptive
statistics about the values including uniqueness. Categorically, it recognizes
datetime, integer, and decimal datatypes. Decimals will include scale and
precision measurements suitable for SQL.

`Schematizer::getPrecision` returns the scale and precision of
numeric values suitable for the SQL `DECIMAL(scale,precision)` datatype.
This function has notable behavior in that trailing zeros are discarded
when passed as raw PHP float types. However, when passed as a string, then the
trailing zeros are preserved in the precision.
See `SchematizerUtilitiesTest::precisionDataProvider` for examples.
Note that in the `XML` class, parsed values are represented as strings
in PHP, so *trailing zeros should be represented in the precision values*.

	node name
	├── count
	│   ├── max
	│   │   ├── measure
	│   │   └── value
	│   └── min
	│       ├── measure
	│       └── value
	├── unique (all values)
	├── varchar          ────┐
	│   ├── max              │
	│   │   ├── measure      │
	│   │   └── value        │
	│   └── min              │
	│       ├── measure      │
	│       └── value        │
	├── datetime             ├ datatypes
	│   ├── max              │
	│   │   └── value        │
	│   └── min              │
	│       └── value        │
	├── int/decimal          │
	│   ├── max              │
	│   │   └── value        │
	│   └── min              │
	│       └── value    ────┘
	├── scale            ────┐
	│   ├── max              │
	│   │   ├── measure      │
	│   │   └── value        │
	│   └── min              │
	│       ├── measure      │
	│       └── value        │
	├── precision            ├ if decimal
	│   ├── max              │
	│   │   ├── measure      │
	│   │   └── value        │
	│   └── min              │
	│       ├── measure      │
	│       └── value    ────┘
	├── children
	│   ├── distinct (count of children)
	│   └── count
	│       ├── max
	│       │   └── measure
	│       └── min
	│           └── measure
	├── attributes
	│   └── ... (excluding count, which must be 1)
	└── elements
	    └── ...

## Database Connections

The `DB` class requires an instance of [`PDO`][8] in the constructor.

## SQL Data Definition Language

When one-to-many XML nodes are used to represent one-to-one relationships, then
the `Schematizer` recognizes this and the `DDL` class flattens them as columns
on a table. If a node has more than one if its name or grandchildren, then the
one-to-many relationship is preserved in a separate normalized table. Surrogate
keys are created to maintain the Primary/Foreign Key referential integrity.

--------------

# Development

The development dependencies can be installed by running [composer][2] with or
without the `--dev` option (enabled by default).

    php composer.phar install --dev

## Testing

Tests are written for [PHPUnit][3] which is included as a composer
dev-dependency. To run the whole test suite, then execute this command from the
shell console:

    php vendor/bin/phpunit

You might also be interested in an easy to read checklist output:

    php vendor/bin/phpunit --testdox

A code coverage report is available if you have the [`xdebug` extension][4]
installed. In addition to the console text summary report, a full HTML GUI is
generated to explore in the `coverage` folder. The easiest way to view this is
to boot up a dev server:

    php -S localhost:8080 -t coverage/

### Database Testing

You must create the file `tests/data/pdos/pdo.php` in order to run the database
tests. This should simply return a `PDO` instance, for example:

```php
<?php
return (function(){
	$hostname = 'sql.example.com';
	$database = 'mydb';
	$username = 'user';
	$password = 'P@55w0rd';
	// https://www.microsoft.com/en-us/download/details.aspx?id=50419
	$driver   = 'ODBC Driver 13 for SQL Server';

	$pdo = new PDO("odbc:Driver=$driver;
		Server=$hostname;
		Database=$database",
		$username,
		$password
	);
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

	return $pdo;
})();
```

  [1]:https://en.wikipedia.org/w/index.php?title=Extract,_transform,_load&oldid=738013120
  [2]:https://getcomposer.org/
  [3]:https://phpunit.de/
  [4]:https://xdebug.org/docs/install
  [5]:https://packagist.org/packages/jpuck/etl
  [6]:https://en.wikipedia.org/wiki/Data_definition_language
  [7]:http://stackoverflow.com/q/39260573/4233593
  [8]:http://php.net/manual/en/book.pdo.php
  [9]:https://github.com/jpuck/etl/tree/master
  [10]:https://github.com/jpuck/etl/tree/dev
  [11]:https://travis-ci.org/jpuck/etl
  [12]:https://travis-ci.org/jpuck/etl.svg?branch=master
  [13]:https://travis-ci.org/jpuck/etl.svg?branch=dev
