<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\UserController;
use App\Models\Driver;
use App\Models\Kendaraan;
use App\Models\Peminjaman;
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
            Route::get("/riwayat", [ReimbursementController::class, 'riwayat']);
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
            Route::get("/rekapitulasi", [ReimbursementController::class, 'rekap']);
        });
    });

    Route::post("/peminjaman/selesai/{peminjaman}", [PeminjamanController::class, 'selesai']);
    Route::post("/peminjaman/batal/{peminjaman}", [PeminjamanController::class, 'batal']);
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

Route::get("/tes", function () {
    return view("tes3");
});

// Route::get("/selesai/{peminjaman}", function (Peminjaman $peminjaman) {
//     $peminjaman->status = "selesai";
//     $peminjaman->save();

//     // cek peminjaman status menunggu
//     $peminjamanMenunggu = Peminjaman::where("status", "menunggu")->orderBy('waktu_peminjaman', 'asc')->first();
//     if ($peminjamanMenunggu) {
//         $peminjamanMenunggu->driver_id = $peminjaman->driver_id;
//         $peminjamanMenunggu->kendaraan_id = $peminjaman->kendaraan_id;
//         $peminjamanMenunggu->status = "dipakai";
//         $peminjamanMenunggu->save();
//     } else {
//         // update isReady driver dan kendaraan menjadi true
//         Driver::where("id", $peminjaman->driver_id)->update(["isReady" => true]);
//         Kendaraan::where("id", $peminjaman->kendaraan_id)->update(["isReady" => true]);
//     }
//     return redirect()->back();
// });

Route::get('/pdf', [KendaraanController::class, "pdf"]);

Route::get('/wa', function () {
    // $api_key   = 'd5a5c5eddbf6e9d9902547787c2ae4ca7572bb2a'; // API KEY Anda
    // $id_device = '12345'; // ID DEVICE yang di SCAN (Sebagai pengirim)
    // $url   = 'https://api.watsap.id/send-message'; // URL API
    // $no_hp = '081243942304'; // No.HP yang dikirim (No.HP Penerima)
    // $pesan = 'TES TES'; // Pesan yang dikirim

    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_HEADER, 0);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    // curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
    // curl_setopt($curl, CURLOPT_TIMEOUT, 0); // batas waktu response
    // curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    // curl_setopt($curl, CURLOPT_POST, 1);

    // $data_post = [
    //     'id_device' => $id_device,
    //     'api-key' => $api_key,
    //     'no_hp'   => $no_hp,
    //     'pesan'   => $pesan
    // ];
    // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data_post));
    // curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    // $response = curl_exec($curl);
    // curl_close($curl);
    // echo $response;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.waayo.id/inowa-core/v1/send_message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => '{
        "key":"96d52ec019974bc19b8d15218992e937-1619514439",
        "phone_no":"081243942304",
        "message":"Ini Adalah contoh message kirim via WA"
    }',
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response . "wad";
});
