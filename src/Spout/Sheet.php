<?php

namespace Maatwebsite\ExcelLight\Spout;

use Box\Spout\Reader\SheetInterface;
use Iterator;
use Maatwebsite\ExcelLight\Iterators\RowIterator;
use Maatwebsite\ExcelLight\Row as RowInterface;
use RuntimeException;
use Traversable;

class Sheet implements \Maatwebsite\ExcelLight\Sheet
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
     * @param  callable $callback
     *
     * @return RowIterator|RowInterface[]
     */
    public function rows(callable $callback = null)
    {
        $rows = $this->getIterator();

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
     * @param  bool $state
     *
     * @return $this
     */
    public function firstRowAsHeading($state = true)
    {
        $this->firstRowAsHeading = $state;

        return $this;
    }

    /**
     * @return RowIterator|Traversable
     */
    public function getIterator()
    {
        $iterator = $this->sheet->getRowIterator();
        $headings = $this->getHeadingsFromIterator($iterator);

        if ($this->isFirstRowAsHeading()) {
            $iterator->next();
        }

        return new RowIterator($iterator, function (array $row) use ($headings) {
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

    /**
     * @param Iterator $iterator
     *
     * @throws RuntimeException
     * @return array
     */
    private function getHeadingsFromIterator(Iterator $iterator)
    {
        if (!$this->isFirstRowAsHeading()) {
            return [];
        }

        $iterator->rewind();

        if (!$iterator->valid()) {
            throw new RuntimeException('Iterator invalid');
        }

        return $iterator->current();
    }
}
