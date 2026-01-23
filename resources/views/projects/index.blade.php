<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Semua Project') }}
            </h2>
            <a href="{{ route('projects.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 transition ease-in-out duration-150">
                + Tambah Proyek Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid gap-4">
                @forelse ($projects as $item)
                    <div
                        class="p-5 bg-white shadow-sm sm:rounded-lg flex justify-between items-center border border-gray-100 hover:shadow-md transition">
                        <div>
                            <h2 class="font-bold text-lg text-gray-800">{{ $item->name }}</h2>
                            <div class="flex items-center gap-2 mt-1">
                                <span
                                    class="px-2 py-0.5 text-[10px] font-bold rounded-full uppercase {{ $item->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $item->status }}
                                </span>
                                <p class="text-xs text-gray-400">Deadline:
                                    {{ \Carbon\Carbon::parse($item->deadline)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <a href="{{ route('projects.show', $item->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition shadow-sm">
                            Lihat Detail
                        </a>
                    </div>
                @empty
                    <div class="p-10 bg-white text-center rounded-lg shadow-sm border border-dashed border-gray-300">
                        <p class="text-gray-500">Belum ada proyek. Silakan buat proyek pertama Anda!</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $projects->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
