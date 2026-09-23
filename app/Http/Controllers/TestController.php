<?php

namespace App\Http\Controllers;

use App\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        $tests = Test::orderBy('id')->get();

        return view('tests.index', compact('tests'));
    }
}