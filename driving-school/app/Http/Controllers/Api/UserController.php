<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController
{
    /**
     * Todos os utilizadores
     */
    public function index()
    {
        $users = User::all();

        if ($users->isEmpty()) {
            return response()->json([
                'error' => 404,
                'message' => 'Users not found.'
            ], 404);
        }

        return response()->json($users);
    }

    /**
     * Cria um utilizador
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        return response()->json($user, 201);
    }

    /**
     * Detalhes de um utilizador
     */
    public function show(int $user)
    {
        $user = User::find($user);

        if (!$user) {
            return response()->json([
                'error' => 404,
                'message' => 'User not found.'
            ], 404);
        }

        return response()->json($user);
    }

    /**
     * Atualiza um utilizador
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return response()->json($user);
    }

    /**
     * Ativa/desativa um utilizador
     */
    public function destroy(User $user)
    {
        $user->update([
            'active' => !$user->active
        ]);

        return response()->json([
            'message' => $user->active
                ? 'User activated successfully.'
                : 'User deactivated successfully.',
            'data' => $user
        ], 200);
    }
}
