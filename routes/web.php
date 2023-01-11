<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
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
    Route::get('/', [DashboardController::class, "index"]);
    Route::get('/logout', [AuthController::class, "logout"]);

    Route::get("/profile", [ProfileController::class, "profile"]);
    Route::post("/profile/ubah-data", [ProfileController::class, "ubahDataProfile"]);

    Route::get("/profile/ubah-password", [ProfileController::class, "ubahPassword"]);
    Route::post("/profile/ubah-password", [ProfileController::class, "ubahPasswordPost"]);

    Route::prefix('master-data')->middleware('admin')->group(function () {
        Route::get('/user', [UserController::class, "index"]);
        Route::post('/user/tambah', [UserController::class, "tambah"]);
        Route::get('/user/get/{user}', [UserController::class, "get"]);
        Route::post('/user/edit/', [UserController::class, "edit"]);
        Route::delete('/user/delete/', [UserController::class, "delete"]);
    });
});

// FORGET PASSWORD
Route::get('/lupa-password', function () {
    return view('auth.lupa-password');
})->middleware('guest')->name('password.request');

Route::post('/lupa-password', function (Request $request) {
    $request->validate([
        'email' => 'required|email|exists:users,email',
    ], [
        'email.exists' => 'Email tidak terdaftar',
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email tidak valid',
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (Request $request, $token) {
    return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8',
        'password_confirmation' => 'required|same:password',
    ], [
        'token.required' => 'Token tidak boleh kosong',
        'email.required' => 'Email tidak boleh kosong',
        'email.email' => 'Email tidak valid',
        'password.required' => 'Password tidak boleh kosong',
        'password.min' => 'Password minimal 8 karakter',
        'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong',
        'password_confirmation.same' => 'Konfirmasi password tidak sama',
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






Route::get('/kirim', function () {
    Mail::send('mail.tes', [], function ($message) {
        $message->from('info@simekar.foundid.my.id', 'SIMEKAR');
        $message->to('sallieeky@gmail.com', 'Sallie Eky');
        $message->subject("Tes Kirim Dari SIMEKAR");
    });
    return "BERHASIL";
});
