<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\EngineController;
use App\Http\Controllers\PanduanController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog/{title_seo}', [HomeController::class, 'blog'])->name('blog');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('registerPost');
Route::post('/login', [AuthController::class, 'loginStore'])->name('loginPost');

Route::group(['middleware' => ['auth']], function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('panduan', [PanduanController::class, 'index'])->name('panduan.index');
    Route::get('panduan/create', [PanduanController::class, 'create'])->name('panduan.create');
    Route::post('panduan/create', [PanduanController::class, 'store'])->name('panduan.store');
    Route::get('panduan/edit/{id}', [PanduanController::class, 'edit'])->name('panduan.edit');
    Route::post('panduan/update', [PanduanController::class, 'update'])->name('panduan.update');
    Route::get('panduan/delete/{id}', [PanduanController::class, 'destroy'])->name('panduan.destroy');
    Route::get('panduan/detail/{id}', [PanduanController::class, 'detail'])->name('panduan.detail');
    Route::get('panduan/detail/{id}/create', [PanduanController::class, 'detailCreate'])->name('panduan.detail.create');
    Route::post('panduan/detail/create', [PanduanController::class, 'detailStore'])->name('panduan.detail.store');
    Route::get('panduan/detail/{id}/edit', [PanduanController::class, 'detailEdit'])->name('panduan.detail.edit');
    Route::post('panduan/detail-update', [PanduanController::class, 'detailUpdate'])->name('panduan.detail.update');
    Route::get('panduan/detail/delete/{id}', [PanduanController::class, 'detailDestroy'])->name('panduan.detail.destroy');

    Route::get('chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
    Route::get('chatbot/create/{id?}', [ChatbotController::class, 'create'])->name('chatbot.create');
    Route::post('chatbot', [ChatbotController::class, 'store'])->name('chatbot.store');
    Route::get('chatbot/detail/{id}', [ChatbotController::class, 'detail'])->name('chatbot.detail');
    Route::get('chatbot/edit/{id}', [ChatbotController::class, 'edit'])->name('chatbot.edit');
    Route::post('chatbot/update', [ChatbotController::class, 'update_store'])->name('chatbot.update-store');
    Route::delete('chatbot/{id}', [ChatbotController::class, 'destroy'])->name('chatbot.destroy');

    Route::get('engine', [EngineController::class, 'index'])->name('engine.index');
});
