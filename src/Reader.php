<?php

namespace Maatwebsite\ExcelLight;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\ReaderInterface;
use Box\Spout\Reader\SheetInterface;
use Illuminate\Support\Collection;
use IteratorAggregate;
use Traversable;

class Reader implements IteratorAggregate
{
    /**
     * @var ReaderInterface
     */
    private $reader;

    /**
     * @param                $filename
     * @param  callable|null $callback
     * @param  null          $extension
     * @return $this
     */
    public function read($filename, callable $callback = null, $extension = null)
    {
        if (!$extension) {
            // TODO: guess extension based on file
            $extension = Type::XLSX;
        }

        $this->reader = ReaderFactory::create($extension);

        $this->reader->open($filename);

        if (is_callable($callback)) {
            $callback($this);
        }

        return $this;
    }

    /**
     * @param  callable           $callback
     * @return Collection|Sheet[]
     */
    public function sheets(callable $callback = null)
    {
        $sheets = new Collection(
            iterator_to_array($this->reader->getSheetIterator())
        );

        $sheets = $sheets->map(function (SheetInterface $sheet) {
            return new Sheet($sheet);
        });

        if (is_callable($callback)) {
            foreach ($sheets as $sheet) {
                $callback($sheet);
            }
        }

        return $sheets;
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
        return $this->sheets();
    }

    /**
     * @return ReaderInterface
     */
    public function getAdapted()
    {
        return $this->reader;
    }
}
