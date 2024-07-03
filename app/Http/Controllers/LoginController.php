<?php

namespace App\Http\Controllers;

use Illuminate\Http\{Request, Response};

class LoginController extends Controller
{
    public function form(): Response{
        return response()->view("form");
    }

    public function submitForm(Request $request) : Response{
        $request->validate([
            "username" => "required",
            "password" => "required"
        ]);

        return response("OK", Response::HTTP_OK);
    }
}
