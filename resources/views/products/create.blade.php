@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-pink-700">
    Tambah Produk
</h1>

<form action="/products" method="POST"
      class="bg-gradient-to-br from-pink-50 via-blue-50 to-pink-100
             p-8 rounded-3xl shadow-2xl border border-pink-200 space-y-5">

    @csrf

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Cabang
        </label>

        <select name="branch_id"
                class="w-full border-2 border-pink-200 bg-white/80
                       p-3 rounded-2xl
                       focus:outline-none
                       focus:ring-4 focus:ring-pink-200
                       focus:border-blue-300
                       transition">

            @foreach($branches as $branch)

                <option value="{{ $branch->id }}">
                    {{ $branch->name }}
                </option>

            @endforeach

        </select>

    </div>

    <div>

        <label class="block mb-2 font-semibold text-blue-700">
            Kategori
        </label>

        <select name="category_id"
                class="w-full border-2 border-blue-200 bg-white/80
                       p-3 rounded-2xl
                       focus:outline-none
                       focus:ring-4 focus:ring-blue-200
                       focus:border-pink-300
                       transition">

            @foreach($categories as $category)

                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>

            @endforeach

        </select>

    </div>

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Nama Produk
        </label>

        <input type="text"
               name="name"
               placeholder="Nama Produk"
               class="w-full border-2 border-pink-200 bg-white/80
                      p-3 rounded-2xl
                      focus:outline-none
                      focus:ring-4 focus:ring-pink-200
                      focus:border-blue-300
                      transition">

    </div>

    <div>

        <label class="block mb-2 font-semibold text-blue-700">
            Harga
        </label>

        <input type="number"
               name="price"
               placeholder="Harga"
               class="w-full border-2 border-blue-200 bg-white/80
                      p-3 rounded-2xl
                      focus:outline-none
                      focus:ring-4 focus:ring-blue-200
                      focus:border-pink-300
                      transition">

    </div>

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Stock
        </label>

        <input type="number"
               name="stock"
               placeholder="Stock"
               class="w-full border-2 border-pink-200 bg-white/80
                      p-3 rounded-2xl
                      focus:outline-none
                      focus:ring-4 focus:ring-pink-200
                      focus:border-blue-300
                      transition">

    </div>

    <button
        class="bg-gradient-to-r from-pink-400 to-blue-400
               hover:from-pink-500 hover:to-blue-500
               text-white font-semibold
               px-6 py-3 rounded-2xl shadow-lg transition">

        Simpan

    </button>

</form>

@endsection