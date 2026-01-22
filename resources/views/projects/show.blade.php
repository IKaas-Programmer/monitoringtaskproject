<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail: {{ $project->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-8 bg-gray-50">
    <a href="{{ route('projects.index') }}" class="text-blue-500 underline text-sm">← Kembali ke Daftar</a>

    <h1 class="text-3xl font-bold mt-4">Project: {{ $project->name }}</h1>
    <p class="text-gray-600 mt-2">{{ $project->description }}</p>

    <hr class="my-8">

    <h2 class="text-xl font-bold mb-4">Daftar Tugas (Tasks)</h2>
    <ul class="space-y-2">
        @foreach ($project->tasks as $task)
            <li class="p-3 bg-white border rounded shadow-sm flex justify-between">
                <span>{{ $task->title }}</span>
                <span class="text-xs px-2 py-1 bg-gray-200 rounded">{{ $task->status }}</span>
            </li>
        @endforeach
    </ul>
</body>

</html>
