<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
}
