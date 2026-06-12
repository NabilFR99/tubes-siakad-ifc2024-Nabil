@extends('layouts.app')

@section('content')
<div class="mb-5">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Mahasiswa</p>
    <h2 class="text-2xl font-bold">Edit Mahasiswa</h2>
</div>
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" action="{{ route('admin.mahasiswas.update', $mahasiswa) }}">
    @method('PUT')
    @include('admin.mahasiswas._form')
</form>
@endsection
