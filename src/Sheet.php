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
        $rows = new Collection(
            iterator_to_array($this->sheet->getRowIterator())
        );

        $headings = $this->isFirstRowAsHeading()
            ? $rows->shift()
            : $rows->keys()->toArray();

        $rows = $rows->map(function (array $row) use ($headings) {
            return new Row($row, $headings);
        });

        if (is_callable($callback)) {
            foreach ($rows as $row) {
                $callback($row);
            }
        }

        return $rows;
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
        return $this->rows();
    }

    /**
     * @return SheetInterface
     */
    public function getAdapted()
    {
        return $this->sheet;
    }
}
