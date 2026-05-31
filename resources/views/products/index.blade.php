@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-pink-700">
        Data Produk
    </h1>

    <a href="/products/create"
       class="bg-gradient-to-r from-pink-300 to-indigo-300 hover:from-pink-400 hover:to-indigo-400 text-white px-5 py-3 rounded-xl shadow-lg transition">
        Tambah Produk
    </a>

</div>

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-pink-100">

    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-gradient-to-r from-pink-200 via-pink-100 to-indigo-200 text-gray-700">

                <tr>

                    <th class="p-4 text-left w-16 font-bold">
                        No
                    </th>

                    <th class="p-4 text-left font-bold">
                        Cabang
                    </th>

                    <th class="p-4 text-left font-bold">
                        Kategori
                    </th>

                    <th class="p-4 text-left font-bold">
                        Nama Produk
                    </th>

                    <th class="p-4 text-left font-bold">
                        Harga
                    </th>

                    <th class="p-4 text-left font-bold">
                        Stock
                    </th>

                    <th class="p-4 text-left w-56 font-bold">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $product)

                <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-indigo-50 transition duration-300">

                    <td class="p-4 text-gray-700 font-medium">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 text-indigo-600 font-semibold">
                        {{ $product->branch->name }}
                    </td>

                    <td class="p-4 text-pink-600 font-semibold">
                        {{ $product->category->name }}
                    </td>

                    <td class="p-4 font-semibold text-gray-700">
                        {{ $product->name }}
                    </td>

                    <td class="p-4 text-green-600 font-bold">
                        Rp {{ number_format($product->price,0,',','.') }}
                    </td>

                    <td class="p-4">

                        <span class="bg-gradient-to-r from-pink-100 to-indigo-100 text-indigo-600 px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $product->stock }}
                        </span>

                    </td>

                    <td class="p-4">

                        <div class="flex gap-2">

                            <a href="/products/{{ $product->id }}/edit"
                               class="bg-gradient-to-r from-indigo-300 to-blue-300 hover:from-indigo-400 hover:to-blue-400 text-white px-4 py-2 rounded-xl shadow">

                                Edit

                            </a>

                            <form action="/products/{{ $product->id }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Yakin hapus produk?')"
                                    class="bg-gradient-to-r from-pink-300 to-rose-300 hover:from-pink-400 hover:to-rose-400 text-white px-4 py-2 rounded-xl shadow">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="7"
                        class="p-6 text-center text-pink-300 text-lg">

                        Belum ada produk

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection