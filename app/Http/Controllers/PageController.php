<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function __construct()
    {

    }

    public function getAboutUs()
    {
        return view('pages.aboutus');
    }

    public function getContactUs()
    {
        return view('pages.contactus');
    }
}
