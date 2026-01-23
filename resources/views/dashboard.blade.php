<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project & Task Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-blue-50 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Total Projects</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $stats['total_projects'] }}</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-yellow-50 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">In Progress Tasks</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $stats['active_tasks'] }}</h4>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-lg">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 font-medium">Overdue Projects</p>
                        <h4 class="text-2xl font-bold text-gray-800">{{ $stats['overdue_projects'] }}</h4>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm border border-gray-100 sm:rounded-xl">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 text-lg italic">Active Projects Progress</h3>
                    <a href="{{ route('projects.index') }}"
                        class="text-blue-600 text-sm font-semibold hover:underline">View All Projects &rarr;</a>
                </div>
                <div class="overflow-x-auto p-6">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-400 text-sm uppercase tracking-wider">
                                <th class="pb-4 px-2 font-medium">Project Name</th>
                                <th class="pb-4 px-2 font-medium">Visual Progress</th>
                                <th class="pb-4 px-2 font-medium">Status</th>
                                <th class="pb-4 px-2 font-medium text-right">Details</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($recentProjects as $project)
                                @php
                                    $percent =
                                        $project->tasks_count > 0
                                            ? ($project->completed_tasks_count / $project->tasks_count) * 100
                                            : 0;
                                @endphp
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="py-4 px-2">
                                        <div class="font-semibold text-gray-800">{{ $project->name }}</div>
                                        <div class="text-xs text-gray-400">Due:
                                            {{ $project->deadline->format('d M Y') }}</div>
                                    </td>
                                    <td class="py-4 px-2 w-1/3">
                                        <div class="flex items-center gap-3">
                                            <div class="flex-1 bg-gray-100 rounded-full h-2">
                                                <div class="bg-blue-600 h-2 rounded-full transition-all duration-500"
                                                    style="width: {{ $percent }}%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600">{{ round($percent) }}%</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-2">
                                        <span
                                            class="px-3 py-1 text-[10px] font-black rounded-full uppercase tracking-tighter {{ $project->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-right">
                                        <a href="{{ route('projects.show', $project->id) }}"
                                            class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-md transition">
                                            Open
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
