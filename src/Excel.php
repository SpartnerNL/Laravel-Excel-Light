<?php

namespace Maatwebsite\ExcelLight;

class Excel
{
    /**
     * @param  string      $filename
     * @param  callable    $callback
     * @param  string|null $extension
     * @return Reader
     */
    public function load($filename, callable $callback, $extension = null)
    {
        return (new Reader)->read($filename, $callback, $extension);
    }
}
