<?php

namespace Maatwebsite\ExcelLight;

use InvalidArgumentException;

class ExcelManager
{
    /**
     * @const string
     */
    const DRIVER_DEFAULT = 'spout';

    /**
     * @var array
     */
    protected $readers = [];

    /**
     * @var array
     */
    protected $writers = [];

    /**
     * @param string|null $reader
     * @param string|null $writer
     *
     * @return Excel
     */
    public function make($reader = null, $writer = null)
    {
        return new Excel(
            $this->getReader($reader),
            $this->getWriter($writer)
        );
    }

    /**
     * @param string   $driver
     * @param callable $factory
     */
    public function registerWriter($driver, callable $factory)
    {
        $this->writers[$driver] = $factory;
    }

    /**
     * @param string   $driver
     * @param callable $factory
     */
    public function registerReader($driver, callable $factory)
    {
        $this->readers[$driver] = $factory;
    }

    /**
     * @param string|null $driver
     *
     * @throws InvalidArgumentException when unknown driver given
     * @return Reader
     */
    public function getReader($driver = null)
    {
        $driver = $driver !== null ? $driver : $this->getDefaultDriver();

        if (!isset($this->readers[$driver])) {
            throw new InvalidArgumentException("Unknown Excel Reader [{$driver}] given");
        }

        $factory = $this->readers[$driver];

        return call_user_func($factory);
    }

    /**
     * @param string $driver
     *
     * @throws InvalidArgumentException when unknown driver given
     * @return Writer
     */
    public function getWriter($driver)
    {
        $driver = $driver !== null ? $driver : $this->getDefaultDriver();

        if (!isset($this->writers[$driver])) {
            throw new InvalidArgumentException("Unknown Excel Writer [{$driver}] given");
        }

        $factory = $this->writers[$driver];

        return call_user_func($factory);
    }

    /**
     * @return string
     */
    public function getDefaultDriver()
    {
        return self::DRIVER_DEFAULT;
    }
}
