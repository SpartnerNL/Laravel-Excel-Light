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
$reader = (new Excel)->load(storage_path('workbook.xlsx')

foreach ($reader->sheets() as $sheet) {
    foreach ($sheet->rows() as $row) {
        foreach ($row->cells() as $cell) {
            
        }
    }
}
```