<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PDFController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login') ;
    Route::post('resetPassword', 'resetPassword') ;
    Route::post('changePassword', 'changePassword') ;

    Route::post('register', 'register') ;
    Route::post('register_update', 'register_update') ;

    Route::post('information', 'information') ;
    Route::post('deleteInformasi', 'deleteInformasi') ;
    Route::get('getInformasi', 'getInformasi') ;
    Route::get('informasi_detail/{id}', 'informasi_detail') ;
    Route::post('information_update', 'information_update') ;

    Route::post('balas_kritik', 'balas_kritik') ;
    Route::post('kritik', 'kritik') ;
    Route::get('getKritik', 'getKritik') ;
    Route::get('count_kritik', 'count_kritik') ;
    Route::get('count_kritik_total', 'count_kritik_total') ;

    Route::post('nilai', 'nilai') ;
    Route::get('nilai_detail/{nisn}/{kelas}/{pelajaran}/{smester}', 'nilai_detail') ;

    Route::get('getKelasSiswa', 'getKelasSiswa') ;
    Route::get('getWaliKelasSiswa', 'getWaliKelasSiswa') ;
    Route::get('nilaiKelas', 'nilaiKelas') ;
    Route::get('nilaiSmester', 'nilaiSmester') ;
    Route::get('kelas', 'kelas') ;
    Route::get('getKelas', 'getKelas') ;
    Route::get('kelas_siswa/{nisn}', 'kelas_siswa') ;

    Route::get('guru/{param}', 'guru') ;
    Route::post('guru_add', 'guru_add') ;
    Route::post('guru_update', 'guru_update') ;
    Route::get('guru_detail/{nisn}', 'guru_detail') ;
    Route::post('deleteGuru', 'deleteGuru') ;

    Route::post('deleteWaliKelas', 'deleteWaliKelas') ;
    Route::post('simpanWaliKelas', 'simpanWaliKelas') ;

    Route::get('pelajaran', 'pelajaran') ;
    Route::get('nilai_pelajaran/{nisn}/{kelas}/{smester}', 'nilai_pelajaran') ;

    Route::get('siswa/{param}', 'siswa') ;
    Route::post('simpanSiswa', 'simpanSiswa') ;
    Route::get('siswa_per_class', 'siswa_per_class') ;
    Route::get('siswa_detail/{nisn}', 'siswa_detail') ;
    Route::post('deleteSiswa', 'deleteSiswa') ;
    Route::post('deleteSiswaPerKelas', 'deleteSiswaPerKelas') ;
    Route::get('count_siswa', 'count_siswa') ;
    Route::get('create-pdf-kritik-saran/{periode}', [PDFController::class, 'pdfKritikSaran']);
    Route::get('create-pdf-informasi/{periode}', [PDFController::class, 'pdfInformasi']);
    Route::get('create-pdf-nilai/{semester}/{kelas}/{nisn}', [PDFController::class, 'pdfNilai']);

});
