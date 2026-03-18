<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Calendar;

class GoogleApiService
{
    private $client;
    private $gmail;
    private $calendar;

public function __construct()
{
    $this->client = new \Google\Client();
    $this->client->setApplicationName('HCC Facility Reservation System');
    $this->client->setScopes([
        \Google\Service\Gmail::GMAIL_SEND,
        \Google\Service\Calendar::CALENDAR,
    ]);

    // This combines the storage folder with the path in your .env
    $relative = config('google.credentials_path'); 
    $credentialsPath = storage_path($relative);

    if (file_exists($credentialsPath)) {
        $this->client->setAuthConfig($credentialsPath);
        $this->client->setAccessType('offline');
    } else {
        // This will tell us the EXACT folder it's looking in
        \Log::error("CANNOT FIND JSON AT: " . $credentialsPath);
        $this->client = null;
    }
}

    public function getGmailService()
    {
        if (!$this->client) return null;
        if (!$this->gmail) {
            $this->gmail = new Gmail($this->client);
        }
        return $this->gmail;
    }

    public function getCalendarService()
    {
        if (!$this->client) return null;
        if (!$this->calendar) {
            $this->calendar = new Calendar($this->client);
        }
        return $this->calendar;
    }

    public function getClient()
    {
        return $this->client;
    }
}