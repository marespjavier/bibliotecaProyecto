<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\ReadAllUsersRequest;
use App\Http\Requests\ShowUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(ReadAllUsersRequest $request){
        return User::all();
    }

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (!$user) {
            return response([
                'error' => true,
                'message' => "No se pudo crear el usuario",
            ], 500);
        }

        return response([
            'error' => false,
            'message' => "Usuario creado correctamente",
            'data' => $user
        ], 201);
    }
    public function verify(LoginUserRequest $request)
    {
        $autenticado = Auth::attempt([
            "email"=>$request->email,
            "password"=>$request->password,
        ]);

        if (!$autenticado) {
            return response([
                'error' => true,
                'message' => 'No se ha podido autenticar el usuario',
            ],401);
        }else{
            $user = Auth::user();
            $token= $user->createToken('auth-token')->plainTextToken;
            return response([
                'error' => false,
                'message' => "Usuario autenticado correctamente",
                'token' => $token,
                'token_type' => 'Bearer',
            ],201);
        }
    }
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->has('nombre')) $user->nombre = $request->nombre;
        if ($request->has('direccion')) $user->direccion = $request->direccion;
        if ($request->has('telefono')) $user->telefono = $request->telefono;
        if ($request->has('email')) $user->email = $request->email;

        // Si llega password, lo hasheamos
        if ($request->has('password') && $request->password !== null) {
            $user->password = Hash::make($request->password);
        }

        $ok = $user->save();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo actualizar el usuario',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Usuario actualizado correctamente',
            'data' => $user,
        ], 200);
    }
    public function destroy(DeleteUserRequest $request, User $user)
    {
        $ok = $user->delete();

        if (!$ok) {
            return response([
                'error' => true,
                'message' => 'No se pudo borrar el usuario',
            ], 500);
        }

        return response([
            'error' => false,
            'message' => 'Usuario borrado correctamente',
        ], 200);
    }
    public function logout()
    {
        $user = Auth::user();

        if (!$user) {
            return response([
                'error' => true,
                'message' => 'No autenticado',
            ], 401);
        }

        $user->tokens()->delete();

        return response([
            'error' => false,
            'mensaje' => 'Sesión cerrada correctamente',
        ], 200);
    }

    public function show(ShowUserRequest $request, User $user)
    {
        return response([
            'error' => false,
            'data' => $user
        ], 200);
    }

}

