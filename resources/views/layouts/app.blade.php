<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'KRS FT UNSUR' }}</title>
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    @auth
        <div class="min-h-screen lg:flex">
            <aside class="border-b border-slate-200 bg-white lg:fixed lg:inset-y-0 lg:w-72 lg:border-b-0 lg:border-r">
                <div class="flex h-full flex-col">
                    <div class="border-b border-slate-200 px-6 py-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-teal-700">FT UNSUR</p>
                        <h1 class="mt-1 text-xl font-bold">Sistem KRS</h1>
                    </div>
                    <nav class="flex-1 space-y-1 px-4 py-5 text-sm font-medium">
                        <a class="block rounded-md px-3 py-2 {{ request()->routeIs('dashboard') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        @if(auth()->user()->isAdmin())
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.dosens.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.dosens.index') }}">Dosen</a>
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.mahasiswas.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.mahasiswas.index') }}">Mahasiswa</a>
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.mata-kuliahs.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.mata-kuliahs.index') }}">Mata Kuliah</a>
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.jadwal-kuliahs.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.jadwal-kuliahs.index') }}">Jadwal</a>
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('admin.krs.*') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('admin.krs.index') }}">Data KRS</a>
                        @else
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('krs.index') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('krs.index') }}">Input KRS</a>
                            <a class="block rounded-md px-3 py-2 {{ request()->routeIs('krs.schedule') ? 'bg-slate-900 text-white' : 'text-slate-700 hover:bg-slate-100' }}" href="{{ route('krs.schedule') }}">Jadwal Saya</a>
                        @endif
                    </nav>
                    <div class="border-t border-slate-200 p-4">
                        <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>
                        <p class="mb-3 text-xs uppercase text-slate-500">{{ auth()->user()->role }}</p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm font-semibold hover:bg-slate-100" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="w-full lg:pl-72">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    @if(session('success'))
                        <div class="mb-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    @else
        @yield('content')
    @endauth
</body>
</html>
