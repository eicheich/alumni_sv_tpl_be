<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index');
    }
}
