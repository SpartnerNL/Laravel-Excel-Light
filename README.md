# Laravel Excel Light

> No plans for further development and/or support. This is just an experiment to improve the Laravel-Excel library.

A faster and more eloquent way of importing and exporting Excel and CSV in Laravel with the speed of Spout.

## Installation
```
composer require maatwebsite/laravel-excel-light
```

Add the Service Provider in app.php

```$xslt
Maatwebsite\ExcelLight\LaravelExcelServiceProvider::class
```

The Excel class can be injected in your service:

```
public function __construct(\Maatwebsite\ExcelLight\Excel $excel)
```

Optionally you can also inject the Reader and Writer:

```
public function __construct(\Maatwebsite\ExcelLight\Reader $reader)
public function __construct(\Maatwebsite\ExcelLight\Writer $writer)
```

## Reading

### Fluent usage:

```php
$excel->load(storage_path('workbook.xlsx'), function (Reader $reader) {
    $reader->sheets(function (Sheet $sheet) {
        $sheet->rows(function (Row $row) {

            // Get a column
            $row->column('heading_key');

            // Magic get
            $row->heading_key;

            // Array access
            $row['heading_key'];
        });
    });
});
```

### Classic usage:

```php
$reader = $excel->load(storage_path('workbook.xlsx'));

foreach ($reader->sheets() as $sheet) {
    foreach ($sheet->rows() as $row) {

        $row->column('heading_key');

        foreach ($row->cells() as $cell) {

        }
    }
}
```

## Writing

```php
$excel->create(function (Writer $writer) {
    $writer->sheet('sheet1', function (Writer $sheet) {
        $sheet->rows([
            [1, 2, 3],
            [4, 5, 6]
        ]);

        // Add more rows
        $sheet->rows([
            [7, 8, 9],
            [10, 11, 12]
        ]);
    });
})->export(storage_path('workbook.xlsx'));
```

## Custom Readers and Writers

Registering a customer reader:
```
$this->app->make(\Maatwebsite\ExcelLigt\ExcelManager::class)
    ->registerReader('driverName', function() {
        return YourReader();
    });
```

Registering a customer writer:
```
$this->app->make(\Maatwebsite\ExcelLigt\ExcelManager::class)
    ->registerWriter('driverName', function() {
        return YourWriter();
    });
```

Resolving a custom reader and writer:

```
__construct(ExcelManager $manager) {
    $reader = $manager->reader('driverName');
    $writer = $manager->writer('driverName');
}
```
