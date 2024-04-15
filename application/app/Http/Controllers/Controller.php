<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function __invoke()
    {

    }

    public function index()
    {
        return response()->json(["Teste"]);
    }
}
