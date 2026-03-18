<?php

namespace App\Services;

use App\Models\Reservation;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class GmailService
{
    /**
     * Constructor kept to maintain compatibility with your Controller injection
     */
    public function __construct(GoogleApiService $apiService)
    {
        //
    }

    /**
     * Send 2FA Verification Code for Login
     */
    public function sendOtpEmail($user, $otp)
    {
        $subject = "Login Verification Code: {$otp}";
        
        $body = "Hello {$user->name},\n\n"
              . "You are receiving this email because a login attempt was made for your account.\n\n"
              . "Your 6-digit verification code is:\n\n"
              . "--- {$otp} ---\n\n"
              . "This code will expire in 1 minute. If you did not request this, please secure your account immediately.";

        // Special HTML wrapper for OTP to make the number stand out
        $logoUrl = "https://amyfoundationph.com/home/wp-content/uploads/2022/07/hcc.gif";
        $htmlContent = "
            <div style='font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='{$logoUrl}' alt='Campus Logo' style='width: 150px; height: auto;'>
                </div>
                <h2 style='color: #333; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px; text-align: center;'>Login Verification</h2>
                <div style='line-height: 1.6; color: #555; text-align: center;'>
                    <p>Enter the code below to complete your login:</p>
                    <div style='background: #f8f9fa; border: 2px dashed #007bff; display: inline-block; padding: 15px 30px; font-size: 32px; font-weight: bold; color: #007bff; letter-spacing: 5px; margin: 20px 0;'>
                        {$otp}
                    </div>
                    <p style='font-size: 14px; color: #888;'>This code expires in 15 minutes.</p>
                </div>
                <footer style='margin-top: 30px; font-size: 12px; color: #999; text-align: center;'>
                    &copy; " . date('Y') . " Campus Facility Reservation System. All rights reserved.
                </footer>
            </div>
        ";

        try {
            Mail::html($htmlContent, function ($message) use ($user, $subject) {
                $message->to($user->email)->subject($subject);
            });
            return true;
        } catch (\Exception $e) {
            Log::error("2FA Mail Error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Notify User when they first submit a request
     */
    public function sendReservationSubmissionEmail(Reservation $reservation)
    {
        return $this->sendMessage(
            $reservation->guest_contact, 
            "Reservation Request Received - #{$reservation->id}",
            "Hello {$reservation->guest_name}, we have received your request for {$reservation->facility->name}. It is currently pending review."
        );
    }

    public function sendAdminSubmissionNotification(Reservation $reservation, $adminEmail)
    {
        $baseCapacity = $reservation->facility->capacity;
        $participants = $reservation->estimated_participants;
        $extraChairs = max(0, $participants - $baseCapacity);

        $seatingStatus = ($extraChairs > 0) 
            ? "!!! EXTRA SEATING REQUIRED: +{$extraChairs} chairs needed !!!" 
            : "Seating: Within base capacity ({$baseCapacity})";

        $body = "A new request has been submitted.\n\n"
              . "DETAILS:\n"
              . "------------------------------------------\n"
              . "Guest:         {$reservation->guest_name}\n"
              . "Facility:      {$reservation->facility->name}\n"
              . "Participants:  {$participants}\n"
              . "{$seatingStatus}\n"
              . "------------------------------------------\n\n"
              . "Please log in to the Admin Dashboard to approve or reject this request.";

        return $this->sendMessage(
            $adminEmail, 
            "URGENT: New Reservation Request (" . $reservation->facility->name . ")",
            $body
        );
    }

    public function sendReservationApprovedEmail(Reservation $reservation)
    {
        $subject = "APPROVED: Reservation for " . $reservation->facility->name;
        $formattedDate = Carbon::parse($reservation->requested_date)->format('F d, Y');

        $baseCapacity = $reservation->facility->capacity;
        $participants = $reservation->estimated_participants;
        $extraChairs = max(0, $participants - $baseCapacity);

        $seatingInfo = "Standard ({$participants} Persons)";
        if ($extraChairs > 0) {
            $seatingInfo = "{$participants} Persons (+{$extraChairs} extra chairs requested)";
        }

        $body = "Hello {$reservation->guest_name},\n\n"
              . "Great news! Your reservation request has been officially approved.\n\n"
              . "RESERVATION DETAILS:\n"
              . "------------------------------------------\n"
              . "Facility:       {$reservation->facility->name}\n"
              . "Date:           {$formattedDate}\n"
              . "Participants:   {$seatingInfo}\n"
              . "Reservation ID: #{$reservation->id}\n"
              . "------------------------------------------\n\n"
              . "Please bring a copy of this email or a valid ID when you arrive at the facility.\n\n"
              . "Thank you!";

        return $this->sendMessage($reservation->guest_contact, $subject, $body);
    }

    public function sendReservationRejectedEmail(Reservation $reservation)
    {
        return $this->sendMessage(
            $reservation->guest_contact, 
            "REJECTED: Reservation for #{$reservation->id}",
            "Hello {$reservation->guest_name}, unfortunately your reservation for {$reservation->facility->name} could not be approved at this time."
        );
    }

    private function sendMessage($to, $subject, $content)
    {
        if (empty($to)) {
            Log::error("Mail Error: Recipient email is empty.");
            return false;
        }

        $logoUrl = "https://amyfoundationph.com/home/wp-content/uploads/2022/07/hcc.gif";

        $htmlContent = "
            <div style='font-family: sans-serif; max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <img src='{$logoUrl}' alt='Campus Logo' style='width: 150px; height: auto;'>
                </div>
                <h2 style='color: #333; border-bottom: 2px solid #f4f4f4; padding-bottom: 10px;'>Campus Facility System</h2>
                <div style='line-height: 1.6; color: #555;'>
                    " . nl2br(e($content)) . "
                </div>
                <footer style='margin-top: 30px; font-size: 12px; color: #999; text-align: center;'>
                    &copy; " . date('Y') . " Campus Facility Reservation System. All rights reserved.
                </footer>
            </div>
        ";

        try {
            Mail::html($htmlContent, function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            });
            return true;
        } catch (\Exception $e) {
            Log::error("SMTP Mail Error: " . $e->getMessage());
            return false;
        }
    }
}