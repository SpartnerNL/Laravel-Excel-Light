<?php

namespace Maatwebsite\ExcelLight\Iterators;

use Maatwebsite\ExcelLight\Sheet;

class SheetIterator extends CallbackIterator
{
    /**
     * @return Sheet
     */
    public function first()
    {
        return parent::first();
    }
}
