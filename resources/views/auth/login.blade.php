@extends('layouts.app')

@section('content')
<main class="grid min-h-screen place-items-center px-4 py-10">
    <section class="w-full max-w-md rounded-lg border border-slate-200 bg-white p-8 shadow-sm">
        <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">FT UNSUR</p>
        <h1 class="mt-2 text-2xl font-bold">Login Sistem KRS</h1>
        <p class="mt-2 text-sm text-slate-600">Gunakan akun demo admin atau mahasiswa dari seeder.</p>

        <div class="mt-5 rounded-md bg-slate-100 p-3 text-sm text-slate-700">
            <p><strong>Admin:</strong> admin@ftunsur.test / password</p>
            <p><strong>Mahasiswa:</strong> nabil@ftunsur.test / password</p>
        </div>

        <form class="mt-6 space-y-4" method="POST" action="{{ route('login.store') }}">
            @csrf
            <div>
                <label class="text-sm font-medium" for="email">Email</label>
                <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-teal-600 focus:outline-none" id="email" name="email" type="email" value="{{ old('email') }}" required autofocus>
                @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="text-sm font-medium" for="password">Password</label>
                <input class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-teal-600 focus:outline-none" id="password" name="password" type="password" required>
                @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input class="rounded border-slate-300" name="remember" type="checkbox" value="1">
                Ingat saya
            </label>
            <button class="w-full rounded-md bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800" type="submit">Masuk</button>
        </form>
    </section>
</main>
@endsection
