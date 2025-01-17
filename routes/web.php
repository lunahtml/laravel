<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\FreelancerRegistrationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ResumeController as PublicResumeController;
use App\Http\Controllers\Freelancer\ResumeController as FreelancerResumeController;

// Маршрут для публичной страницы с резюме
Route::get('/resumes', [PublicResumeController::class, 'index'])->name('resumes.index');

// Google авторизация
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Личный кабинет фрилансера и работа с резюме
Route::prefix('freelancer')->middleware('auth')->group(function () {
    Route::get('/', [FreelancerResumeController::class, 'index'])->name('freelancer.dashboard');
    Route::post('/resumes', [FreelancerResumeController::class, 'store'])->name('freelancer.resume.store');
    Route::get('/resumes/{id}/edit', [FreelancerResumeController::class, 'edit'])->name('freelancer.resume.edit');
    Route::post('/resumes/{id}', [FreelancerResumeController::class, 'update'])->name('freelancer.resume.update');
});

// Регистрация фрилансера
Route::get('/freelancer/register', [FreelancerRegistrationController::class, 'showRegistrationForm'])
    ->name('freelancer.register');
Route::post('/freelancer/register', [FreelancerRegistrationController::class, 'register']);

Route::get('/api/skills', function (Request $request) {
    $query = $request->input('query'); // Получаем значение параметра 'query'
    $categoryId = $request->input('category_id'); // Получаем значение параметра 'category_id'

    $skills = \App\Models\Skill::where('category_id', $categoryId)
        ->where('name', 'like', "%{$query}%")
        ->get(['id', 'name']);

    return response()->json($skills);
});



// Главная страница
Route::get('/', function () {
    return view('welcome');
});
