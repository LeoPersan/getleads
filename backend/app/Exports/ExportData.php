<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ExportData implements FromArray
{
    public function __construct($data)
    {
        $data = $data->toArray();
        $this->data = array_merge([array_keys($data[0])], $data);
    }

    public function array(): array
    {
        return $this->data;
    }
}
