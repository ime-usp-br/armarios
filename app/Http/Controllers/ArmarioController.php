<?php

namespace App\Http\Controllers;
use App\Models\Armario;

use Illuminate\Http\Request;

class ArmarioController extends Controller
{
    public function index(){
        $armarios = Armario::all();
        return view('armarios.index',[
            'armarios' => $armarios
        ]);
    }
    public function show(Armario $armario){
        
        return view('armarios.show',[
            'armario' => $armario,

        ]);


    }
}
