<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'auth'], function ()
{

	//dashboard---------------------------------------------->>
	Route::get('dashboard', function () {
	    return view('dashboard'); 
	});


	//anggaran---------------------------------------------->>
	Route::get('anggaran',function() {
		return view('anggaran.index');
	});

	Route::get('anggaran/create',function() {
		return view('anggaran.create');
	});

	Route::post('anggaran/search','AnggaranController@search');
	Route::post('anggaran/tahunBulan','AnggaranController@tahunBulan');
	Route::post('anggaran/pdf','AnggaranController@pdf');
	Route::get('anggaran/pdf','AnggaranController@pdf');



	//pengeluaran----------------------------------------------------------------->>
	Route::get('pengeluaran',function() {
		return view('pengeluaran.index');
	});

	Route::get('pengeluaran/create',function() {
		return view('pengeluaran.create');
	});

	Route::post('pengeluaran/tahunBulan','PengeluaranController@tahunBulan');
	Route::post('pengeluaran/pdf','PengeluaranController@pdf');
	Route::get('pengeluaran/pdf','PengeluaranController@pdf');
	Route::get('pengeluaran/{pengeluaran}/detail','PengeluaranController@detail');


	//pemasukan------------------------------------------------------------------------>>
	Route::get('pemasukan',function() {
		return view('pemasukan.index');
	});

	Route::get('pemasukan/create',function() {
		return view('pemasukan.create');
	});

	Route::post('pemasukan/tahunBulan','PemasukanController@tahunBulan');
	Route::post('pemasukan/pdf','PemasukanController@pdf');
	Route::get('pemasukan/pdf','PemasukanController@pdf');

	//laporan------------------------------------------------------------------------>>
	route::get('laporan', function(){
		return view('laporan.index');
	});

	route::get('laporan/labarugi',function(){
		return view('laporan.labarugi');
	});

		
	Route::get('laporan/harga','LaporanController@harga');
	Route::post('laporan/harga/hasilHarga','LaporanController@hasilHarga');
	Route::get('laporan/labarugi','LaporanController@labarugi');
	Route::post('laporan/labarugi/labarugiBulanan','LaporanController@labarugiBulanan');
	Route::get('laporan/bulanan','LaporanController@bulanan');
	Route::post('laporan/bulanan/tahunBulan','LaporanController@tahunBulan');
	Route::post('laporan/labarugi/labarugipdf','LaporanController@labarugipdf');
	Route::get('laporan/labarugi/labarugipdf','LaporanController@labarugipdf');
	Route::post('laporan/bulanan/bulananpdf','LaporanController@bulananpdf');
	Route::get('laporan/bulanan/bulananpdf','LaporanController@bulananpdf');
	Route::post('harga/tahunBulan','hargaController@tahunBulan');

	// sayuran----------------------------------------------------------------------------------->>>

	Route::get('sayuran',function() {
		return view('sayuran.index');
	});

	Route::get('sayuran/create',function() {
		return view('sayuran.create');
	});

	//pengguna-------------------------------------------------------------------------------------->>

	Route::get('pengguna/{pengguna}/reset','PenggunaController@reset');
	Route::get('pengguna/{pengguna}/profil','PenggunaController@profil');

	//all resource -------------------------------------------------------------------------------->>

	Route::resource('anggaran','AnggaranController');
	Route::resource('pengeluaran','PengeluaranController');
	Route::resource('pemasukan','PemasukanController');
	Route::resource('laporan','LaporanController');
	Route::resource('sayuran','sayurController');
	Route::resource('harga', 'hargaController');
	
	
	// 
	
});

// autentifikasi--------------------------------------------------------------------->>
Route::auth();
Route::get('/', 'HomeController@index');
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// daftarkan pengguna alias register========================--------------------------->>

 Route::group(['middleware' => ['auth', 'periksaAdmin']], function () 
 	{
 		Route::get('pengguna',function() 
 			{
				return view('pengguna.index');
			});
		Route::get('pengguna/create',function() 
			{
				return view('pengguna.create');
			});
		Route::resource('pengguna', 'PenggunaController');
    });