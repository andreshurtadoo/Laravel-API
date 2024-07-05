<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id', 'folderName'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
