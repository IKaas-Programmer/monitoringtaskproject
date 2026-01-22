<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;

    protected $fillable = ['task_id', 'user_id', 'body', 'attachment'];
    protected static function booted() 
    {
        static::addGlobalScope('latest', function ($builder){
            $builder->latest();
        });
    }
    /**
     * Mengambil data user pemilik komentar
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mengambil data task tempat komentar ini berada
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}