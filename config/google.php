<?php

return [
    'credentials_path' => env('GOOGLE_CREDENTIALS_PATH', storage_path('app/google-credentials.json')),
    'gmail_from_email' => env('GOOGLE_GMAIL_FROM_EMAIL', env('MAIL_FROM_ADDRESS')),
    'calendar_id' => env('GOOGLE_CALENDAR_ID', 'primary'),
];
