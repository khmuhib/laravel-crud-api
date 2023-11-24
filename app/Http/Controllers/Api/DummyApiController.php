<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DummyApiController extends Controller
{

    public function index()
    {
        return [
            'name' => 'dummy',
        ];
    }
}
