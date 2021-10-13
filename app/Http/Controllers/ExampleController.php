<?php

namespace App\Http\Controllers;

class ExampleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // function contoh
    public function generatekey(){
        return \Illuminate\Support\Str::random(32);
    }
    public function InputDataProject(){
        return 'contoh post request controoller';
    }

    //
}
