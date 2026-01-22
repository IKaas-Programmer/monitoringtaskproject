<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    // mengubah status task dan check otomatis status project
    public function updateStatus(Request $request, Task $task)
    {
        // Validasi input agar status tidak diisi sembarang teks
        $validated = $request->validate([
            'status' => 'required|in:todo,on_progress,completed'
        ]);

        // Menggunakan fill & save seringkali menghilangkan peringatan "too many arguments"
        $task->status = $validated['status'];
        $task->completed_at = ($validated['status'] === 'completed') ? now() : null;
        $task->save();

        // LOGIKA OTOMATIS: Update status project
        $project = $task->project;

        // Gunakan exists() untuk efisiensi jika hanya ingin cek ada tidaknya task
        $hasUnfinishedTasks = $project->tasks()->where('status', '!=', 'completed')->exists();

        if (!$hasUnfinishedTasks) {
            $project->update(['status' => 'completed']);
        } else {
            $project->update(['status' => 'on_progress']);
        }

        return back()->with('success', 'Status tugas diperbarui!');
    }
}