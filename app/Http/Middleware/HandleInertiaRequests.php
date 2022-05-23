<?php

namespace App\Http\Middleware;

use App\Supports\TranslationSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param \Illuminate\Http\Request $request
     * @return array
     * @throws \Exception
     */
    public function share(Request $request)
    {
        $translationSupport = new TranslationSupport();
        return array_merge(parent::share($request), [
            'brand_name' => config('app.name'),
            'messages' => $request->session()->pull('messages', []),
            'translations' => $translationSupport->getTranslationStrings(),
            'current_language' =>session()->get('locale', app()->getLocale()),
            'available_currencies' => config('webshop.available_currencies'),
            'available_languages' => config('webshop.available_languages'),
            'auth' => [
                'user' => fn () => $request->user()
                    ? $request->user()
                    : null,
                'has_verified_email' => fn () => $request->user()
                    ? $request->user()->hasVerifiedEmail()
                    : null,
            ],
        ]);
    }
}
