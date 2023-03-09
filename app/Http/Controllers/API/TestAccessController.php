<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TestAccessController extends Controller
{   
    /**
     * @param Illuminate\Http\Request
     * @return jsonSuccess
     */
    public function index(Request $request)
    {
        echo "hello";
    }
}
