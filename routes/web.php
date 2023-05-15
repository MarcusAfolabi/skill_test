<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(SmsController::class)->group(function () { 
    Route::get('/sms', 'index')->name('welcome');
    Route::post('/sms/send', 'sendSms')->name('sms.send');
    Route::view('/sms-summary', 'smsSummary')->name('sms.summary');

});
