<?php

namespace Maatwebsite\ExcelLight\Spout;

use Box\Spout\Common\Type;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Reader\ReaderInterface as SpoutReaderInterface;
use Box\Spout\Reader\SheetInterface;
use Maatwebsite\ExcelLight\Iterators\SheetIterator;
use Maatwebsite\ExcelLight\Reader as ReaderInterface;
use Traversable;

class Reader implements ReaderInterface
{
    /**
     * @var SpoutReaderInterface
     */
    private $reader;

    /**
     * @param               $filename
     * @param callable|null $callback
     * @param null          $extension
     *
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
     * @param callable $callback
     *
     * @return SheetIterator|Sheet[]
     */
    public function sheets(callable $callback = null)
    {
        $sheets = $this->getIterator();

        if (is_callable($callback)) {
            foreach ($sheets as $sheet) {
                $callback($sheet);
            }
        }

        return $sheets;
    }

    /**
     * @return Traversable|SheetIterator
     */
    public function getIterator()
    {
        return new SheetIterator($this->reader->getSheetIterator(), function (SheetInterface $sheet) {
            return new Sheet($sheet);
        });
    }

    /**
     * @return SpoutReaderInterface
     */
    public function getAdapted()
    {
        return $this->reader;
    }
}
