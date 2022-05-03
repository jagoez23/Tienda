<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::get();
    }

    public function store(Request $request)
    {
        $usuario = new User();
        $usuario -> create($request->all());
    }

    public function show(int $id): User
    {
        $usuario = User::find($id);
        return  $usuario;
    }

    public function update(Request $request, int $id): void
    {
        $usuario= User::find($id);
        $usuario-> update($request->all());
    }

    
    public function destroy(int $id): void
    {
        $usuario = User::find($id);
        $usuario -> delete();
    }
}
