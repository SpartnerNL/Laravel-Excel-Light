<?php

namespace Maatwebsite\ExcelLight;

use Box\Spout\Writer\WriterFactory;
use Box\Spout\Writer\WriterInterface;

class Writer
{
    /**
     * @var callable|null
     */
    private $callback;

    /**
     * @var WriterInterface
     */
    private $writer;

    /**
     * @var string
     */
    private $extension;


    /**
     * @param string
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
        return $this;
    }

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
     * The data will be written to a file.
     * 
     * @param string $outputFilePath
     * @param string $extension
     */
    public function export($outputFilePath)
    {
        $this->writer = WriterFactory::create($this->extension);
        $this->writer->openToFile($outputFilePath);

        if (is_callable($this->callback)) {
            call_user_func($this->callback, $this);
        }

        $this->writer->close();
    }

    /**
     * The data will be outputted directly to the browser.
     * 
     * @param string $outputFileName
     * @param string $extension
     */
    public function response($outputFileName)
    {
        $this->writer = WriterFactory::create($this->extension);
        $this->writer->openToBrowser($outputFileName);

        if (is_callable($this->callback)) {
            call_user_func($this->callback, $this);
        }

        $this->writer->close();
    }
}