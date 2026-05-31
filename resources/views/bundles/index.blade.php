@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">

        <h1 class="text-3xl font-bold text-pink-700">
            Data Bundling
        </h1>

        <a href="/bundles/create"
           class="bg-gradient-to-r from-pink-300 to-indigo-300 hover:from-pink-400 hover:to-indigo-400 text-white px-5 py-3 rounded-xl shadow-lg transition">

            Tambah Bundling

        </a>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow">

            {{ session('success') }}

        </div>

    @endif

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-pink-100">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                {{-- HEAD --}}
                <thead class="bg-gradient-to-r from-pink-200 via-pink-100 to-indigo-200 text-gray-700">

                    <tr>

                        <th class="p-4 text-left w-20 font-bold">
                            No
                        </th>

                        <th class="p-4 text-left font-bold">
                            Nama Bundling
                        </th>

                        <th class="p-4 text-left font-bold">
                            Nama Produk
                        </th>

                        <th class="p-4 text-left font-bold">
                            Harga Bundle
                        </th>

                        <th class="p-4 text-left font-bold">
                            Stock
                        </th>

                        <th class="p-4 text-left font-bold">
                            Deskripsi
                        </th>

                        <th class="p-4 text-center w-56 font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($bundles as $bundle)

                    <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-indigo-50 transition duration-300">

                        {{-- NO --}}
                        <td class="p-4 text-gray-700 align-top">

                            {{ $loop->iteration }}

                        </td>

                        {{-- NAMA BUNDLE --}}
                        <td class="p-4 align-top">

                            <div class="font-bold text-pink-700 text-lg">

                                🎁 {{ $bundle->name }}

                            </div>

                        </td>

                        {{-- NAMA PRODUK --}}
                        <td class="p-4 align-top">

                            <div class="bg-pink-50 border border-pink-100 rounded-xl px-3 py-2 text-sm text-gray-700">

                                🧴 {{ $bundle->product_name }}

                            </div>

                        </td>

                        {{-- HARGA --}}
                        <td class="p-4 text-indigo-600 font-bold align-top">

                            Rp {{ number_format($bundle->bundle_price,0,',','.') }}

                        </td>

                        {{-- STOCK --}}
                        <td class="p-4 align-top">

                            <div class="inline-flex items-center bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl font-semibold">

                                {{ $bundle->stock }}

                            </div>

                        </td>

                        {{-- DESKRIPSI --}}
                        <td class="p-4 text-gray-600 align-top">

                            {{ $bundle->description ?? '-' }}

                        </td>

                        {{-- AKSI --}}
                        <td class="p-4 align-top">

                            <div class="flex justify-center gap-2 flex-wrap">

                                {{-- EDIT --}}
                                <a href="/bundles/{{ $bundle->id }}/edit"
                                   class="bg-gradient-to-r from-indigo-300 to-blue-300 hover:from-indigo-400 hover:to-blue-400 text-white px-4 py-2 rounded-xl shadow transition">

                                    Edit

                                </a>

                                {{-- DELETE --}}
                                <form action="/bundles/{{ $bundle->id }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        onclick="return confirm('Yakin hapus bundling?')"
                                        class="bg-gradient-to-r from-pink-300 to-rose-300 hover:from-pink-400 hover:to-rose-400 text-white px-4 py-2 rounded-xl shadow transition">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="p-10 text-center text-pink-300 text-lg">

                            Belum ada data bundling

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection