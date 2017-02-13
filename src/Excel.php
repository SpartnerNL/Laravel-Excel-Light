<?php

namespace Maatwebsite\ExcelLight;

use Box\Spout\Common\Type;

class Excel
{
    const CSV  = Type::CSV;

    const XLSX = Type::XLSX;

    const ODS  = Type::ODS;

    /**
     * @param  string        $filename
     * @param  callable|null $callback
     * @param  string|null   $extension
     * @return Reader
     */
    public function load($filename, callable $callback = null, $extension = null)
    {
        return (new Reader)->read($filename, $callback, $extension);
    }

    /**
     * @param callable|null $callback
     * @return mixed
     */
    public function create($extension = null)
    {
        if (!$extension) {
            $extension = self::XLSX;
        }
        return (new Writer)->setExtension($extension);
    }
}
