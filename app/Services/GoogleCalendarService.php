<?php

namespace App\Services;

use Google\Service\Calendar\Event;
use Google\Service\Calendar\EventDateTime;
use Google\Service\Calendar\EventAttendee;
use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GoogleCalendarService
{
    private $googleApiService;
    private $calendar;

    public function __construct(GoogleApiService $googleApiService)
    {
        $this->googleApiService = $googleApiService;
        $this->calendar = $googleApiService->getCalendarService();
    }

    public function createReservationEvent(Reservation $reservation)
    {
        if (!$this->calendar) {
            Log::error('Google Calendar Sync Failed: Service not initialized. Check your credentials.json file.');
            return false;
        }
        
        try {
            if (!$reservation->available_date) {
                Log::warning("Google Calendar Sync Failed: No available_date for Reservation #{$reservation->id}");
                return false;
            }

            // Priority: .env GOOGLE_CALENDAR_ID -> config -> default 'primary'
            $calendarId = env('GOOGLE_CALENDAR_ID', config('google.calendar_id', 'primary'));
            
            $event = new Event();
            $event->setSummary("Facility Reserved: {$reservation->facility->name} (#{$reservation->id})");
            $event->setLocation($reservation->facility->location ?? 'HCC Campus');
            $event->setDescription($this->getEventDescription($reservation));
            
            // Timezone is set to Asia/Manila (Philippines)
            $timezone = 'Asia/Manila'; 

            // Create start and end times
            // Carbon::parse handles the date, setTime ensures it has a valid range
            $startTime = Carbon::parse($reservation->available_date)->setTime(9, 0, 0);
            $endTime = Carbon::parse($reservation->available_date)->setTime(10, 0, 0);

            $start = new EventDateTime();
            $start->setDateTime($startTime->toRfc3339String());
            $start->setTimeZone($timezone);
            $event->setStart($start);
            
            $end = new EventDateTime();
            $end->setDateTime($endTime->toRfc3339String());
            $end->setTimeZone($timezone);
            $event->setEnd($end);
            
            // Attendees: This sends the invite to the user
            // if ($reservation->guest_contact) {
            //     $attendee = new EventAttendee();
            //     $attendee->setEmail($reservation->guest_contact);
            //     $event->setAttendees([$attendee]);
            // }
            
            // insert the event
            // 'sendUpdates' => 'all' triggers the Gmail notification from Google Calendar
            $this->calendar->events->insert($calendarId, $event);
            
            Log::info("Google Calendar Event successfully created for Reservation #{$reservation->id}");
            return true;

        } catch (\Exception $e) {
            // This will output the exact Google Error (e.g., 403 Forbidden, 404 Not Found)
            Log::error("Google API Error for Reservation #{$reservation->id}: " . $e->getMessage());
            return false;
        }
    }

    private function getEventDescription(Reservation $reservation)
    {
        return "Facility: {$reservation->facility->name}\n"
             . "Guest: {$reservation->guest_name}\n"
             . "Purpose: {$reservation->description}\n"
             . "Status: Approved\n"
             . "Manage at: " . url("/reservations/{$reservation->id}");
    }

    public function updateReservationEvent(Reservation $reservation, $eventId)
    {
        if (!$this->calendar) return false;
        try {
            $calendarId = env('GOOGLE_CALENDAR_ID', config('google.calendar_id', 'primary'));
            $event = $this->calendar->events->get($calendarId, $eventId);
            $event->setDescription($this->getEventDescription($reservation));
            $this->calendar->events->update($calendarId, $eventId, $event);
            return true;
        } catch (\Exception $e) {
            Log::error('Calendar Update Failed: ' . $e->getMessage());
            return false;
        }
    }

    public function deleteReservationEvent($eventId)
    {
        if (!$this->calendar) return false;
        try {
            $calendarId = env('GOOGLE_CALENDAR_ID', config('google.calendar_id', 'primary'));
            $this->calendar->events->delete($calendarId, $eventId);
            return true;
        } catch (\Exception $e) {
            Log::error('Calendar Delete Failed: ' . $e->getMessage());
            return false;
        }
    }
}