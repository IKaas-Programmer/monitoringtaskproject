<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;

class ProjectController extends Controller
{
    public function dashboard()
    {
        // 1. Ambil Statistik Utama
        $stats = [
            'total_projects' => Project::count(),
            'active_tasks' => Task::where('status', 'in_progress')->count(),
            'overdue_projects' => Project::where('status', '!=', 'completed')
                ->where('deadline', '<', now())
                ->count(),
        ];

        // 2. Ambil Proyek Terbaru dengan hitungan task untuk progress bar
        $recentProjects = Project::withCount([
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
        $projects = Project::withCount([
            'tasks',
            'tasks as completed_tasks_count' => function ($query) {
                $query->where('status', 'completed');
            }
        ])
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        $project->load(['tasks.user', 'tasks.comments.user']);

        // Menghitung progress untuk ditampilkan di detail
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
}