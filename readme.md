# LaravelSqlines

[![Status Release](https://img.shields.io/badge/Status-Beta-red)]() 
[![Latest Version on Packagist][ico-version]][link-packagist]
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT) 


Simple laravel package to manage the sync of databases over [Sqlines](http://www.sqlines.com/).


## Installation

Via Composer

``` bash
$ composer require brstuff/laravelsqlines
```

Copy config and sqlines to storage

```bash
php artisan vendor:publish --tag=laravelsqlines.config
php artisan vendor:publish --tag=laravelsqlines.app
```


## Usage

Simple example. 

```php
$log = \LaravelSqlines::
    sourceConnection("oracle", "database_name_in_config")
    ->targetConnection("mysql", "database_name_in_config")
    ->tables(["table1", "tables2"])
    ->tmap("table1, new_table_1")
    ->tmap("table2, new_table_2")
    ->sync();
```

## License

MIT License (MIT). Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/brstuff/laravelsqlines.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/brstuff/laravelsqlines/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/brstuff/laravelsqlines
[link-downloads]: https://packagist.org/packages/brstuff/laravelsqlines
[link-travis]: https://travis-ci.org/brstuff/laravelsqlines
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/brstuff

