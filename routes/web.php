<?php

use App\Http\Controllers\AsetServiceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WhatsApp;
use Illuminate\Auth\Events\PasswordReset;
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
        Route::get('/user/get/{user}', [UserController::class, "get"]);
        Route::post('/user/tambah', [UserController::class, "tambah"]);
        Route::post('/user/edit/', [UserController::class, "edit"]);
        Route::delete('/user/delete/', [UserController::class, "delete"]);

        Route::get('/kendaraan', [KendaraanController::class, "index"]);
        Route::post('/kendaraan/tampilkan/{kendaraan}', [KendaraanController::class, "tampilkan"]);
        Route::get('/kendaraan/get/{kendaraan}', [KendaraanController::class, "get"]);
        Route::post('/kendaraan/tambah', [KendaraanController::class, "tambah"]);
        Route::post('/kendaraan/edit', [KendaraanController::class, "edit"]);
        Route::delete('/kendaraan/delete', [KendaraanController::class, "delete"]);

        Route::get("/driver", [DriverController::class, 'index']);
        Route::post('/driver/tampilkan/{driver}', [DriverController::class, "tampilkan"]);
        Route::get("/driver/get/{driver}", [DriverController::class, 'get']);
        Route::post("/driver/tambah", [DriverController::class, 'tambah']);
        Route::post("/driver/edit", [DriverController::class, 'edit']);
        Route::delete("/driver/delete", [DriverController::class, 'delete']);

        Route::get("/asset-service/data", [AsetServiceController::class, 'data']);
        Route::post("/asset-service/data/aset", [AsetServiceController::class, 'tambahAset']);
        Route::post("/asset-service/data/service", [AsetServiceController::class, 'tambahService']);

        Route::get("/asset-service/rekap", [AsetServiceController::class, 'rekap']);

        Route::get("/asset-service/rekap/aset/get/{aset}", [AsetServiceController::class, 'getAset']);
        Route::post("/asset-service/rekap/aset/edit", [AsetServiceController::class, 'editAset']);
        Route::delete("/asset-service/rekap/aset/delete", [AsetServiceController::class, 'deleteAset']);

        Route::get("/asset-service/rekap/service/get/{service}", [AsetServiceController::class, 'getService']);
        Route::post("/asset-service/rekap/service/edit", [AsetServiceController::class, 'editService']);
        Route::delete("/asset-service/rekap/service/delete", [AsetServiceController::class, 'deleteService']);
        Route::get("/asset-service/rekap/export", [AsetServiceController::class, 'rekapExport']);
    });

    Route::prefix('user')->middleware("user")->group(function () {
        Route::prefix('peminjaman')->group(function () {
            Route::get("/pengajuan", [PeminjamanController::class, 'pengajuan']);
            Route::post("/pengajuan", [PeminjamanController::class, 'pengajuanPost']);
            Route::post("/pengajuan/cek", [PeminjamanController::class, 'pengajuanCek']);

            Route::get("/riwayat", [PeminjamanController::class, 'riwayat']);
            Route::post("/riwayat/nota/{aksi}", [PeminjamanController::class, 'riwayatNota']);
        });

        Route::prefix('reimbursement')->group(function () {
            Route::get("/pengajuan", [ReimbursementController::class, 'pengajuan']);
            Route::post("/pengajuan", [ReimbursementController::class, 'pengajuanPost']);

            Route::get("/riwayat", [ReimbursementController::class, 'riwayat']);
            Route::post("/riwayat/nota/{aksi}", [ReimbursementController::class, 'riwayatNota']);
        });
    });
    Route::prefix('admin')->middleware("admin")->group(function () {
        Route::prefix('peminjaman')->group(function () {
            Route::get("/pengajuan", [PeminjamanController::class, 'pengajuan']);
            Route::get("/rekapitulasi", [PeminjamanController::class, 'rekap']);

            Route::get("/pengajuan/rekapitulasi/export", [PeminjamanController::class, 'rekapExport']);
        });

        Route::prefix('reimbursement')->group(function () {
            Route::get("/pengajuan", [ReimbursementController::class, 'pengajuan']);
            Route::post("/pengajuan/respon", [ReimbursementController::class, 'pengajuanRespon']);
            Route::get("/rekapitulasi", [ReimbursementController::class, 'rekap']);

            Route::get("/pengajuan/rekapitulasi/export", [ReimbursementController::class, 'rekapExport']);
        });
    });

    Route::post("/peminjaman/selesai/{peminjaman}", [PeminjamanController::class, 'selesai']);
    Route::post("/peminjaman/batal/{peminjaman}", [PeminjamanController::class, 'batal']);
});

Route::prefix('cron')->group(function () {
    Route::get("/daily", [CronController::class, "daily"]);
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


Route::get("/tes", function () {
    // $file = fopen(public_path('user.csv'), 'r');
    // $i = 1;
    // while (($row = fgetcsv($file, 1000, ",")) !== FALSE) {
    //     // continue if first row
    //     if ($i == 1) {
    //         $i++;
    //         continue;
    //     }
    //     $data = explode(";", $row[0]);
    //     User::create([
    //         'nama' => $data[0],
    //         'email' => $data[3],
    //         'password' => bcrypt($data[4]),
    //         'role' => 'user',
    //         'no_hp' => $data[1]
    //     ]);
    //     $i++;
    // }

    // fclose($file);
});
