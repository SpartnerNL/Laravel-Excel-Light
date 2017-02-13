# Laravel Excel Light

A faster and more eloquent way of importing and exporting Excel and CSV in Laravel with the speed of Spout.

## Reading

### Fluent usage:

```php
(new Excel)->load(storage_path('workbook.xlsx'), function (Reader $reader) {
    $reader->sheets(function (Sheet $sheet) {
        $sheet->rows(function (Row $row) {
            $row->column('heading_key');
            $row->heading_key;
            $row['heading_key'];
            $row->cells(function ($cell) {
                
            });
        });
    });
});
```

### Classic usage:

```php
$reader = (new Excel)->load(storage_path('workbook.xlsx'));

foreach ($reader->sheets() as $sheet) {
    foreach ($sheet->rows() as $row) {
        foreach ($row->cells() as $cell) {
            
        }
    }
}
```

## Writing

### To file:

```php
(new Excel)->create(Excel::XLSX)->write(function (Writer $writer) {
    // Add one row to default sheet
    $writer->addRow([1, 2, 3]);

    // Add new sheet and put multi row data
    $writer->sheet('NewSheet', function (Writer $sheet) {
        $sheet->addRows([
            [4, 5, 6],
            [7, 8, 9]
        ]);
    });
})->export(storage_path('workbook.xlsx'));
```

### To standart output (i.e. browser):

```php
(new Excel)->create(Excel::XLSX)->write(function (Writer $writer) {
    $writer->addRows([
        [1, 2, 3],
        [4, 5, 6],
        [7, 8, 9]
    ]);
})->response('workbook.xlsx');
```