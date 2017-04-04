<?php

namespace Maatwebsite\ExcelLight;

class Excel
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var Writer
     */
    private $writer;

    /**
     * @param Reader $reader
     * @param Writer $writer
     */
    public function __construct(Reader $reader, Writer $writer)
    {
        $this->reader = $reader;
        $this->writer = $writer;
    }

    /**
     * @param string        $filename
     * @param callable|null $callback
     * @param string|null   $extension
     *
     * @return Reader
     */
    public function load($filename, callable $callback = null, $extension = null)
    {
        return $this->reader->read($filename, $callback, $extension);
    }

    /**
     * @param callable|null $callback
     *
     * @return mixed
     */
    public function create(callable $callback = null)
    {
        return $this->writer->write($callback);
    }
}
