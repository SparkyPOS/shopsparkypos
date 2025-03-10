<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SyncSparkyController extends Controller
{
    public function __construct()
    {

    }
    public function sync(Request $request)
    {
        return [
            'success' => true, 
            'data' => $request->all()
        ];
    }
}