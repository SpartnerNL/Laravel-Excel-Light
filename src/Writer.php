<?php

namespace Maatwebsite\ExcelLight;

interface Writer
{
    /**
     * @param callable|null $callback
     *
     * @return Writer
     */
    public function write(callable $callback = null);

    /**
     * @param string   $name
     * @param callable $callback
     *
     * @return Writer
     */
    public function sheet($name, callable $callback);

    /**
     * @param array $rows
     */
    public function rows(array $rows);

    /**
     * @param string $path
     * @param string $extension
     */
    public function export($path, $extension = null);
}
