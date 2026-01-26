<x-guest-layout>
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Project Manager Pro</h1>
            <p class="text-gray-600">Kelola tugas dan proyek Anda dengan lebih efisien.</p>
        </div>

        <div class="w-full max-w-sm bg-white shadow-md rounded-lg p-6">
            @if (Route::has('login'))
                <div class="space-y-4">
                    @auth
                        {{-- Jika User Sudah Login --}}
                        <a href="{{ url('/dashboard') }}"
                            class="flex justify-center w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                            Lanjut ke Dashboard
                        </a>
                    @else
                        {{-- Tombol Utama --}}
                        <a href="{{ route('login') }}"
                            class="flex justify-center w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition font-semibold">
                            Masuk (Login)
                        </a>

                        @if (Route::has('register'))
                            <div class="relative flex py-3 items-center">
                                <div class="flex-grow border-t border-gray-300"></div>
                                <span class="flex-shrink mx-4 text-gray-400 text-sm">atau</span>
                                <div class="flex-grow border-t border-gray-300"></div>
                            </div>

                            <a href="{{ route('register') }}"
                                class="flex justify-center w-full px-4 py-2 border border-indigo-600 text-indigo-600 rounded-md hover:bg-indigo-50 transition font-semibold">
                                Daftar Akun Baru
                            </a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>

        <p class="mt-8 text-xs text-gray-400">© 2026 Monitoring Task Project</p>
    </div>
</x-guest-layout>
