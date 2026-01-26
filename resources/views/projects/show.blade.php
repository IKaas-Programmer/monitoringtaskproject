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
            <div class="flex items-center gap-4">
                <x-primary-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-task-modal')">
                    {{ __('+ Add Task') }}
                </x-primary-button>

                <form action="{{ route('projects.destroy', $project->id) }}" method="POST"
                    onsubmit="return confirm('PERINGATAN: Menghapus proyek ini akan menghapus semua tugas di dalamnya secara permanen. Lanjutkan?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-white border border-red-300 rounded-md font-semibold text-xs text-red-700 uppercase tracking-widest shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Delete Project
                    </button>
                </form>

                <div class="text-right">
                    <span
                        class="px-3 py-1 text-xs font-bold rounded-full uppercase {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                        Project Status: {{ $project->status }}
                    </span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Progress Section --}}
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

            {{-- Tasks List Section --}}
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

                            <div class="flex items-center gap-3">

                                {{-- 1. Form Update Status --}}
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
                                        <option value="completed"
                                            {{ $task->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </form>

                                {{-- 2. Buttons Edit --}}
                                <button type="button" x-data=""
                                    x-on:click.prevent="$dispatch('open-modal', 'edit-task-modal'); $dispatch('set-edit-task', {{ $task->toJson() }})"
                                    class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>

                                {{-- 2. Form Delete --}}
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus tugas ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-400 py-10">No tasks found for this project.</p>
                    @endforelse
                </div>
            </div>

            {{-- Modal Add Task --}}
            <x-modal name="add-task-modal" focusable>
                <form method="post" action="{{ route('tasks.store', $project->id) }}" class="p-6">
                    @csrf
                    <h2 class="text-lg font-medium text-gray-900 italic">Tambah Tugas Baru</h2>

                    <div class="mt-6 space-y-4">
                        <div>
                            <x-input-label for="title" value="Judul Tugas" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full"
                                required />
                        </div>
                        <div>
                            <x-input-label for="description" value="Deskripsi (Opsional)" />
                            <textarea name="description" id="description" rows="3"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="priority" value="Prioritas" />
                                <select name="priority" id="priority"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="due_date" value="Batas Waktu" />
                                <x-text-input id="due_date" name="due_date" type="date"
                                    class="mt-1 block w-full" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                        <x-primary-button class="ms-3">Simpan Task</x-primary-button>
                    </div>
                </form>
            </x-modal>

            {{-- Modal Edit Task --}}
            <x-modal name="edit-task-modal" focusable>
                <form method="post" x-data="{
                    id: '',
                    title: '',
                    description: '',
                    priority: '',
                    due_date: '',
                    action: ''
                }"
                    x-on:set-edit-task.window="
            id = $event.detail.id;
            title = $event.detail.title;
            description = $event.detail.description;
            priority = $event.detail.priority;
            due_date = $event.detail.due_date;
            action = '/tasks/' + id;
          "
                    :action="action" class="p-6">
                    @csrf
                    @method('PUT')

                    <h2 class="text-lg font-medium text-gray-900 italic">Edit Tugas</h2>

                    <div class="mt-6 space-y-4">
                        <div>
                            <x-input-label for="edit_title" value="Judul Tugas" />
                            <x-text-input id="edit_title" name="title" type="text" class="mt-1 block w-full"
                                x-model="title" required />
                        </div>
                        <div>
                            <x-input-label for="edit_description" value="Deskripsi" />
                            <textarea name="description" id="edit_description" rows="3" x-model="description"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="edit_priority" value="Prioritas" />
                                <select name="priority" id="edit_priority" x-model="priority"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="edit_due_date" value="Batas Waktu" />
                                <x-text-input id="edit_due_date" name="due_date" type="date"
                                    class="mt-1 block w-full" x-model="due_date" />
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                        <x-primary-button class="ms-3">Update Task</x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>
    </div>
</x-app-layout>
