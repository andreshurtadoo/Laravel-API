<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Video;
use App\Models\User;

class LikeController extends Controller
{
    public function store(Request $request, $video_id, $user_id)
    {
        $video = Video::findOrFail($video_id);
        $user = User::findOrFail($user_id);

        // Verificar si el usuario ya dio dislike y eliminarlo si existe
        $user->dislikes()->where('video_id', $video_id)->delete();

        // Crear un nuevo like
        $like = $user->likes()->create([
            'video_id' => $video->id,
        ]);

        return response()->json($like, 201);;
    }
}
