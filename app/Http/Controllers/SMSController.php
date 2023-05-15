<?php

namespace App\Http\Controllers;

use App\Models\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('welcome');
    }


    public function sendSms(Request $request)
    {
        $message = $request->input('message');
        $recipients = $request->input('recipients');

        // Replace numeric values starting with 0 with 234 in recipients (unchanged)
        $recipients = preg_replace('/\b0(\d+)/', '234$1', $recipients);
        // Split recipients by comma or new lines
        $recipientsArray = preg_split('/,|\r\n?|\n/', $recipients);
        // dd($recipientsArray);

        // Load and parse the text file containing prefixes and charges
        $lines = file(public_path('PriceList.txt'), FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $prefixCharges = [];

        foreach ($lines as $line) {
            list($prefix, $charge) = explode("=", $line);
            $prefixCharges[$prefix] = floatval($charge);
        }

        $totalCharge = 0;

        if (!empty($recipientsArray)) {
            foreach ($recipientsArray as $recipient) {
                $prefix = substr($recipient, 0, 6);
                $charge = $prefixCharges[$prefix] ?? 0;
                $totalCharge += $charge;
            }
        } else {
            // Handle the case when $recipientsArray is empty
            abort(404);
        }

       
        $numPages = ceil(strlen($message) / 160);
        $numRecipients = count($recipientsArray);
        $totalChargeFormatted = number_format($totalCharge, 2);

        return view('sms_summary', compact('numPages', 'numRecipients', 'totalChargeFormatted'));
    }



    public function smsSummary(Request $request, Sms $sms)
    {
        $numPages = $request->session()->get('numPages');
        $numRecipients = $request->session()->get('numRecipients');
        $totalChargeFormatted = $request->session()->get('totalCharge');
        return view('sms_summary', compact('numPages', 'numRecipients', 'totalChargeFormatted'));
    }
}
