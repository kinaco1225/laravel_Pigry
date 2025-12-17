<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeightLogController;
use App\Http\Controllers\WeightTargetController;

/*
|--------------------------------------------------------------------------
| 認証不要
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register/step1', fn() => view('auth.register'))
        ->name('register.step1');

    Route::get('/login', fn() => view('auth.login'))
        ->name('login');
});

/*
|--------------------------------------------------------------------------
| 認証必須
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 会員登録 step2（初期体重・目標体重）
    Route::get('/register/step2', fn() => view('weight_targets.create'))
        ->name('register.step2');

    Route::post('/weight_targets', [WeightTargetController::class, 'store'])
        ->name('register.step2.store');

    Route::get('/weight_logs/search', [WeightLogController::class, 'search'])
        ->name('weight_logs.search');

    // 体重管理（一覧・詳細・更新・削除）
    Route::resource('weight_logs', WeightLogController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);
    
    // 目標体重の設定・更新
    Route::get('/goal_setting', [WeightLogController::class, 'goalSetting'])
        ->name('goal.setting');

    Route::post('/goal_setting', [WeightTargetController::class, 'update'])
        ->name('goal.setting.update');
});
