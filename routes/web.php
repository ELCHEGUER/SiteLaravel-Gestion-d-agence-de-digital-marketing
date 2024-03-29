<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\RevenueController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class , 'redirect'])->name('home');

//Admin Route
//tasks part

Route::get('/respo/tasks',[TaskController::class,'indexR'])->name('respo.tasks.indexR');
Route::get('/respo/tasks/create',[TaskController::class,'createR'])->name('responsable.task.create');
Route::get('/respo/clients',[ClientController::class,'indexR'])->name('respo.clients.indexR');
Route::get('/respo/clients/create',[ClientController::class,'createR'])->name('responsable.clients.create');
Route::post('/respo/clients', [ClientController::class,'storeR'])->name('respo.clients.store');
Route::post('/respo/tasks', [TaskController::class,'storeR'])->name('respo.task.store');


Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients.index');
Route::get('/admin/clients/create', [ClientController::class, 'create'])->name('admin.clients.create');
Route::post('/admin/clients', [ClientController::class,'store'])->name('admin.clients.store');

Route::get('/admin/tasks',[TaskController::class,'index'])->name('admin.tasks.index');
Route::get('/admin/tasks/create', [TaskController::class, 'create'])->name('admin.tasks.create');
Route::post('/admin/tasks', [TaskController::class,'store'])->name('admin.tasks.store');

Route::get('/admin/gestion/charge', [ChargeController::class, 'index'])->name('admin.gestion.charge.index');
Route::get('/admin/gestion/charge/create', [ChargeController::class, 'create'])->name('admin.gestion.charge.create');
Route::post('/admin/gestion/charge', [ChargeController::class,'store'])->name('admin.gestion.charge.store');
Route::delete('/admin/charge/{id}' ,[ChargeController::class , 'destroy'])->name('admin.charge.delete');

Route::get('/admin/gestion/revenue', [RevenueController::class, 'index'])->name('admin.gestion.revenue.index');
Route::get('/admin/gestion/revenue/create', [RevenueController::class, 'create'])->name('admin.gestion.revenue.create');
Route::post('/admin/gestion/revenue', [RevenueController::class,'store'])->name('admin.gestion.revenue.store');
Route::delete('/admin/revenue/{id}' ,[RevenueController::class , 'destroy'])->name('admin.revenue.delete');

Route::patch('/admin/home/{id}', [TaskController::class, 'updateTaskStatus'])->name('admin.home');
Route::patch('/responsable/home/{id}', [TaskController::class, 'updateTaskStatus'])->name('responsable.home');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
