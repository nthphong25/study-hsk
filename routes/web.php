<?php

use App\Http\Controllers\HSKController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/show', [HSKController::class, 'index']);
Route::get('/api/hsk/{level}/random', function ($level) {
    $path = public_path("hsk/hsk{$level}.json");
    if (!file_exists($path)) {
        return response()->json(['error' => 'Không tìm thấy file'], 404);
    }

    $words = json_decode(file_get_contents($path), true);
    return response()->json($words[array_rand($words)]);
});
require __DIR__.'/auth.php';
