<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResponsibleController;
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
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/home', [UserController::class, 'home'])->middleware('auth')->name('home');

Route::get('/admin', [AdminController::class, 'index'])->middleware('auth')->name('admin');
Route::post('/admin/save', [AdminController::class, 'save'])->middleware('auth')->name('saveAdmin');
Route::post('/admin/edit/{id}', [AdminController::class, 'edit'])->middleware('auth')->name('editAdmin');
Route::post('/admin/delete/{id}', [AdminController::class, 'delete'])->middleware('auth')->name('deleteAdmin');

Route::get('/student', [StudentController::class, 'index'])->middleware('auth')->name('student');
Route::post('/student/save', [StudentController::class, 'save'])->middleware('auth')->name('saveStudent');
Route::post('/student/edit/{id}', [StudentController::class, 'edit'])->middleware('auth')->name('editStudent');
Route::post('/student/delete/{id}', [StudentController::class, 'delete'])->middleware('auth')->name('deleteStudent');
Route::post('/student/deposit/{id}', [StudentController::class, 'deposit'])->middleware('auth')->name('depositStudent');

Route::get('/responsible/', [ResponsibleController::class, 'index'])->middleware('auth')->name('responsible');
Route::post('/responsible/save', [ResponsibleController::class, 'save'])->middleware('auth')->name('saveResponsible');
Route::post('/responsible/edit/{id}', [ResponsibleController::class, 'edit'])->middleware('auth')->name('editResponsible');
Route::post('/responsible/delete/{id}', [ResponsibleController::class, 'delete'])->middleware('auth')->name('deleteResponsible');

Route::get('/product', [ProductController::class, 'index'])->middleware('auth')->name('product');
Route::post('/product/save', [ResponsibleController::class, 'save'])->middleware('auth')->name('saveProduct');
Route::post('/product/edit/{id}', [ResponsibleController::class, 'edit'])->middleware('auth')->name('editProduct');
Route::post('/product/delete/{id}', [ResponsibleController::class, 'delete'])->middleware('auth')->name('deleteProduct');