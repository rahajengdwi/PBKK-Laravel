<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::post('/register', function()
// {
//     $user = new User;
//     $user->email    = Input::get('email');
//     $user->password = Hash::make(Input::get('password'));
//     $user->save();

//     return Redirect::to("register");
// });

// Route::post('/register', function()
// {
//     var_dump($_POST);
// });


use Illuminate\Support\Facades\Input;
use App\User;

Route::get('/register', function()
{
    return View::make('register');
});


Route::post('/register', function()
{
    // 1. setting validasi
    $validator = Validator::make(
        Input::all(),
        array(
            "email"                 => "required|email|unique:users,email",
            "password"              => "required|min:6",
            "password_confirmation" => "same:password",
        )
    );

    // 2a. jika semua validasi terpenuhi simpan ke database
    if($validator->passes())
	{
	    $user = new User;
	    $user->email    = Input::get('email');
	    $user->password = Hash::make(Input::get('password'));
	    $user->save();

	    return Redirect::to("register")->with('register_success', 'Selamat, Anda telah resmi menjadi pengangguran, silakan cek email untuk aktivasi :P');
	}
    // 2b. jika tidak, kembali ke halaman form registrasi
    else
    {
        return Redirect::to('register')
            ->withErrors($validator)
            ->withInput();
    }
});