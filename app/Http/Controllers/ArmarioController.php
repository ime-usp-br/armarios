<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArmarioRequest;
use App\Http\Requests\UpdateArmarioRequest;
use App\Models\Armario;

class ArmarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $armarios = Armario::all();
        return view('armarios.index',[
            'armarios' => $armarios
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArmarioRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArmarioRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function show(Armario $armario)
    {
        return view('armarios.show',[
            'armario' => $armario,

        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function edit(Armario $armario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArmarioRequest  $request
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArmarioRequest $request, Armario $armario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Armario  $armario
     * @return \Illuminate\Http\Response
     */
    public function destroy(Armario $armario)
    {
        //
    }
}
