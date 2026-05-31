@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold text-pink-700 mb-6">
    Tambah Bundling
</h1>

@if ($errors->any())

    <div class="mb-5 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-2xl">

        <ul class="list-disc pl-5 space-y-1">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="{{ route('bundles.store') }}"
      method="POST"
      class="bg-gradient-to-br from-pink-50 via-blue-50 to-sky-100 p-8 rounded-3xl shadow-2xl border border-pink-100 space-y-5">

    @csrf

    {{-- NAMA BUNDLING --}}
    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Nama Bundling
        </label>

        <input type="text"
               name="name"
               value="{{ old('name') }}"
               required
               class="w-full border border-pink-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-pink-400 focus:outline-none"
               placeholder="Contoh Paket Hemat">

    </div>

    {{-- NAMA PRODUK MANUAL --}}
    <div>

        <label class="block mb-2 font-semibold text-indigo-700">
            Nama Produk
        </label>

        <input type="text"
               name="product_name"
               value="{{ old('product_name') }}"
               required
               class="w-full border border-indigo-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-indigo-400 focus:outline-none"
               placeholder="Contoh Parfum A + Parfum B">

    </div>

    {{-- HARGA BUNDLE --}}
    <div>

        <label class="block mb-2 font-semibold text-sky-700">
            Harga Bundle
        </label>

        <input type="number"
               name="bundle_price"
               value="{{ old('bundle_price') }}"
               required
               class="w-full border border-sky-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-sky-400 focus:outline-none"
               placeholder="100000">

    </div>

    {{-- STOCK --}}
    <div>

        <label class="block mb-2 font-semibold text-emerald-700">
            Stock Bundle
        </label>

        <input type="number"
               name="stock"
               value="{{ old('stock') }}"
               required
               class="w-full border border-emerald-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-emerald-400 focus:outline-none"
               placeholder="10">

    </div>

    {{-- DESKRIPSI --}}
    <div>

        <label class="block mb-2 font-semibold text-orange-700">
            Deskripsi
        </label>

        <textarea
            name="description"
            rows="4"
            class="w-full border border-orange-200 bg-white p-3 rounded-2xl focus:ring-2 focus:ring-orange-400 focus:outline-none"
            placeholder="Isi deskripsi bundle">{{ old('description') }}</textarea>

    </div>

    {{-- BUTTON --}}
    <div class="pt-3 flex gap-3">

        <button type="submit"
            class="bg-gradient-to-r from-pink-400 to-sky-400 hover:from-pink-500 hover:to-sky-500 text-white px-6 py-3 rounded-2xl shadow-lg transition duration-300">

            Simpan

        </button>

        <a href="/bundles"
           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-3 rounded-2xl shadow transition duration-300">

            Kembali

        </a>

    </div>

</form>

@endsection