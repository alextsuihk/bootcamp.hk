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
        //return "About Us";
        return view('pages.aboutus');
    }

    public function getContactUs()
    {
        //return "About Us";
        return view('pages.contactus');
    }
}
