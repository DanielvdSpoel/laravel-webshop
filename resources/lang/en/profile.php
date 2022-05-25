<?php
return [
    "account" => [
        "email" => ["title" => "Change Email Address"],
        "user_details" => ["title" => "Change your personal data"]
    ],
    "menu" => [
        "logged_in_as" => "Logged in as",
        "logout" => "Log Out",
        "previous_orders" => "Previous orders",
        "profile" => "Profile"
    ],
    "nav" => ["account" => "Account", "security" => "Security"],
    "security" => [
        "password" => ["title" => "Change your password"],
        "two_factor" => [
            "confirm" => "Confirm code",
            "confirming_description" => "To finish enabling two factor authentication, scan the following QR code using your phone's authenticator application or enter the setup key and provide the generated OTP code.",
            "description" => "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's Google Authenticator application.",
            "recovery_keys_modal" => ["title" => "Your recovery keys:"],
            "regenerate_recovery_keys" => "Generate new recovery keys",
            "remove" => "Turn Off 2FA",
            "remove_confirm" => [
                "description" => "Are you sure you want to disable Two-Step Verification? You can always turn it back on later",
                "title" => "Disable two-step verification"
            ],
            "setup" => "Start setup",
            "setup_key" => "Or enter the following code:",
            "show_recovery_keys" => "Show recovery keys",
            "title" => "Two Factor Authentication"
        ]
    ]
];
