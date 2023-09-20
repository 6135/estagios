<?php
use App\Http\Controllers\Auth\Authentication;

//Authentication Routes

Route::get('login', [Authentication::class, 'loginView'])->name('login');
Route::post('login', [Authentication::class, 'loginPost'])->name('login.post');
Route::get('logout', [Authentication::class, 'logout'])->name('logout');

Route::get('register', [Authentication::class, 'register'])->name('register');
Route::post('register', [Authentication::class, 'registerPost'])->name('register.post');
Route::post('/validate/email', [Authentication::class, 'validateEmail'])->name('validate.email');

//switch role
Route::get('switch-role/{role}', [Authentication::class, 'switchRole'])->name('switch.role');

//see confirmation email
// Route::get('testEmail', [Authentication::class, 'seeConfirmationEmail']);
Route::get('confirm/{hash}', [Authentication::class, 'confirmEmail'])->name('confirm.email');
//details hash
Route::get('details/{hash}', [Authentication::class, 'detailsEmail'])->name('details.email');