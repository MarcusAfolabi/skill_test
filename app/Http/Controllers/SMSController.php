<?php
namespace App\Http\Controllers;

use App\Models\SMS;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSController extends Controller
{
    public function create()
    {
        return view('sms.create');
    }

    public function store(Request $request)
    {
        // Validate the request data (modify as per your requirements)
        $request->validate([
            'sender_id' => 'required',
            'recipients' => 'required',
            'message' => 'required',
        ]);

        // Save the SMS to the database
        $sms = SMS::create([
            'sender_id' => $request->sender_id,
            'recipient' => $request->recipients,
            'message' => $request->message,
        ]);

        // Call the SMS API endpoint to send the message (modify as per your chosen API)
        $apiEndpoint = 'https://api.example.com/send-sms'; // Replace with your API endpoint
        $apiKey = 'your-api-key'; // Replace with your API key

        $payload = [
            'sender_id' => $sms->sender_id,
            'recipients' => $sms->recipient,
            'message' => $sms->message,
            // Additional payload data as required by your API
        ];

        $headers = [
            'Authorization' => 'Bearer ' . $apiKey,
            // Additional headers as required by your API
        ];

        $response = Http::post($apiEndpoint, $payload, $headers);

        if ($response->successful()) {
            // Handle successful API response
            // You can log the response or display a success message
        } else {
            // Handle API request error
            $errorMessage = $response->body();
            // You can log the error or display a user-friendly message
        }

        // Redirect the user to a success page or any other desired action
        return redirect()->route('sms.create')->with('success', 'SMS sent successfully!');
    }
}
