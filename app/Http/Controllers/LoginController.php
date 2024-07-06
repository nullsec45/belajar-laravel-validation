<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Log};
use  App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function form(): Response{
        return response()->view("form");
    }

    public function submitForm(LoginRequest $request) : Response{
        $data=$request->validated();
        Log::info(json_encode($data, JSON_PRETTY_PRINT));

        return response("OK", Response::HTTP_OK);
    }
}
