# PHP tools for ETL

This is a collection of PHP 7 classes useful for
[extracting, transforming, and loading][1] data between sources.

## Requirements

PHP >= 7.0

## Installation

This library is registered on [packagist][5] and can be easily installed into
your project using [composer][2].

    php composer.phar require jpuck/etl

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

  [1]:https://en.wikipedia.org/w/index.php?title=Extract,_transform,_load&oldid=738013120
  [2]:https://getcomposer.org/
  [3]:https://phpunit.de/
  [4]:https://xdebug.org/docs/install
  [5]:https://packagist.org/packages/jpuck/etl
