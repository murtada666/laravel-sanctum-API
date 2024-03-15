<?php
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// We can use resource if we have just a basic CRUD(php artisan route:list will show all the routes)
// Route::resource('products', ProductController::class);
// Search is not included in resource so we need to create this route.
// Route::get('/products/search/{name}', [ProductController::class, 'search']);

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
});



// Route::get('/products', [ProductController::class, 'index']);

// Route::get('/products/{product}', [ProductController::class, 'show']);

// Route::post('/products', [ProductController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


