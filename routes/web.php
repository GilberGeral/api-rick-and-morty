<?php
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CharacterController::class, 'listFromApi']);
Route::get('/guardados', [CharacterController::class, 'listFromLocal']);
Route::get('/editCharacter/{id}', [CharacterController::class, 'viewEdit']);

Route::post('/getCharacter', [CharacterController::class, 'getSingle']);
Route::post('/saveCharacter', [CharacterController::class, 'saveSingle']);
Route::post('/updateCharacter', [CharacterController::class, 'updateSingle']);
Route::post('/deleteCharacter', [CharacterController::class, 'deleteSingle']);

Route::get('/holi', function () {
  return view('welcome');
});

