<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        

        $perfisEspeciais = ['Administrador', 'Secretaria', 'Membro Comissão', 'Presidente de Comissão', 'Vice Presidente de Comissão'];
        $usuarios = User::whereHas('roles', function($q) use ($perfisEspeciais){ 
                        return $q->whereIn('name', $perfisEspeciais);})->orderBy('users.name')->get()
                    ->merge(
                    User::whereDoesntHave('roles', function($q) use ($perfisEspeciais){ 
                        return $q->whereIn('name', $perfisEspeciais);})->orderBy('users.name')->get());

        $roles = Role::all();

        return view('users.index', compact('usuarios', 'roles'));
    }

    public function edit($id)
    {
    

        $usuario = User::find($id);
        $roles = Role::all();

        return view('users.edit', compact('usuario', 'roles'));
    }

    public function update(UserRequest $request, $id)
    {
    

        $validated = $request->validated();
        $usuario = User::find($id);
        $usuario->roles()->detach();
        $usuario->assignRole($validated['roles']);
        $usuario->update($validated);
        return redirect('/users');
        
    }
}
