<?php

use App\Http\Controllers\Api\CriteriaController as ApiCriteriaController;
use App\Http\Controllers\Api\ResultCriteriaController;
use App\Http\Controllers\Api\ResultSubjectItemController;
use App\Http\Controllers\Api\ResultSubjectItemNormalizedMatrikController;
use App\Http\Controllers\Api\ResultSubjectItemWeightedNormalizedMatrikController;
use App\Http\Controllers\Api\SubjectItemController as ApiSubjectItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\CriteriaController;
use App\Http\Controllers\Web\ResultController;
use App\Http\Controllers\Web\SubjectController;
use App\Http\Controllers\Web\SubjectItemController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return redirect('./login');
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('criteria', CriteriaController::class)->except(['edit', 'create', 'show']);
    Route::resource('subject', SubjectController::class)->except(['create', 'show']);
    Route::resource('subject-item', SubjectItemController::class)->except(['edit', 'create', 'show']);
    Route::resource('result', ResultController::class)->except(['create', 'show']);

    Route::get('criterias', [ApiCriteriaController::class, 'index'])->name('criterias');
    Route::get('subjet-items', [ApiSubjectItemController::class, 'index'])->name('subject-items');
    Route::get('result-criteria', [ResultCriteriaController::class, 'index'])->name('result-criteria');
    Route::get('result-subject-item', [ResultSubjectItemController::class, 'index'])->name('result-subject-item');
    Route::get(
        'result-subject-item-normalized-matrik',
        [
            ResultSubjectItemNormalizedMatrikController::class,
            'index'
        ]
    )
        ->name('result-subject-item-normalized-matrik');

    Route::get(
        'result-subject-item-weighted-normalized-matrik',
        [
            ResultSubjectItemWeightedNormalizedMatrikController::class,
            'index'
        ]
    )
        ->name('result-subject-item-weighted-normalized-matrik');
});

require __DIR__ . '/auth.php';
