<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    //
    public function index()
    {
        // Mengambil project beserta jumlah tasknya (Eager Loading)
        $projects = Project::withCount('tasks')
            ->with(['user'])
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        // Menampilkan detail project, semua task, dan komentarnya
        $project->load(['tasks.user', 'tasks.comments.user']);
        
        return view('projects.show', compact('project'));
    }
}