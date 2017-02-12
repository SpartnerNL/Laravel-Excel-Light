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
     * @return Box\Spout\Writer\WriterInterface
     */
    public function getSpoutWriter()
    {
        return $this->writer;
    }

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
    public function addRows(array $rows)
    {
        $this->writer->addRows($rows);
    }

    /**
     * @param array $rows
     */
    public function addRow(array $row)
    {
        $this->writer->addRow($row);
    }

    /**
     * @param array $rows
     */
    public function addRowWithStyle(array $row, $style)
    {
        $this->writer->addRowWithStyle($row, $style);
    }

    /**
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