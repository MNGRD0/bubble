<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculatriceController extends Controller
{
    public function index()
{
    return view('calculatrice.index');
}

}
