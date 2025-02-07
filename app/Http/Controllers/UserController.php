<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $userId = $request->user()->id;
        $user = User::query()->find($userId);
        $data = $request->validated();
        if (isset($data['current_password'], $data['new_password'])) {
            if (!Hash::check($data['current_password'], $user->password)) {
                return response()->json(['message' => 'Current password is incorrect'], 400);
            }

            $data['password'] = Hash::make($data['new_password']);
        }

        $user->update($data);
        return response()->json($user);
    }
}
