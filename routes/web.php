<?php

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

                        <button name="bstable-actions" class="deleteRecord btn btn-xs btn-danger show_confirm"    data-id="'.$data->id.'" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg> </button>
*/

Route::get('/', function () {
    return view('welcome');
});

include_once __DIR__.'/auth.php';

 
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/category', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.view');
    Route::post('/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.store');
    Route::post('/category/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::delete('/delete/{id}', [App\Http\Controllers\CategoryController::class, 'delete'])->name('delete');
    Route::get('/books', [App\Http\Controllers\BooksController::class, 'index'])->name('books.view');
    Route::post('/books', [App\Http\Controllers\BooksController::class, 'store'])->name('books.store');
    Route::post('/books/update', [App\Http\Controllers\BooksController::class, 'update'])->name('books.update');
    Route::delete('/books/delete/{id}', [App\Http\Controllers\BooksController::class, 'delete'])->name('book.delete');
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile');
    Route::get('/select2-autocomplete-ajax-device',[App\Http\Controllers\BooksController::class,'dataAjaxDeviceDropdown'])->name('select2.device');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

});

 