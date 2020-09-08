<?php

if (! function_exists('vnd_format')) {
    function vnd_format($price, $quantity= 1, $multiply = 1000)
    {
        return number_format(($price * $quantity * $multiply), 0, ',', '.');
    }
}

if (! function_exists('view403')) {
    function view403()
    {
        return view('admin_def.pages.403');
    }
}