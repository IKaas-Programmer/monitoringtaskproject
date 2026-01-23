<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <a href="{{ route('projects.index') }}"
                    class="text-xs text-blue-600 hover:underline flex items-center gap-1 mb-1">
                    ← Back to Projects
                </a>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $project->name }}
                </h2>
            </div>
            <div class="text-right">
                <span
                    class="px-3 py-1 text-xs font-bold rounded-full uppercase {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                    Project Status: {{ $project->status }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <h3 class="text-sm font-bold text-gray-400 uppercase mb-2">Description</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $project->description }}</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <h3 class="text-sm font-bold text-gray-400 uppercase mb-3 text-center">Completion Progress</h3>
                        <div class="flex items-center gap-4">
                            <div class="flex-1 bg-gray-200 rounded-full h-4 overflow-hidden">
                                <div class="bg-blue-600 h-full transition-all duration-700"
                                    style="width: {{ $progress }}%"></div>
                            </div>
                            <span class="font-bold text-blue-700">{{ round($progress) }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                    Project Tasks
                </h3>

                <div class="space-y-3">
                    @forelse ($project->tasks as $task)
                        <div
                            class="flex flex-col md:flex-row md:items-center justify-between p-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition">
                            <div class="mb-3 md:mb-0">
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-gray-800">{{ $task->title }}</span>
                                    <span
                                        class="text-[10px] px-2 py-0.5 rounded font-black uppercase {{ $task->priority === 'high' ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $task->priority }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-500">{{ $task->description }}</p>
                            </div>

                            <div class="flex items-center gap-4">
                                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()"
                                        class="text-xs rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 {{ $task->status === 'completed' ? 'bg-green-50 text-green-700 font-bold' : '' }}">
                                        <option value="todo" {{ $task->status === 'todo' ? 'selected' : '' }}>To Do
                                        </option>
                                        <option value="in_progress"
                                            {{ $task->status === 'in_progress' ? 'selected' : '' }}>In Progress
                                        </option>
                                        <option value="review" {{ $task->status === 'review' ? 'selected' : '' }}>
                                            Review</option>
                                        <option value="completed"
                                            {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-10">No tasks found for this project.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
