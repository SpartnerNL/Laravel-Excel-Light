<?php

namespace Maatwebsite\ExcelLight;

class Excel
{
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
    public function create(callable $callback = null)
    {
        return (new Writer)->write($callback);
    }
}
