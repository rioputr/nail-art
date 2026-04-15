<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController 
{
    public function about()
    {
        return view('pages.about');
    }

    public function careers()
    {
        return view('pages.careers');
    }

    public function press()
    {
        return view('pages.press');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function help()
    {
        return view('pages.help');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function cookie()
    {
        return view('pages.cookie');
    }
}
