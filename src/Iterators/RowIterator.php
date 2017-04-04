<?php

namespace Maatwebsite\ExcelLight\Iterators;

use Maatwebsite\ExcelLight\Row;

class RowIterator extends CallbackIterator
{
    /**
     * @return Row
     */
    public function first()
    {
        return parent::first();
    }
}
