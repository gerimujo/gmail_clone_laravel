<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\dhena;
use App\Http\Controllers\rregjistro;





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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/regist',[rregjistro::class,"store"]);
Route::post('/hyremail',[rregjistro::class,"hyremail"]);
Route::get('/email',[rregjistro::class,"emailadr"]);
Route::get('/pasadr',[rregjistro::class,"passadr"]);
Route::get("/shkronjaepar",[rregjistro::class,"emrishronjaepar"]);
Route::post("/dergomesazh",[rregjistro::class,"sendemail"]);
Route::get("/marrsend", [rregjistro::class,"marrsend"]);
Route::get("/marrinobx",[rregjistro::class,"marrinboxz"]);
Route::post("/deletemessage",[rregjistro::class,"deletemessagess"]);
Route::post("/databasemesazh",[rregjistro::class,"insertmesazhhapsend"]);
Route::get("/mesazhinxjerrsend", [rregjistro::class, "sendmesazhehap"]);
Route::get("/inmesazhiinboxsend", [rregjistro::class, "marrmesazhehap"]);
Route::get("/keymarr", [rregjistro::class, "nxjerrkeysearch"]);
Route::get("/logut", [rregjistro::class,"logout"]);
