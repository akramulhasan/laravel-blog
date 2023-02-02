<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExampleController extends Controller
{
    public function homepage(){
        $name = 'Akramul Hasan';
        $age = '33';
        $animals = ['Meo, Bark, Purrs'];
        return view('home', ['allanimals'=> $animals, 'name'=>$name, 'age'=> $age]);
    }

    public function aboutpage(){
        return '<h2>This is About page</h2>';
    }
}
