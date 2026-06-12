@extends('layouts.app')

@section('content')
<div class="mb-5">
    <p class="text-sm font-semibold uppercase tracking-wide text-teal-700">Mata Kuliah</p>
    <h2 class="text-2xl font-bold">Edit Mata Kuliah</h2>
</div>
<form class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm" method="POST" action="{{ route('admin.mata-kuliahs.update', $mataKuliah) }}">
    @method('PUT')
    @include('admin.mata-kuliahs._form')
</form>
@endsection
