<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;

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

Route::view('/login', 'login');
Route::post('/login', [UserController::class, 'authenticate'])->name('login');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

Route::get('/home', [UserController::class, 'home'])->middleware('auth')->name('home');

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth')->name('admin');
Route::post('/admin/save', [AdminController::class, 'save'])->name('saveAdmin');
Route::post('/admin/edit/{id}', [AdminController::class, 'edit'])->name('editAdmin');
Route::post('/admin/delete/{id}', [AdminController::class, 'delete'])->name('deleteAdmin');

Route::get('/student', [StudentController::class, 'index'])->middleware('auth')->name('student');
Route::post('/student/save', [StudentController::class, 'save'])->name('saveStudent');
Route::post('/student/edit/{id}', [StudentController::class, 'edit'])->name('editStudent');
Route::post('/student/delete/{id}', [StudentController::class, 'delete'])->name('deleteStudent');
