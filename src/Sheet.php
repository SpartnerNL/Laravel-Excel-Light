<?php

namespace Maatwebsite\ExcelLight;

use Box\Spout\Reader\SheetInterface;
use Illuminate\Support\Collection;
use IteratorAggregate;

class Sheet implements IteratorAggregate
{
    /**
     * @var SheetInterface
     */
    private $sheet;

    /**
     * @var bool
     */
    private $firstRowAsHeading = true;

    /**
     * @param SheetInterface $sheet
     */
    public function __construct(SheetInterface $sheet)
    {
        $this->sheet = $sheet;
    }

    /**
     * @return string
     */
    public function name()
    {
        return $this->sheet->getName();
    }

    /**
     * @return string
     */
    public function index()
    {
        return $this->sheet->getIndex();
    }

    /**
     * @param  callable         $callback
     * @return Collection|Row[]
     */
    public function rows(callable $callback = null)
    {
        if (is_callable($callback)) {
            $iterator = new IteratorWrapper($this->getIterator(), function($row) use ($callback) {
                $callback($row);
                return $row;
            });
            
            foreach($iterator as $row) { /* DON'T CARE! :) */ }
            return $iterator;
        } else {
            return $this->getIterator();
        }
    }

    /**
     * @return bool
     */
    public function isFirstRowAsHeading()
    {
        return $this->firstRowAsHeading;
    }

    /**
     * @param  bool  $state
     * @return $this
     */
    public function firstRowAsHeading($state = true)
    {
        $this->firstRowAsHeading = $state;

        return $this;
    }

    /**
     * Retrieve an external iterator
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable An instance of an object implementing <b>Iterator</b> or
     *                     <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        $rowIterator = $this->sheet->getRowIterator();

        if ($rowIterator->valid()) {
          $rawRow = $rows->current();
          if ($this->isFirstRowAsHeading()) {
            $headings = $rawRow;
            $rows->next();
          } else {
            $headings = array_keys($rawRow);
          }
        }
            
        return new IteratorWrapper($rowIterator, function ($rawRow) use ($headings) {
            return new Row($row, $headings);
        });
    }

    /**
     * @return SheetInterface
     */
    public function getAdapted()
    {
        return $this->sheet;
    }
}
