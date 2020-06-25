<?php

Route::resource('imoveis', 'ImovelController');
Route::get('/imoveis/remove/{id}', 'ImovelController@remove')->name('imoveis.remove');

