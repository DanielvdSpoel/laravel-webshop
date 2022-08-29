<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Page;
use App\Models\PageType;
use App\Models\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Inertia;
use Illuminate\Support\Facades\Redirect as FacadesRedirect;

class PageController extends Controller
{
    public function handleFallback(Request $request)
    {
        $path = $request->path() === '/' ? '/' : '/' . $request->path();
        $redirect = Redirect::query()
            ->where('source->' . app()->getLocale(), $path)
            ->first();

        if ($redirect) {
            if ($redirect->destination) {
                return FacadesRedirect::to($redirect->destination, $redirect->status_code);
            }
            switch ($redirect->redirectable_type) {
                case Page::class:
                    return FacadesRedirect::to($redirect->redirectable->slug, $redirect->status_code);
            }

            //todo Implement category and product redirects
            dd("Invalid redirect");
        }

        $basicPageCategory = PageType::where('name', 'basic_page')->first();


        $page = $basicPageCategory->pages()
            ->where('slug->' . app()->getLocale(), $request->path())
            ->first();

        if ($page) {
            return Inertia::render('RenderPage', [
                'page' => $page,
            ]);
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
