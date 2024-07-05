<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dislike;
use App\Models\Video;
use App\Models\User;

class DislikeController extends Controller
{
    public function store(Request $request, $video_id, $user_id)
    {
        $video = Video::findOrFail($video_id);
        $user = User::findOrFail($user_id);

        // Verificar si el usuario ya dio like y eliminarlo si existe
        $user->likes()->where('video_id', $video_id)->delete();

        // Crear un nuevo dislike
        $dislike = $user->dislikes()->create([
            'video_id' => $video->id,
        ]);

        return response()->json($dislike, 201);
    }
}
