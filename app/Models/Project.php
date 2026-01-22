<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;


class Project extends Model
{
    /** @use HasFactory<\Database\Factories\ProjectFactory> */
    use HasFactory;

    // column yang dapat diisi massal
    protected $fillable = [
        'name',
        'description',
        'deadline',
        'status',
        'user_id',
    ];

    /**
     * Relasi ke User (Project Manager)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Task
     * 1 Project memiliki banyak Task
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Relasi ke Comments (Melalui Task)
     * Mengambil semua komentar di project ini melalui perantara tabel tasks
     */
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Task::class);
    }

    /**
     * Helper Function: Menghitung persentase progres project
     */
    public function getProgressAttribute()
    {
        $total = $this->tasks()->count();
        if ($total === 0)
            return 0;

        $completed = $this->tasks()->where('status', 'done')->count();
        return round(($completed / $total) * 100);
    }
}