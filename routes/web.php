<?php

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

// Première route pour le cas ou l'on veut lire un fichier en particulier en GET
Route::get('read/{catchall?}', 'FileReader@readFile')->where(['catchall' => '.*']);

// Seconde route qui catch tout, de manière à récupérer le storage
Route::get('{catchall?}', 'FileReader@index')->where(['catchall' => '.*']);

/*
 * Dans un cas d'API rest il aurait été plus intéressant d'utiliser Route:resource, ici ce n'est pas indispensable
 *
 */