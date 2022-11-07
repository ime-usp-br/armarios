<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class armariocontroller extends Controller
{
    public function index(){
        return view('armarios.index');
    }
    public function show($id){
        if ($id == '789')
            $armario = 'Armário do Mickael';
        else
            $armario = 'Armário não identificado';
        return view('armarios.show',[
            'armario' => $armario,

        ]);

    }
}
