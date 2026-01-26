<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function dashboard()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // 1. Ambil Statistik Utama
        $stats = [
            'total_projects' => $user->projects()->count('*'),
            'active_tasks' => Task::whereHas('project', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'in_progress')->count('*'),

            'overdue_projects' => $user->projects()
                ->where('status', '!=', 'completed')
                ->where('deadline', '<', now())
                ->count(),

            'completed_projects' => $user->projects()
                ->where('status', 'completed')
                ->count('*'),
        ];

        // 2. Ambil Proyek Terbaru (Filter berdasarkan user yang login)
        $recentProjects = $user->projects() // Menggunakan $user->projects() agar aman
            ->withCount([
                'tasks',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentProjects'));
    }

    public function index()
    {
        $projects = auth()->user()->projects() // Tambahkan auth()->user() di sini
            ->withCount([
                'tasks',
                'tasks as completed_tasks_count' => function ($query) {
                    $query->where('status', 'completed');
                }
            ])
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // Project berdasarkan ID, tapi harus milik user yang sedang login
        $project = auth()->user()->projects()
            ->with(['tasks.user', 'tasks.comments.user'])
            ->findOrFail($project->id); // Akan otomatis 404 jika data tidak ditemukan atau bukan milik user ini

        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->where('status', 'completed')->count();
        $progress = $totalTasks > 0 ? ($completedTasks / $totalTasks) * 100 : 0;

        return view('projects.show', compact('project', 'progress'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'required|date',
            'status' => 'required|in:planned,in_progress,completed',
        ]);

        // Hubungkan dengan user yang sedang login
        $request->user()->projects()->create($validated);

        return redirect()->route('projects.index')
            ->with('success', 'Proyek berhasil dibuat!');
    }

    public function destroy(Project $project)
    {
        // 1. Otorisasi: Pastikan user adalah pemilik proyek
        if ($project->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus proyek ini.');
        }

        // 2. Eksekusi Hapus
        // Jika di database Anda sudah set 'onDelete cascade', cukup panggil delete()
        $project->delete('id');

        return redirect()->route('projects.index')->with('success', 'Proyek berhasil dihapus permanen!');
    }
}