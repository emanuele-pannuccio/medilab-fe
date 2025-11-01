<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UIDashboardController;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    return view('login');
})->name("login")->middleware('guest');

Route::prefix('/auth')->group(function(){
    Route::post('/login', [ AuthController::class, "authLogin" ])->middleware('guest');
    Route::get('/logout', [ AuthController::class, "authLogout" ])->middleware('auth');
});

Route::middleware("auth")->group(function(){
    Route::get('/dashboard', [UIDashboardController::class, "index"])->name("dashboard");
    Route::get('/reports/{report}', function(Report $report){
        return view("patient")->with("report",  $report);
    })->name("dashboard");
});
