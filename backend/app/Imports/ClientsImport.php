<?php

namespace App\Imports;

use App\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return Client|null
     */
    public function model(array $row)
    {
        $row['portfolio_id'] = PORTFOLIO_ID;
        $row['name'] = $row['id'];
        unset($row['id']);
        foreach ($row as &$value) {
            if (in_array($value, ['True', 'SIM'])) $value = true;
            if (in_array($value, ['False', 'NAO'])) $value = false;
        }
        return new Client($row);
    }
}
