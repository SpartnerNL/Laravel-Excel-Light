<?php

namespace Maatwebsite\ExcelLight\Iterators;

use Illuminate\Support\Collection;
use Iterator;

abstract class CallbackIterator implements Iterator
{
    /**
     * @var Iterator
     */
    protected $iterator;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param Iterator $iterator
     * @param callable $callback
     */
    public function __construct(Iterator $iterator, callable $callback)
    {
        $this->iterator = $iterator;
        $this->callback = $callback;
    }

    /**
     * Return the current element
     *
     * @link  http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return call_user_func($this->callback, $this->iterator->current());
    }

    /**
     * Move forward to next element
     *
     * @link  http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * Return the key of the current element
     *
     * @link  http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * Checks if current position is valid
     *
     * @link  http://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     *              Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * Rewind the Iterator to the first element
     *
     * @link  http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->iterator->rewind();
    }

    /**
     * @return Collection
     */
    public function get()
    {
        return new Collection($this);
    }

    /**
     * @return mixed
     */
    public function first()
    {
        $this->rewind();

        return $this->current();
    }
}