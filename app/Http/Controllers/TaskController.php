<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    /**
     * Mengubah status task dan check otomatis status project
     */
    public function updateStatus(Request $request, Task $task)
    {
        // 1. Validasi agar data yang masuk sesuai dengan ENUM di Database
        $request->validate([
            'status' => 'required|in:todo,in_progress,review,completed'
        ]);

        // 2. Update status Task
        $task->update([
            'status' => $request->status,
            'completed_at' => $request->status === 'completed' ? now() : null
        ]);

        // 3. LOGIKA OTOMATIS: Cek status Project-nya
        $project = $task->project;

        // Ambil jumlah task yang BELUM completed
        $pendingTasksCount = $project->tasks()->where('status', '!=', 'completed')->count();

        if ($pendingTasksCount === 0) {
            // Jika semua task sudah 'completed', set project jadi 'completed'
            $project->update(['status' => 'completed']);
        } else {
            // Jika masih ada yang pending, set project jadi 'in_progress'
            $project->update(['status' => 'in_progress']);
        }

        return back()->with('success', 'Status tugas dan progres proyek diperbarui!');
    }
}