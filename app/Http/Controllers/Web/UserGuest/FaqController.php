<?php

namespace App\Http\Controllers\Web\UserGuest;

use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    public function index()
    {
        return view('faq.index');
    }
}
