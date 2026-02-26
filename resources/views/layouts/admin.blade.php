<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <div class="flex min-h-screen">

        <!-- SIDEBAR -->
        <aside class="w-64 bg-indigo-700 text-white hidden md:block">
            <div class="p-6 text-xl font-bold border-b border-indigo-600">
                7 Kebiasaan Anak
            </div>

            <nav class="mt-6 space-y-1 px-4">

                <a href="/admin/dashboard" class="block px-4 py-2 rounded hover:bg-indigo-600">
                    Dashboard
                </a>

                <a href="/admin/guru" class="block px-4 py-2 rounded hover:bg-indigo-600">
                    Guru
                </a>

                <a href="/admin/orangtua" class="block px-4 py-2 rounded hover:bg-indigo-600">
                    Orang Tua
                </a>

                <a href="/admin/kelas" class="block px-4 py-2 rounded hover:bg-indigo-600">
                    Kelas
                </a>

                <a href="/admin/siswa" class="block px-4 py-2 rounded hover:bg-indigo-600">
                    Siswa
                </a>

                <a href="{{ route('password.edit') }}"
                    class="block px-4 py-2 rounded hover:bg-indigo-600">
                    🔒 Ubah Password
                </a>

            </nav>
        </aside>

        <!-- CONTENT -->
        <div class="flex-1 flex flex-col">

            <!-- TOPBAR -->
            <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold">
                    Admin Dashboard
                </h1>

                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name }}
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600 text-sm hover:underline">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- MAIN -->
            <main class="p-6">
                @yield('content')
            </main>

        </div>

    </div>

</body>

</html>
