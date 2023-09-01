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
        if (auth()->check()) {
            // Verifique se o usuário tem a role "Admin" OU "Secretaria".
            if (!auth()->user()->hasRole(['Admin', 'Secretaria'])) {
                abort(403);
            }
        }
    
        // Se o usuário não estiver autenticado ou não tiver as roles, redirecione-o para uma página de erro 403 (acesso proibido) ou execute outra ação apropriada.
        

        $perfisEspeciais = ['Administrador', 'Secretaria'];
        $usuarios = User::whereHas('roles', function($q) use ($perfisEspeciais){ 
                        return $q->whereIn('name', $perfisEspeciais);})->orderBy('users.name')->get()
                    ->merge(
                    User::whereDoesntHave('roles', function($q) use ($perfisEspeciais){ 
                        return $q->whereIn('name', $perfisEspeciais);})->orderBy('users.name')->get());

        $roles = Role::all();
        $usuarios = $usuarios->sort(function($a,$b){
            if($a->hasRole('Admin') and !$b->hasRole('Admin')){
                return 1;

            }elseif(!$a->hasRole('Admin') and $b->hasRole('Admin')){
                return -1;

            }
            if($a->hasRole('Secretaria') and !$b->hasRole('Secretaria')){
                return 1;

            }elseif(!$a->hasRole('Secretaria') and $b->hasRole('Secretaria')){
                return -1;
            }
        })->reverse();

        

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
