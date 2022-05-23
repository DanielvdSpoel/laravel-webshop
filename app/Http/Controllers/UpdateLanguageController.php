<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateLanguageRequest;
use App\Supports\NotificationSupport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class UpdateLanguageController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param UpdateLanguageRequest $request
     * @return RedirectResponse
     */
    public function __invoke(UpdateLanguageRequest $request)
    {
        $data = $request->validated();
        App::setLocale($data['language']);
        session()->put('locale', $data['language']);

        NotificationSupport::sendSuccessNotification(
            __('notifications.language_updated.title'),
            __('notifications.language_updated.message', ['language' => config('webshop.available_languages.' . $data['language'])])
        );
        return redirect()->back();
    }
}
