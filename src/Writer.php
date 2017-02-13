<?php

namespace Maatwebsite\ExcelLight;

use Box\Spout\Common\Type;
use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\WriterInterface;

class Writer
{
    const CSV  = Type::CSV;

    const XLSX = Type::XLSX;

    const ODS  = Type::ODS;

    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * @param callable|null $callback
     * @return $this
     */
    public function write(callable $callback = null)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * @param string   $name
     * @param callable $callback
     * @return $this
     */
    public function sheet($name, callable $callback)
    {
        if (method_exists($this->writer, 'addNewSheetAndMakeItCurrent')) {
            $this->writer->addNewSheetAndMakeItCurrent()->setName($name);
        }

        if (is_callable($callback)) {
            $callback($this);
        }

        return $this;
    }

    /**
     * @param array $rows
     */
    public function rows(array $rows)
    {
        $this->writer->addRows($rows);
    }

    /**
     * @param string $path
     * @param string $extension
     */
    public function export($path, $extension = null)
    {
        if (!$extension) {
            // TODO: guess extension based on file path
            $extension = Writer::XLSX;
        }

        $this->writer = WriterFactory::create($extension);
        $this->writer->openToFile($path);

        if (is_callable($this->callback)) {
            call_user_func($this->callback, $this);
        }

        $this->writer->close();
    }
}