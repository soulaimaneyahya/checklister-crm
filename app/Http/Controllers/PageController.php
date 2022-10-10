<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function welcome(): View
    {
        $page = Page::findOrFail(1); // Welcome page
        return view('page', compact('page'));
    }

    public function consultation(): View
    {
        $page = Page::findOrFail(2); // Get Consultation page
        return view('page', compact('page'));
    }
}
