<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    // Obtener todos los videos
    public function index()
    {
        // Obtiene todos los videos incluyendo la información del usuario, likes, dislikes y comentarios asociados
        $videos = Video::with(['user', 'likes', 'dislikes', 'comments'])->get();

        // Transforma cada video para agregar la URL completa del video y contar los likes y dislikes
        $videos->transform(function ($video) {
            if ($video->folderName) {
                $video->folderName = asset($video->folderName);
            }

            // Agregar el conteo de likes y dislikes
            $video->likes_count = $video->likes->count();
            $video->dislikes_count = $video->dislikes->count();

            // Remover la colección de likes y dislikes para mantener solo los conteos
            unset($video->likes);
            unset($video->dislikes);

            return $video;
        });

        // Retorna la lista de videos en formato JSON
        return response()->json($videos);
    }

    // Crear un nuevo video
    public function store(Request $request)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'video' => 'required|file|mimes:mp4,mov,ogg,qt|max:20000', // Asegurarse de que sea un video válido
        ]);

        // Si la validación falla, retorna un error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Procesar el archivo de video
        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            $videoPath = $videoFile->store('public/videos');
            $videoUrl = Storage::url($videoPath);
        }

        // Crear el nuevo video
        $video = Video::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => $request->user_id,
            'folderName' => $videoUrl,
        ]);

        // Retornar una respuesta exitosa con los datos del video creado
        return response()->json($video, 201);
    }

    // Obtener un video específico por ID
    public function show($id)
    {
        $video = Video::with(['user', 'likes', 'dislikes', 'comments'])->find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        // Agregar la URL completa del video al objeto de video
        if ($video->folderName) {
            $video->folderName = asset($video->folderName);
        }

        // Agregar el conteo de likes y dislikes
        $video->likes_count = $video->likes->count();
        $video->dislikes_count = $video->dislikes->count();

        // Remover la colección de likes y dislikes para mantener solo los conteos
        unset($video->likes);
        unset($video->dislikes);

        return response()->json($video);
    }

    // Actualizar un video específico por ID
    public function update(Request $request, $id)
    {
        // Validación de los datos de entrada
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,ogg,qt|max:20000', // Asegurarse de que sea un video válido si se proporciona uno nuevo
        ]);

        // Si la validación falla, retorna un error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $video = Video::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        // Procesar el archivo de video si se proporciona uno nuevo
        if ($request->hasFile('video')) {
            // Eliminar el video anterior si existe
            if ($video->folderName) {
                Storage::delete(str_replace('/storage', 'public', $video->folderName));
            }
            $videoFile = $request->file('video');
            $videoPath = $videoFile->store('public/videos');
            $videoUrl = Storage::url($videoPath);
        } else {
            $videoUrl = $video->folderName;
        }

        // Actualizar el video
        $video->update([
            'name' => $request->name,
            'description' => $request->description,
            'folderName' => $videoUrl,
        ]);

        return response()->json($video);
    }

    // Eliminar un video específico por ID
    public function destroy($id)
    {
        $video = Video::find($id);

        if (!$video) {
            return response()->json(['message' => 'Video not found'], 404);
        }

        // Eliminar el video del almacenamiento si existe
        if ($video->folderName) {
            Storage::delete(str_replace('/storage', 'public', $video->folderName));
        }

        $video->delete();

        return response()->json(['message' => 'Video deleted successfully']);
    }
}
