<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;

class PageController extends Controller
{
    public function handleFallback(Request $request)
    {
        // Todo check for pages
        ray(app()->getLocale());
        ray($request->path());

        $redirect = Redirect::query()
            ->where('source->' . app()->getLocale(), '/' . $request->path())
            ->first();

        if ($redirect) {
            if ($redirect->destination) {
                return FacadesRedirect::to($redirect->destination, $redirect->status_code);
            }

            dd($redirect);
        }

        abort(404);
    }


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
