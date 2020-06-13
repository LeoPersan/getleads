<?php

use App\Portfolio;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;

$router->post('/api/portifolios', function (Request $request) use ($router) {
    $file = $request->file('file');
    $file->store('portifolios/' . date('Y/m/d'));
    $portfolio = Portfolio::create(['name' => $request->input('name')]);
    define('PORTFOLIO_ID', $portfolio->id);
    Excel::import(new ClientsImport, $file);
    return response(['result' => true]);
});
