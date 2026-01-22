<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;

    // column yang dapat diisi massal
    protected $fillable = [
        'project_id',
        'user_id',
        'title',
        'description',
        'priority',
        'status',
        'due_date',
        'completed_at',
    ];

    // Relasi ke Project: Task ini milik satu Project
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Relasi ke User: mengetahui siapa yang ditugaskan pada Task ini
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Comments: Satu task bisa memiliki banyak komentar diskusi
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

}