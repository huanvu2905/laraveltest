<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as AppController;
use App\Models\Title;
use Illuminate\Http\Request;
use DB;

class TestController extends AppController
{
    public function index()
    {
        return view('test');
    }

    public function submit(Request $request)
    {
        (new \App\Http\Middleware\VerifyAjaxCsrfToken(app(), app('encrypter')))->handle($request, function() {});
        //check csrf token
        // (new \App\Http\Middleware\VerifyAjaxCsrfToken(app(), app('encrypter')))->handle($request, function() {});

        // return Title::create(['title' => $request->title]);

        DB::transaction(function () use ($request) {
            sleep(5);
            Title::create(['title' => $request->title]);
        });

        return response()->json([]);
    }
}
