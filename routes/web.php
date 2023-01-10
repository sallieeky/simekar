<?php

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Route::get('/kirim', function () {
    Mail::send('mail.tes', [], function ($message) {
        $message->from('eksype72@gmail.com', 'SIMEKAR');
        $message->to('sallieeky@gmail.com', 'Sallie Eky');
        $message->subject("Tes Kirim Dari SIMEKAR");
    });
    return "BERHASIL";
});
