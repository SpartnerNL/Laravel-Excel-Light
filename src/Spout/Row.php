<?php

namespace Maatwebsite\ExcelLight\Spout;

use Illuminate\Support\Collection;

class Row extends Collection
{
    /**
     * @var Collection
     */
    private $headings;

    /**
     * Row constructor.
     *
     * @param array $items
     * @param array $headings
     */
    public function __construct(array $items = [], array $headings = [])
    {
        $this->headings = new Collection($headings);

        $cells = (new Collection($items))->keyBy(function ($values, $key) use ($headings) {
            return isset($headings[$key]) ? $headings[$key] : $key;
        });

        parent::__construct($cells);
    }

    /**
     * @return $this
     */
    public function cells()
    {
        return $this;
    }

    /**
     * @param  string $key
     *
     * @return mixed
     */
    public function column($key)
    {
        return $this->get($key);
    }

    /**
     * @return Collection
     */
    public function headings()
    {
        return $this->headings;
    }

    /**
     * @param  string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->column($key);
    }
}
