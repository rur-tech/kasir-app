@extends('layouts.app')

@section('content')

<div class="flex justify-between items-center mb-6">

    <h1 class="text-3xl font-bold text-pink-700">
        Metode Pembayaran
    </h1>

    <a href="{{ route('payment-methods.create') }}"
       class="bg-gradient-to-r from-pink-300 to-indigo-300 hover:from-pink-400 hover:to-indigo-400 text-white px-5 py-3 rounded-xl shadow-lg transition">

        Tambah Metode

    </a>

</div>

<div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-pink-100">

    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead class="bg-gradient-to-r from-pink-200 via-pink-100 to-indigo-200 text-gray-700">

                <tr>

                    <th class="p-4 text-left w-20 font-bold">
                        No
                    </th>

                    <th class="p-4 text-left font-bold">
                        Nama Metode
                    </th>

                    <th class="p-4 text-left w-56 font-bold">
                        Aksi
                    </th>

                </tr>

            </thead>

            <tbody>

                @forelse($paymentMethods as $item)

                <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-indigo-50 transition duration-300">

                    <td class="p-4 text-gray-700 font-medium">
                        {{ $loop->iteration }}
                    </td>

                    <td class="p-4 font-semibold text-pink-700">
                        {{ $item->name }}
                    </td>

                    <td class="p-4">

                        <div class="flex gap-2">

                            <a href="{{ route('payment-methods.edit', $item->id) }}"
                               class="bg-gradient-to-r from-indigo-300 to-blue-300 hover:from-indigo-400 hover:to-blue-400 text-white px-4 py-2 rounded-xl shadow">

                                Edit

                            </a>

                            <form action="{{ route('payment-methods.destroy', $item->id) }}"
                                  method="POST">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Yakin hapus data?')"
                                    class="bg-gradient-to-r from-pink-300 to-rose-300 hover:from-pink-400 hover:to-rose-400 text-white px-4 py-2 rounded-xl shadow">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="3"
                        class="p-6 text-center text-pink-300 text-lg">

                        Belum ada metode pembayaran

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection