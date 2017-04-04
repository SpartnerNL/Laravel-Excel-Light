<?php

namespace Maatwebsite\ExcelLight;

use Illuminate\Support\Collection;

interface Row
{
    /**
     * @return Row
     */
    public function cells();

    /**
     * @param  string $key
     *
     * @return mixed
     */
    public function column($key);

    /**
     * @return Collection
     */
    public function headings();
}