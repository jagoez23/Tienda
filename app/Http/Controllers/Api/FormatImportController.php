<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FormatImportController extends Controller
{
    public function index()
    {
        return view("format");
    }
}
