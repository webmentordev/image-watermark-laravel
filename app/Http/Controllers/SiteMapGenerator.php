<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiteMapGenerator extends Controller
{
    public function index()
    {
        return response()->view('sitemap')->header('Content-Type', 'text/xml');
    }
}
