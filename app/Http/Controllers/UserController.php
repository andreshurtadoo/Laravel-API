<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all()->where('status', '=', 0), 200);
    }

    public function store(Request $request): JsonResponse
    {
        $user = User::create($request->all());
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        $user->update($request->all());
        return response()->json([
            'success' => true,
            'data' => $user
        ], 201);
    }

    public function destroy($id): JsonResponse
    {
        $user = User::find($id);

        if ($user) {
            // Cambiar el valor del campo 'status'
            $user->status = $user->status === 0 ? 1 : 0;
            $user->save();
            return response()->json([
                'success' => true
            ], 201);
        }

        return response()->json([
            'success' => false
        ], 404);
    }
}
