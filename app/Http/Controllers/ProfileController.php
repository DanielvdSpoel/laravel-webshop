<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Notifications\EmailChangedNotification;
use App\Supports\NotificationSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function account(Request $request)
    {
        return Inertia::render('Profile/Account', [
            'user' => $request->user()
        ]);
    }

    public function security(Request $request)
    {
        return Inertia::render('Profile/Security', [
            'user' => $request->user()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        $data = $request->validated();

        if (isset($data['new_password'])) {
            $data['password'] = Hash::make($data['new_password']);
        }

        if (isset($data['email']) && $data['email'] !== $request->user()->email) {
            $request->user()->email_verified_at = null;
            $request->user()->save();
            $request->user()->notify(new EmailChangedNotification());

            $request->user()->update($data);

            $request->user()->sendEmailVerificationNotification();
        } else {
            $request->user()->update($data);
        }

        NotificationSupport::sendSuccessNotification(
            __('notifications.profile_updated.title'),
            __('notifications.profile_updated.message')
        );

        return redirect()->back();
    }

}
