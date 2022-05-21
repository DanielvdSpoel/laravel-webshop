<?php

namespace App\Supports;

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
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);
    }
}
