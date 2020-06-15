<?php

use App\User;
use App\Portfolio;
use App\Jobs\MatchLeads;
use Illuminate\Http\Request;
use App\Imports\ClientsImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Queue;

$router->post('/users', function (Request $request) {
    $this->validate($request, [
        'email' => 'required|email|unique:users',
        'password' => 'required|confirmed',
    ]);
    return User::create([
        'name' => $request->input('email'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
    ]);
});

$router->post('login', function () {
    $credentials = request(['email', 'password']);

    if (!$token = auth('api')->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('api')->factory()->getTTL() * 60
    ]);
});

$router->group(['middleware' => 'auth:api'], function ($router) {
    $router->post('logout', function () {
        auth('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    });

    $router->get('me', function () {
        return response()->json(auth('api')->user());
    });

    $router->post('/portifolios', function (Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'file' => 'required|file'
        ]);
        $file = $request->file('file');
        $file->store('portifolios/' . date('Y/m/d'));

        DB::beginTransaction();
        $portfolio = auth('api')->user()->portfolios()->create(['name' => $request->input('name')]);
        $portfolio->mean()->create();
        $portfolio->standardDeviation()->create();
        define('PORTFOLIO_ID', $portfolio->id);
        Excel::import(new ClientsImport, $file);
        DB::commit();

        Queue::push(new MatchLeads($portfolio));
        return response(['result' => true]);
    });

    $router->get('/portifolios', function () {
        return auth('api')->user()->portfolios;
    });

    $router->get('/portifolios/{portfolio}', function (Request $request, $portfolio) {
        $portfolio = Portfolio::find($portfolio);
        return $portfolio
            ->leads()
            ->uf($request->input('uf'))
            ->minMatch($request->input('match'))
            ->paginate();
    });
});
