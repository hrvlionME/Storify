<?php


use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Middleware\CheckAdmin;


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

/*Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});*/


Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard/stories/{activeStory:slug}', [DashboardController::class, 'show'])->name('dashboard.show');

Route::middleware('auth')->group(function () {
    //Route::get('/stories', [StoriesController::class, 'index']);
   // Route::get('/stories/{story}', [StoriesController::class, 'show'])->name('stories.show');
    Route::resource('stories', StoriesController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/email', [DashboardController::class, 'email'])->name('dashboard.email');

Route::get('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

Route::namespace('Admin')->prefix('admin')->middleware('auth', CheckAdmin::class)->group(function () {
    Route::get('/deleted_stories', [\App\Http\Controllers\Admin\StoriesController::class, 'index'])->name('admin.stories.index');
    Route::put('/stories/restore/{id}', [\App\Http\Controllers\Admin\StoriesController::class, 'restore'])->name('admin.stories.restore');
    Route::delete('/stories/delete/{id}', [\App\Http\Controllers\Admin\StoriesController::class, 'delete'])->name('admin.stories.restore');
});

Route::get('/image', function(){
    $imagePath = public_path('storage/logo3.jpg');
    $writePath = public_path('storage/thunbnail.jpg');

    $img = \Intervention\Image\ImageManagerStatic::make('storage/logo3.jpg')->resize(300, 200);
    $img->save($writePath);
    return $img->response('jpg');
});

require __DIR__.'/auth.php';

