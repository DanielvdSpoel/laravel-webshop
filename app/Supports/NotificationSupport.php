<?php

namespace App\Supports;


use Illuminate\Support\Str;

class NotificationSupport
{
    public static function sendErrorNotification(string $title, $message=null)
    {
        NotificationSupport::sendNotification($title, $message, 'error');
    }

    public static function sendSuccessNotification(string $title, $message=null)
    {
        NotificationSupport::sendNotification($title, $message, 'success');
    }

    public static function sendNotification(string $title, string $message, string $type)
    {
        request()->session()->push('messages', [
            'id' => Str::uuid(),
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
