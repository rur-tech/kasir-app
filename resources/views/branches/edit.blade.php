@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-pink-700">
    Edit Cabang
</h1>

<form action="/branches/{{ $branch->id }}"
      method="POST"
      class="bg-white p-8 rounded-3xl shadow-2xl border border-pink-100 space-y-5">

    @csrf
    @method('PUT')

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Nama Cabang
        </label>

        <input type="text"
               name="name"
               value="{{ $branch->name }}"
               class="w-full border border-pink-200 bg-pink-50
                      p-3 rounded-2xl
                      focus:outline-none
                      focus:ring-4 focus:ring-pink-200
                      focus:border-indigo-300
                      transition">

    </div>

    <button
        class="bg-gradient-to-r from-pink-300 to-indigo-300
               hover:from-pink-400 hover:to-indigo-400
               text-white font-semibold
               px-6 py-3 rounded-2xl shadow-lg transition">

        Update

    </button>

</form>

@endsection