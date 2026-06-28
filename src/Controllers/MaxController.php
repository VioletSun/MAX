<?php

namespace VioletSun\MAX\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MaxController extends Controller
{
    public function webhook(Request $request)
    {
        return response()->json(['status' => true]);
    }

    public function index(Request $request)
    {
        return view('max::index');
    }

    public function action(Request $request)
    {
        //
    }
}
