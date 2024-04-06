<?php
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;

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


Route::get('/index',[UserController::class,'index']);
Route::any('/index/{shop}',[UserController::class,'indexes'])->name('index');
Route::post('/index',[UserController::class,'data_storage']);
Route::get('/redirect',[UserController::class,'redirect']);

Route::any('/gettoken',[UserController::class,'gettoken']);
Route::any('/dascore/{shop}',[UserController::class,'DA'])->name('da');
Route::any('/dascore',[UserController::class,'DA'])->name('da');
Route::any('/showdata',[UserController::class,'showdata']);
 Route::any('/product/{shop}',[UserController::class,'get_product'])->name('product');
 Route::any('/blogs/{shop}',[UserController::class,'get_blogs'])->name('blogs');
 Route::any('/pages/{shop}',[UserController::class,'get_pages'])->name('pages');
//Route::any('/product',[UserController::class,'get_product'])->name('product');
// Route::get('/home',[UserController::class,'home'])->name('home');
// Route::get('/settings/{shop}',[UserController::class,'settings'])->name('settings');
 Route::get('/instructions/{shop}',[UserController::class,'instructions'])->name('instructions');
Route::any('/search',[UserController::class,'product_search'])->name('product_search');
// Route::any('/search',[UserController::class,'product_search'])->name('product_search');
//Route::any('/instructions',[UserController::class,'instructions'])->name('instructions');
Route::any("/webhook",[UserController::class,'webhook'])->name('web');
Route::any("/webhookproduct",[UserController::class,'webhook_product_create']);
Route::any("/webhookprod-del",[UserController::class,'webhook_product_del']);
Route::any("/webhookprod-upd",[UserController::class,'webhook_product_upd']);

// Route::any('/inbound/{ids}/{shop}',[UserController::class,'inboundlists'])->name('inboundlist');
Route::any('/inbound',[UserController::class,'inboundlists'])->name('inboundlist');
Route::any('/show',[UserController::class,'show'])->name('show');
// Route::any('/fetch',[UserController::class,'fetch'])->name('fetch');
Route::any('/publishdata',[UserController::class,'publish'])->name('publish');
//Route::any('/outbound/{shop}',[UserController::class,'outboundlink'])->name('outbound');
Route::any('/outbound',[UserController::class,'outboundlink'])->name('outbound');
// Route::any('/links',[UserController::class,'links']);
Route::any('/chart/{shop}',[UserController::class,'barchart'])->name('chart');
Route::any('/test',[UserController::class,'testurl']);
 Route::any('/payment',[UserController::class,'payment']);
//  Route::any('/viewlinks',[UserController::class,'viewlinks']);
 Route::any('/score',[UserController::class,'score']);
 Route::any('/keyword',[UserController::class,'keyword'])->name('keyword');
//  Route::any('/popkey',[UserController::class,'popkey'])->name('keyword');
 Route::any('/delkey',[UserController::class,'delete']);
//  Route::get('/short/{urlKey}', '\AshAllenDesign\ShortURL\Controllers\ShortURLController');
Route::any('/create',[UserController::class,'productpage_create']);
Route::any('/outbound-links',[UserController::class,'page_template']);
Route::any('/plan/{shop}/{name}',[UserController::class,'payment'])->name('plan');
// Route::any('/outbound-links-data',[UserController::class,'ajax_data']);
// Route::any('/ajax',[UserController::class,'ajax_data']);
Route::get('/freelinks',[UserController::class,'freelinks']);
Route::post('/freelinks',[UserController::class,'freelinkssubmission'])->name('free');
// Route::get('/insertdata',[UserController::class,'insert_data']);