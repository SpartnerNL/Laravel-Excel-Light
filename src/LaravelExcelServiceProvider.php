<?php

namespace Maatwebsite\ExcelLight;

use Illuminate\Support\ServiceProvider;
use Maatwebsite\ExcelLight\Spout\Reader as SpoutReader;
use Maatwebsite\ExcelLight\Spout\Writer as SpoutWriter;

class LaravelExcelServiceProvider extends ServiceProvider
{
    /**
     * Register services
     */
    public function register()
    {
        $this->app->singleton(ExcelManager::class, function () {
            $factory = new ExcelManager;

            $this->registerSpout($factory);

            return $factory;
        });

        $this->app->bind(Excel::class, function () {

            /** @var ExcelManager $factory */
            $factory = $this->app->make(ExcelManager::class);

            return $factory->make(
                $this->getReaderDriver(),
                $this->getWriterDriver()
            );
        });

        $this->app->bind(Reader::class, function () {

            /** @var ExcelManager $factory */
            $factory = $this->app->make(ExcelManager::class);

            return $factory->getReader(
                $this->getReaderDriver()
            );
        });

        $this->app->bind(Writer::class, function () {

            /** @var ExcelManager $factory */
            $factory = $this->app->make(ExcelManager::class);

            return $factory->getWriter(
                $this->getWriterDriver()
            );
        });
    }

    /**
     * @return string
     */
    private function getReaderDriver()
    {
        return $this->app->make('config')->get('excel-light.reader.driver');
    }

    /**
     * @return string
     */
    private function getWriterDriver()
    {
        return $this->app->make('config')->get('excel-light.writer.driver');
    }

    /**
     * @param ExcelManager $factory
     */
    private function registerSpout(ExcelManager $factory)
    {
        $factory->registerWriter('spout', function () {
            return new SpoutWriter;
        });

        $factory->registerReader('spout', function () {
            return new SpoutReader;
        });
    }
}
