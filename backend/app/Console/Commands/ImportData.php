<?php

namespace App\Console\Commands;

use Exception;
use App\Imports\LeadsImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportData extends Command
{
    protected $signature = 'import:data {file?}';
    protected $description = 'Import csv to database';
    public function handle()
    {
        if (is_null($this->argument('file'))) throw new Exception("Passe o endereço do arquivo para importar", 1);
        $file = $this->argument('file');
        if (!is_file($file)) throw new Exception("Não é um arquivo", 2);
        if (pathinfo($file)['extension'] != 'csv') throw new Exception("Não é um arquivo csv", 3);
        Excel::import(new LeadsImport, $this->argument('file'));
    }
}
