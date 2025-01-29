<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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




Route::get('/',[LoginController::class,'loginView'])->name('loginView');
Route::post('login',[LoginController::class,'login'])->name('login');

Route::group(['middleware' => 'AdminAuthCheck'],function(){

    Route::get('logout',[LoginController::class,'logout'])->name('logout');
    
    Route::get('booksView',[AdminController::class,'booksView'])->name('booksView');
    Route::get('addBookView',[AdminController::class,'addBookView'])->name('addBookView');

    Route::post('saveCategory',[AdminController::class,'saveCategory'])->name('saveCategory');
    
    Route::get('categoryList',[AdminController::class,'categoryList'])->name('categoryList');

    Route::get('deleteCategory',[AdminController::class,'deleteCategory'])->name('deleteCategory');

    Route::post('getCategoryData',[AdminController::class,'getCategoryData'])->name('getCategoryData');

    Route::post('editCategorySave',[AdminController::class,'editCategorySave'])->name('editCategorySave');

    Route::get('authorList',[AdminController::class,'authorList'])->name('authorList');

    Route::post('addAuthorSave',[AdminController::class,'addAuthorSave'])->name('addAuthorSave');

    Route::post('getAuthorDetails',[AdminController::class,'getAuthorDetails'])->name('getAuthorDetails');

    Route::post('editAuthorSave',[AdminController::class,'editAuthorSave'])->name('editAuthorSave');

    Route::post('bookSave',[AdminController::class,'bookSave'])->name('bookSave');

    Route::get('deleteAuthor',[AdminController::class,'deleteAuthor'])->name('deleteAuthor');

    Route::get('deleteBook',[AdminController::class,'deleteBook'])->name('deleteBook');

    Route::get('editBookView',[AdminController::class,'editBookView'])->name('editBookView');

    Route::post('editBookSave',[AdminController::class,'editBookSave'])->name('editBookSave');

    Route::get('bookHistoryView',[AdminController::class,'bookHistoryView'])->name('bookHistoryView');

});


Route::get('userLoginView',[LoginController::class,'userLoginView'])->name('userLoginView');

Route::get('userRegisterView',[LoginController::class,'userRegisterView'])->name('userRegisterView');

Route::post('userLogin',[LoginController::class,'userLogin'])->name('userLogin');

Route::post('userRegister',[LoginController::class,'userRegister'])->name('userRegister');

Route::group(['middleware'=>'UserAuthCheck'],function(){

    Route::get('borrowBooksView',[UserController::class,'borrowBooksView'])->name('borrowBooksView');
    
    Route::post('borrowBook',[UserController::class,'borrowBook'])->name('borrowBook');

    Route::get('userLogout',[LoginController::class,'userLogout'])->name('userLogout');

});

