<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function home()
    {
        return Inertia::render('Home', [
            'categories' => Category::query()
                ->whereNull('parent_id')->with('children')->get(),
        ]);
    }

    public function renderPage(Page $page)
    {
        return Inertia::render('RenderPage', [
            'page' => $page,
        ]);
    }
}
