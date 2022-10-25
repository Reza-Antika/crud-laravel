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
*/

Route::get('hash-make', function(){
    return Hash::make("212121");
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/', [App\Http\Controllers\LandingpageController::class, 'index'])->name('index');
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::post('/auth-login', [App\Http\Controllers\LoginController::class, 'login'])->name('auth-login');
Route::get('/register', [App\Http\Controllers\RegisterController::class,'registerIndex'])->name('register');
Route::post('/auth-regist', [App\Http\Controllers\RegisterController::class,'register'])->name('auth-regist');

Route::prefix('category')->group(function(){
Route::get('/', [App\Http\Controllers\CategoryController::class, 'index']);
Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create']);
Route::post('/store', [App\Http\Controllers\CategoryController::class, 'store']);
Route::get('/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit']);
Route::post('/update/{id}', [App\Http\Controllers\CategoryController::class, 'update']);
Route::post('/destroy/{id}', [App\Http\Controllers\CategoryController::class, 'destroy']);
Route::get('/search', [App\Http\Controllers\CategoryController::class, 'search'])->name('search');
});

Route::middleware(['checklevel:ADMIN'])->group(function(){
    Route::prefix('category2')->group(function(){
        Route::get('/', [App\Http\Controllers\Category2Controller::class, 'index']);
        Route::get('/getData', [App\Http\Controllers\Category2Controller::class, 'getData']);
        Route::post('/createData', [App\Http\Controllers\Category2Controller::class, 'createData']);
        Route::post('/updateData/{id}', [App\Http\Controllers\Category2Controller::class,'updateData']);
        Route::post('/deleteData/{id}', [App\Http\Controllers\Category2Controller::class,'deleteData']);
        Route::post('/updateStatus/{id}', [App\Http\Controllers\Category2Controller::class, 'updateStatus']);
        
    });
});

// Route::middleware(['checklevel:USER'])->group(function(){
Route::prefix('news')->group(function(){
    Route::get('/', [App\Http\Controllers\NewsController::class, 'index']);
    Route::get('/getData', [App\Http\Controllers\NewsController::class, 'getData']);
    Route::post('/createData', [App\Http\Controllers\NewsController::class, 'createData']);
    Route::post('/updateData/{id}', [App\Http\Controllers\NewsController::class, 'updateData']);
    Route::post('/deleteData/{id}', [App\Http\Controllers\NewsController::class, 'deleteData']);
    Route::get('/restoreData', [App\Http\Controllers\NewsController::class, 'restoreData']);
    Route::get('/deletePermanentData', [App\Http\Controllers\NewsController::class, 'deletePermanentData']);
});
// });


Route::prefix('profile')->group(function(){
    Route::get('/', [App\Http\Controllers\ProfileController::class,'index'])->name('profile');
    Route::get('/getData', [App\Http\Controllers\ProfileController::class,'getData'])->name('getData');
    Route::post('/updateData/{id}', [App\Http\Controllers\ProfileController::class,'updateData'])->name('updateData');
    Route::post('/updatePassword/{id}', [App\Http\Controllers\ProfileController::class,'updatePassword'])->name('updatePassword');
});

    Route::get('/comment', [App\Http\Controllers\CommentController::class,'index']);
    Route::get('/comment/getData', [App\Http\Controllers\CommentController::class,'getData']);
    Route::post('/comment/createData', [App\Http\Controllers\CommentController::class,'createData']);
 



// Auth::routes();
Route::get('logout', function(){
    Auth::logout();
    return redirect('/login');
});

Route::middleware(['web'])->group(function(){
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});

