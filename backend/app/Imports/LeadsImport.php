<?php

namespace App\Imports;

use App\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LeadsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Lead|null
     */
    public function model(array $row)
    {
        $row['name'] = $row['id'];
        unset($row['id']);
        foreach ($row as &$value) {
            if (in_array($value, ['True', 'SIM'])) $value = true;
            if (in_array($value, ['False', 'NAO'])) $value = false;
        }
        return new Lead($row);
    }
}
