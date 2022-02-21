<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/test', function() {
    $folder = 'a';
    $qr_code =  QrCode::size(300)->generate('aaa');
    return $qr_code;
    $dir = "uploads/${folder}/" . date('Y') . "-" . date('m') . "-" . date('d');
    $path = $qr_code->store('public/' . $dir);
    $storage = url('/') . Storage::url($path);
    if ($qr_code) {
        $storage = url('/') . str_replace('/storage', '', $storage);
    }

    return ['data' => $storage, 'status' => 200, 'message' => 'Tải ảnh thành công!'];

});
require __DIR__.'/auth.php';
