<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (! function_exists('generateToken'))
{
    function generateToken($table, $column = 'token', $length = 16): string
    {
        do {
            $token = Str::random($length);
        } while (DB::table($table)->where($column, '=', $token)->exists());

        return $token;
    }
}