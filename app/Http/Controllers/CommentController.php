<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Video;
use App\Models\User;

class CommentController extends Controller
{
    public function store(Request $request, $video_id, $user_id)
    {
        $video = Video::findOrFail($video_id);

        // Verificar si el usuario existe, asumiendo que tienes la relación definida
        $user = User::findOrFail($user_id);

        $comment = new Comment();
        $comment->comment = $request->input('comment'); // Utilizamos 'comment' es el campo del comentario
        $comment->user_id = $user->id;

        $video->comments()->save($comment);

        return response()->json($comment, 201);
    }
}
