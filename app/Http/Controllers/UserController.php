<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(User::all()->where('status', '=', 0), 200);
    }

    public function store(Request $request): JsonResponse
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'cedula' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'photo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|integer|min:0|max:1',
            'rol' => 'nullable|integer|min:0|max:1',
        ]);

        // Si la validación falla, retorna un error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Procesar la imagen si se proporciona
        $photoUrl = null;
        if ($request->hasFile('photo_url')) {
            $photo = $request->file('photo_url');
            $photoPath = $photo->store('public/photos');
            $photoUrl = Storage::url($photoPath);
        }

        // Crear el nuevo usuario
        $user = User::create([
            'cedula' => $request->cedula,
            'name' => $request->name,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'telephone' => $request->telephone,
            'state' => $request->state,
            'city' => $request->city,
            'photo_url' => $photoUrl,
            'status' => $request->status ?? 0,
            'rol' => $request->rol ?? 0,
            'password' => Hash::make($request->password),
        ]);

        // Retornar una respuesta exitosa con los datos del usuario creado
        return response()->json($user, 201);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        return response()->json($user, 200);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        // Almacena la photo en el storage
        $request->file('photo')->storeAs('public', $request->photo);
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
