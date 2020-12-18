<?php

namespace Mariojgt\Hive\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HiveContoller extends Controller
{
    public function index()
    {
        dd('here');
        return view('hive::content.index');
    }
}
