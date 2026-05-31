@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-pink-700 mb-6">
    Tambah Cabang
</h1>

<form action="/branches" method="POST"
      class="bg-gradient-to-br from-pink-50 via-blue-50 to-sky-100 p-8 rounded-3xl shadow-2xl border border-pink-100 space-y-5">

    @csrf

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Nama Cabang
        </label>

        <input type="text"
               name="name"
               placeholder="Masukkan nama cabang"
               class="w-full border border-pink-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-pink-400 focus:outline-none">

    </div>

    <button
        class="bg-gradient-to-r from-pink-400 to-sky-400 hover:from-pink-500 hover:to-sky-500 text-white px-6 py-3 rounded-2xl shadow-lg transition duration-300">

        Simpan

    </button>

</form>

@endsection