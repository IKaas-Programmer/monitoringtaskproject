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

    // Simpan Task Baru ke dalam Project tertentu
    public function store(Request $request, Project $project)
    {
        // 1. Validasi Input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'nullable|date|after_or_equal:today',
        ]);

        // 2. Simpan ke Database melalui relasi project
        $project->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'status' => 'todo', // Default tugas baru
            'user_id' => auth()->id(), // Mencatat pembuat tugas
            'due_date' => $validated['due_date'] ?? null, // Batas waktu jika ada
        ]);

        // 3. Update status project menjadi in_progress jika sebelumnya 'planned'
        if ($project->status === 'planned') {
            $project->update(['status' => 'in_progress']);
        }

        return redirect()->back()->with('success', 'Tugas baru berhasil ditambahkan!');
    }

    public function destroy(Task $task)
    {
        // Keamanan: Cek apakah task ini berada di bawah project milik user
        if ($task->project->user_id !== auth()->id()) {
            abort(403, 'Tindak akses tidak diizinkan.');
        }

        $task->delete();
        return back()->with('success', 'Tugas berhasil dihapus!');
    }
}