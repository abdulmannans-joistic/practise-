<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\MessengerBotController;
use App\Http\Controllers\WebviewController;

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
    return view('welcome', ['title' => 'Welcome Page']);
});



Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/', [HomeController::class, 'index'])->name('home');



Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/campaigns/create', [CampaignController::class, 'create'])->name('campaigns.create');
    Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaigns.store');
    Route::post('/campaigns/{campaign}/questions', [CampaignController::class, 'addQuestions'])->name('campaigns.questions.store');
    Route::get('/campaigns/{campaign}/qr-code', [CampaignController::class, 'createQrCode'])->name('campaigns.qr_code.create');
    Route::post('/campaigns/{campaign}/qr-code/generate', [CampaignController::class, 'generateQrCode'])->name('campaigns.qr_code.generate');
});


Route::get('storage/{path}', function ($path) {
    $path = Storage::disk('public')->path($path);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('path', '.*');


Route::get('/webhook', [MessengerBotController::class, 'verifyWebhook']);
Route::post('/webhook', [MessengerBotController::class, 'handleWebhook']);
Route::get('/application-form/{campaignId}/{userId}', [WebviewController::class, 'applicationForm'])->name('application.form');
Route::post('/submit-application-form/{campaignId}/{userId}', [WebviewController::class, 'submitApplicationForm'])->name('application.submit');




