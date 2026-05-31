@extends('layouts.app')

@section('content')

@php

    /*
    |--------------------------------------------------------------------------
    | NAMA KASIR DARI AKUN LOGIN
    |--------------------------------------------------------------------------
    */
    $kasir =
        $transaction->user->name
        ?? auth()->user()->name
        ?? 'Admin';

@endphp

<div class="max-w-5xl mx-auto">

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-pink-100 overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-pink-300 via-pink-200 to-indigo-300 p-8">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5">

                <div>

                    <h1 class="text-3xl font-bold text-gray-800">
                        Detail Transaksi
                    </h1>

                    <p class="mt-2 text-pink-700 font-semibold text-lg">
                        {{ $transaction->created_at->format('d M Y H:i') }}
                    </p>

                </div>

                {{-- KASIR LOGIN --}}
                <div class="bg-white/70 backdrop-blur px-5 py-3 rounded-2xl shadow">

                    <div class="text-sm text-gray-500">
                        Nama Kasir
                    </div>

                    <div class="font-bold text-pink-700 text-lg">
                        {{ $kasir }}
                    </div>

                </div>

            </div>

        </div>

        {{-- CONTENT --}}
        <div class="p-6 md:p-8">

            {{-- INFO --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

                {{-- INFO TRANSAKSI --}}
                <div class="bg-pink-50 border border-pink-100 rounded-3xl p-6 shadow-sm">

                    <h2 class="text-lg font-bold text-pink-700 mb-4">
                        Informasi Transaksi
                    </h2>

                    <div class="space-y-4">

                        <div class="flex justify-between gap-4">

                            <span class="text-gray-500">
                                Cabang
                            </span>

                            <span class="font-semibold text-gray-700 text-right">
                                {{ $transaction->branch->name ?? '-' }}
                            </span>

                        </div>

                        <div class="flex justify-between gap-4">

                            <span class="text-gray-500">
                                Pembayaran
                            </span>

                            <span class="font-semibold text-indigo-700 text-right">
                                {{ $transaction->paymentMethod->name ?? '-' }}
                            </span>

                        </div>

                        <div class="flex justify-between gap-4">

                            <span class="text-gray-500">
                                Tanggal
                            </span>

                            <span class="font-semibold text-gray-700 text-right">
                                {{ $transaction->created_at->format('d M Y H:i') }}
                            </span>

                        </div>

                    </div>

                </div>

                {{-- INFO KASIR --}}
                <div class="bg-indigo-50 border border-indigo-100 rounded-3xl p-6 shadow-sm">

                    <h2 class="text-lg font-bold text-indigo-700 mb-4">
                        Informasi Kasir
                    </h2>

                    <div class="space-y-4">

                        <div class="flex justify-between gap-4">

                            <span class="text-gray-500">
                                Nama Kasir
                            </span>

                            <span class="font-semibold text-pink-700 text-right">
                                {{ $kasir }}
                            </span>

                        </div>

                        <div class="flex justify-between gap-4">

                            <span class="text-gray-500">
                                Total Item
                            </span>

                            <span class="font-semibold text-gray-700 text-right">
                                {{ $transaction->details->count() }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- TABLE --}}
            <div class="overflow-x-auto rounded-3xl border border-pink-100 shadow-lg">

                <table class="w-full border-collapse">

                    {{-- HEAD --}}
                    <thead class="bg-gradient-to-r from-pink-200 via-pink-100 to-indigo-200 text-gray-700">

                        <tr>

                            <th class="p-4 text-left font-bold">
                                Produk
                            </th>

                            <th class="p-4 text-left font-bold">
                                Bundle
                            </th>

                            <th class="p-4 text-left font-bold">
                                Harga
                            </th>

                            <th class="p-4 text-center font-bold">
                                Qty
                            </th>

                            <th class="p-4 text-right font-bold">
                                Subtotal
                            </th>

                        </tr>

                    </thead>

                    {{-- BODY --}}
                    <tbody>

                        @forelse($transaction->details as $item)

                        <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-indigo-50 transition">

                            {{-- PRODUK --}}
                            <td class="p-4">

                                @if(!empty($item->bundle_name))

                                    <div class="font-semibold text-indigo-700">
                                        🎁 {{ $item->bundle_name }}
                                    </div>

                                @else

                                    <div class="font-semibold text-pink-700">
                                        🧴 {{ $item->product->name ?? '-' }}
                                    </div>

                                @endif

                            </td>

                            {{-- BUNDLE --}}
                            <td class="p-4">

                                @if(!empty($item->bundle_name))

                                    <span class="inline-flex items-center bg-indigo-100 text-indigo-700 px-3 py-1 rounded-xl text-sm font-semibold">

                                        Bundle

                                    </span>

                                @else

                                    <span class="text-gray-400 italic">
                                        -
                                    </span>

                                @endif

                            </td>

                            {{-- HARGA --}}
                            <td class="p-4 text-gray-700 font-medium">

                                Rp {{ number_format($item->price,0,',','.') }}

                            </td>

                            {{-- QTY --}}
                            <td class="p-4 text-center">

                                <span class="inline-flex items-center justify-center min-w-[40px] bg-pink-100 text-pink-700 px-3 py-1 rounded-xl font-bold">

                                    {{ $item->qty }}

                                </span>

                            </td>

                            {{-- SUBTOTAL --}}
                            <td class="p-4 text-right font-bold text-green-600">

                                Rp {{ number_format($item->subtotal,0,',','.') }}

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="p-8 text-center text-pink-300 font-semibold">

                                Tidak ada detail transaksi

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- TOTAL --}}
            <div class="mt-8 flex justify-end">

                <div class="w-full md:w-[420px] bg-gradient-to-br from-pink-50 to-indigo-50 border border-pink-100 rounded-3xl p-6 shadow-lg">

                    <h2 class="text-xl font-bold text-pink-700 mb-5">
                        Ringkasan Pembayaran
                    </h2>

                    <div class="space-y-4">

                        {{-- SUBTOTAL --}}
                        <div class="flex justify-between text-gray-700">

                            <span>
                                Subtotal
                            </span>

                            <span class="font-semibold">

                                Rp {{ number_format($transaction->subtotal ?? 0,0,',','.') }}

                            </span>

                        </div>

                        {{-- DISKON --}}
                        <div class="flex justify-between text-rose-500 font-semibold">

                            <span>
                                Diskon
                            </span>

                            <span>

                                - Rp {{ number_format($transaction->discount_total ?? 0,0,',','.') }}

                            </span>

                        </div>

                        {{-- GRAND TOTAL --}}
                        <div class="flex justify-between border-t border-pink-100 pt-4 text-2xl font-bold text-green-600">

                            <span>
                                Grand Total
                            </span>

                            <span>

                                Rp {{ number_format($transaction->grand_total ?? 0,0,',','.') }}

                            </span>

                        </div>

                        {{-- BAYAR --}}
                        <div class="flex justify-between text-gray-700">

                            <span>
                                Bayar
                            </span>

                            <span class="font-semibold">

                                Rp {{ number_format($transaction->cash ?? 0,0,',','.') }}

                            </span>

                        </div>

                        {{-- KEMBALIAN --}}
                        <div class="flex justify-between text-indigo-700 font-bold text-lg">

                            <span>
                                Kembalian
                            </span>

                            <span>

                                Rp {{ number_format($transaction->change ?? 0,0,',','.') }}

                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="mt-8 flex flex-wrap gap-3">

                {{-- KEMBALI --}}
                <a href="/transactions/history"
                   class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-2xl shadow-lg transition">

                    Kembali

                </a>

                {{-- STRUK --}}
                <a href="{{ route('transactions.struk', $transaction->id) }}"
                   target="_blank"
                   class="bg-pink-400 hover:bg-pink-500 text-white px-6 py-3 rounded-2xl shadow-lg transition">

                    Cetak Struk

                </a>

                {{-- WHATSAPP --}}
                <a href="{{ route('transactions.whatsapp', $transaction->id) }}"
                   target="_blank"
                   class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-3 rounded-2xl shadow-lg transition">

                    Kirim WhatsApp

                </a>

            </div>

        </div>

    </div>

</div>

@endsection