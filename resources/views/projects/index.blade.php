<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Project</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-8 bg-gray-50">
    <h1 class="text-2xl font-bold mb-6">Daftar Semua Project</h1>

    <div class="grid gap-4">
        @foreach ($projects as $item)
            <div class="p-4 bg-white shadow rounded flex justify-between items-center">
                <div>
                    <h2 class="font-semibold text-lg">{{ $item->name }}</h2>
                    <p class="text-sm text-gray-500">Status: {{ $item->status }}</p>
                </div>
                <a href="{{ route('projects.show', $item->id) }}" class="text-blue-500 hover:underline">
                    Lihat Detail
                </a>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $projects->links() }} {{-- Untuk navigasi halaman (pagination) --}}
    </div>
</body>

</html>
