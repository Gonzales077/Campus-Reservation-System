# Google API Setup Guide for HCC Facility Reservation System

## ✅ Current Status
- **Google API client library**: ✅ Installed
- **Error handling**: ✅ System works without credentials
- **Application status**: ✅ Runs without Google API errors

## Overview
This system now uses Google APIs to:
- **Send Emails**: Gmail API sends reservation confirmation, approval, and rejection emails
- **Create Calendar Events**: Google Calendar API automatically creates events when reservations are approved

## Prerequisites
- Google Cloud Project created
- Service Account with appropriate permissions
- Google Calendar (for calendar events)
- Gmail inbox with send capability

## Step 1: Create a Google Cloud Project

1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project:
   - Click the project dropdown at the top
   - Click "New Project"
   - Enter project name: "HCC Facility Reservation"
   - Click "Create"

## Step 2: Enable Required APIs

1. In the Cloud Console, search for "Gmail API"
   - Click on "Gmail API"
   - Click "Enable"

2. Search for "Google Calendar API"
   - Click on "Google Calendar API"
   - Click "Enable"

## Step 3: Create a Service Account

1. Go to "Service Accounts" in the Cloud Console menu
2. Click "Create Service Account"
   - Service Account Name: `facility-reservation-system`
   - Service Account ID: `facility-reservation-system`
   - Click "Create and Continue"

3. At the "Grant this service account access to project" step:
   - Skip this step (click "Continue")

4. At the "Grant users access to this service account" step:
   - Click "Create Key"
   - Choose "JSON"
   - Click "Create"
   - This will download a JSON file - **KEEP THIS FILE SAFE**

## Step 4: Set Up Domain-wide Delegation (For Gmail)

1. Go to the Service Account you just created
2. Click on the "Keys" tab
3. Scroll down and look for "Domain-wide delegation"
4. If not visible, click on the service account name and enable it
5. Note the "Client ID" for later use

## Step 5: Configure the JSON Credentials

1. The JSON file you downloaded contains your credentials
2. Save it to: `storage/app/google-credentials.json`
3. Or configure the path in `.env`:
   ```
   GOOGLE_CREDENTIALS_PATH=storage/app/google-credentials.json
   ```

## Step 6: Set Up Gmail for Sending

### Option A: Using Domain-wide Delegation (Recommended for GSuite)

If you have a Google Workspace account:

1. Go to your Google Workspace Admin Console
2. Navigate to "Security" > "API Controls" > "Domain-wide Delegation"
3. Add the service account Client ID with these scopes:
   ```
   https://www.googleapis.com/auth/gmail.send
   https://www.googleapis.com/auth/calendar
   ```

4. Update your `.env` file:
   ```
   GOOGLE_GMAIL_FROM_EMAIL=your-email@yourorganization.com
   ```

### Option B: Using OAuth 2.0 (For Regular Gmail)

1. Modify the `GoogleApiService.php` to use OAuth 2.0 credentials
2. Set up the redirect URI in your Google API Console
3. Authenticate manually and store the refresh token

## Step 7: Configure Calendar Settings

1. In Google Calendar, create or use an existing calendar
2. Get the Calendar ID:
   - Open Google Calendar settings
   - Find the calendar and note the "Calendar ID"
   - It typically looks like: `xyz123@group.calendar.google.com` or `primary` for main calendar

3. Update your `.env` file:
   ```
   GOOGLE_CALENDAR_ID=primary
   ```
   or
   ```
   GOOGLE_CALENDAR_ID=your-calendar-id@group.calendar.google.com
   ```

## Step 8: Update .env File

Your `.env` should now include:

```env
# Google API Configuration
GOOGLE_CREDENTIALS_PATH=storage/app/google-credentials.json
GOOGLE_GMAIL_FROM_EMAIL=your-email@yourorganization.com
GOOGLE_CALENDAR_ID=primary
```

## Step 9: Test the Integration

1. Clear Laravel cache:
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

2. Test Gmail service:
   ```bash
   php artisan tinker
   >>> $service = app(\App\Services\GmailService::class);
   >>> exit
   ```

3. Create a test reservation and verify:
   - Check your Gmail inbox for the confirmation email
   - Check your Google Calendar for the event (when approved)

## Troubleshooting

### "Cannot find credentials.json"
- Ensure the file is at `storage/app/google-credentials.json`
- Check that `GOOGLE_CREDENTIALS_PATH` in `.env` is correct
- Run `php artisan config:clear`

### "Failed to send email"
- Check application logs: `storage/logs/laravel.log`
- Verify the service account has Gmail API access
- Ensure domain-wide delegation is set up correctly
- Verify `GOOGLE_GMAIL_FROM_EMAIL` matches an email you have permission to send from

### "Failed to create calendar event"
- Verify Google Calendar API is enabled
- Check that the calendar ID is correct
- Review application logs for specific error message
- Ensure the service account can access the calendar

### "Permission denied" errors
- Verify service account email has been added to Google Workspace
- Check Domain-wide Delegation settings
- Ensure all required scopes are included

## File Locations

- Credentials: `storage/app/google-credentials.json` (git-ignored)
- Service Classes: `app/Services/`
  - `GoogleApiService.php` - Main API client
  - `GmailService.php` - Email sending
  - `GoogleCalendarService.php` - Calendar events
- Config: `config/google.php`
- Migration: `database/migrations/2026_03_05_000000_add_google_event_id_to_reservations_table.php`

## Workflow

### When a User Submits a Reservation:
1. Reservation is saved to database with status "pending"
2. Gmail API sends confirmation email to guest with reservation details
3. Admin is notified (through dashboard)

### When Admin Approves a Reservation:
1. Reservation status is updated to "approved"
2. Google Calendar event is created for the approved date
3. Gmail API sends approval email to guest with event details
4. Guest is added to calendar event as attendee

### When Admin Rejects a Reservation:
1. Reservation status is updated to "rejected"
2. Gmail API sends rejection email to guest
3. No calendar event is created

## Security Notes

- **Private Key**: Never commit `google-credentials.json` to Git (already in .gitignore)
- **Scopes**: Only request necessary scopes for security
- **Service Account**: Use a dedicated service account for this application
- **Logs**: Sensitive information may be logged - review logs regularly
- **Credentials Rotation**: Rotate service account keys periodically

## Support

For issues with Google API:
- [Gmail API Documentation](https://developers.google.com/gmail/api)
- [Google Calendar API Documentation](https://developers.google.com/calendar)
- [Authentication Documentation](https://developers.google.com/auth)

Check `storage/logs/laravel.log` for detailed error messages.
