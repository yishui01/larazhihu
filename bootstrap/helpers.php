<?php

function route_class()
{
    return str_replace('.', '-', \Illuminate\Support\Facades\Route::currentRouteName());
}


function active_class($condition)
{
    return $condition ? 'active' : '';
}
