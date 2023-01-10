<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


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

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'loginPost'])->middleware('guest');


Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, "logout"]);

    Route::get('/', [DashboardController::class, "index"]);
});

Route::get('/kirim', function () {
    Mail::send('mail.tes', [], function ($message) {
        $message->from('eksype72@gmail.com', 'SIMEKAR');
        $message->to('sallieeky@gmail.com', 'Sallie Eky');
        $message->subject("Tes Kirim Dari SIMEKAR");
    });
    return "BERHASIL";
});



// FORGET PASSWORD
Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
})->middleware('guest')->name('password.request');

Route::post('/lupa-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');
