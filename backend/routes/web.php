<?php

use App\Portfolio;
use App\Jobs\MatchLeads;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;

$router->post('/api/portifolios', function (Request $request) use ($router) {
    $file = $request->file('file');
    $file->store('portifolios/' . date('Y/m/d'));

    DB::beginTransaction();
    $portfolio = Portfolio::create(['name' => $request->input('name')]);
    $portfolio->mean()->create();
    $portfolio->standardDeviation()->create();
    define('PORTFOLIO_ID', $portfolio->id);
    Excel::import(new ClientsImport, $file);
    DB::commit();

    Queue::push(new MatchLeads($portfolio));
    return response(['result' => true]);
});
