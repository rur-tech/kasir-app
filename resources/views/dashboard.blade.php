@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- TOP BAR --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

        {{-- LEFT --}}
        <div class="flex items-center gap-4">

            <div class="w-16 h-16 rounded-3xl bg-gradient-to-r from-pink-200 via-blue-100 to-indigo-200 flex items-center justify-center text-3xl shadow-xl">
                🧴
            </div>

            <div>

                <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-500 to-indigo-500 bg-clip-text text-transparent">
                Kasir Parfum Juragan Wangi
                </h1>

                <p class="text-gray-500 mt-1">

                    Welcome,

                    <span class="font-semibold text-indigo-600">

                        {{ auth()->user()->name }}

                    </span>

                </p>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="bg-gradient-to-r from-pink-50 to-blue-50 px-6 py-4 rounded-3xl shadow-xl border border-pink-100">

            <div class="text-sm text-gray-500">
                Tanggal Hari Ini
            </div>

            <div class="font-bold text-indigo-600 text-lg">

                {{ now()->format('d M Y') }}

            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- HARI INI --}}
        <div class="rounded-3xl p-7 text-white shadow-2xl bg-gradient-to-r from-pink-300 via-pink-200 to-blue-300">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm opacity-90">
                        Penjualan Hari Ini
                    </div>

                    <div class="text-3xl font-bold mt-4">

                        Rp {{ number_format($todayIncome ?? 0,0,',','.') }}

                    </div>

                </div>

                <div class="text-5xl opacity-30">
                    💰
                </div>

            </div>

        </div>

        {{-- BULAN --}}
        <div class="rounded-3xl p-7 text-white shadow-2xl bg-gradient-to-r from-indigo-300 via-blue-300 to-sky-300">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm opacity-90">
                        Penjualan Bulan Ini
                    </div>

                    <div class="text-3xl font-bold mt-4">

                        Rp {{ number_format($monthIncome ?? 0,0,',','.') }}

                    </div>

                </div>

                <div class="text-5xl opacity-30">
                    📈
                </div>

            </div>

        </div>

        {{-- TAHUN --}}
        <div class="rounded-3xl p-7 text-white shadow-2xl bg-gradient-to-r from-pink-400 via-fuchsia-300 to-indigo-300">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm opacity-90">
                        Penjualan Tahun Ini
                    </div>

                    <div class="text-3xl font-bold mt-4">

                        Rp {{ number_format($yearIncome ?? 0,0,',','.') }}

                    </div>

                </div>

                <div class="text-5xl opacity-30">
                    🧾
                </div>

            </div>

        </div>

        {{-- TOTAL --}}
        <div class="rounded-3xl p-7 text-white shadow-2xl bg-gradient-to-r from-pink-300 via-indigo-300 to-blue-400">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm opacity-90">
                        Seluruh Penjualan
                    </div>

                    <div class="text-3xl font-bold mt-4">

                        Rp {{ number_format($allIncome ?? 0,0,',','.') }}

                    </div>

                </div>

                <div class="text-5xl opacity-30">
                    🛍️
                </div>

            </div>

        </div>

    </div>

    {{-- CARD INFO --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- TRANSAKSI --}}
        <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-3xl p-7 shadow-xl border border-pink-100">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm text-gray-500">
                        Total Transaksi
                    </div>

                    <div class="text-4xl font-bold text-pink-600 mt-3">

                        {{ $totalTransactions ?? 0 }}

                    </div>

                </div>

                <div class="text-4xl">
                    🧾
                </div>

            </div>

        </div>

        {{-- PRODUK --}}
        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-3xl p-7 shadow-xl border border-indigo-100">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm text-gray-500">
                        Total Produk
                    </div>

                    <div class="text-4xl font-bold text-indigo-600 mt-3">

                        {{ $totalProducts ?? 0 }}

                    </div>

                </div>

                <div class="text-4xl">
                    🧴
                </div>

            </div>

        </div>

        {{-- STOK --}}
        <div class="bg-gradient-to-br from-pink-50 to-rose-100 rounded-3xl p-7 shadow-xl border border-pink-100">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm text-gray-500">
                        Total Stok
                    </div>

                    <div class="text-4xl font-bold text-pink-500 mt-3">

                        {{ $totalStock ?? 0 }}

                    </div>

                </div>

                <div class="text-4xl">
                    📦
                </div>

            </div>

        </div>

        {{-- CABANG --}}
        <div class="bg-gradient-to-br from-indigo-50 to-blue-100 rounded-3xl p-7 shadow-xl border border-indigo-100">

            <div class="flex items-center justify-between">

                <div>

                    <div class="text-sm text-gray-500">
                        Total Cabang
                    </div>

                    <div class="text-4xl font-bold text-blue-600 mt-3">

                        {{ $totalBranches ?? 0 }}

                    </div>

                </div>

                <div class="text-4xl">
                    🏬
                </div>

            </div>

        </div>

    </div>

    {{-- TRANSAKSI TERBARU --}}
    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-pink-100">

        {{-- HEADER --}}
        <div class="p-6 border-b border-pink-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gradient-to-r from-pink-100 via-blue-50 to-indigo-100">

            <div>

                <h2 class="text-2xl font-bold text-indigo-700">
                    Transaksi Terbaru
                </h2>

                <p class="text-gray-500 text-sm mt-1">
                    Riwayat transaksi terbaru kasir parfum
                </p>

            </div>

            <a href="{{ route('transactions.history') }}"
               class="bg-gradient-to-r from-pink-300 to-indigo-300 hover:from-pink-400 hover:to-indigo-400 text-white px-5 py-3 rounded-2xl shadow-lg transition">

                Lihat Semua

            </a>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                {{-- HEAD --}}
                <thead class="bg-gradient-to-r from-pink-100 via-blue-100 to-indigo-100 text-gray-700">

                    <tr>

                        <th class="p-4 text-left font-bold">
                            Nama Kasir
                        </th>

                        <th class="p-4 text-left font-bold">
                            Cabang
                        </th>

                        <th class="p-4 text-left font-bold">
                            Total
                        </th>

                        <th class="p-4 text-left font-bold">
                            Pembayaran
                        </th>

                        <th class="p-4 text-left font-bold">
                            Tanggal
                        </th>

                        <th class="p-4 text-center font-bold">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($transactions as $trx)

                    @php
                        $kasir =
                            $trx->user->name
                            ?? auth()->user()->name
                            ?? 'Kasir';
                    @endphp

                    <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-blue-50 transition duration-300">

                        {{-- KASIR --}}
                        <td class="p-4">

                            <div class="flex items-center gap-3">

                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-pink-200 to-indigo-200 flex items-center justify-center text-pink-700 font-bold shadow">

                                    {{ strtoupper(substr($kasir,0,1)) }}

                                </div>

                                <div>

                                    <div class="font-semibold text-pink-700">

                                        {{ $kasir }}

                                    </div>

                                </div>

                            </div>

                        </td>

                        {{-- CABANG --}}
                        <td class="p-4 text-indigo-600 font-semibold">

                            {{ $trx->branch->name ?? '-' }}

                        </td>

                        {{-- TOTAL --}}
                        <td class="p-4">

                            <div class="font-bold text-emerald-600 text-lg">

                                Rp {{ number_format($trx->grand_total ?? 0,0,',','.') }}

                            </div>

                            <div class="text-xs text-gray-400 mt-1">

                                Diskon :
                                Rp {{ number_format($trx->discount_total ?? 0,0,',','.') }}

                            </div>

                        </td>

                        {{-- PAYMENT --}}
                        <td class="p-4">

                            <span class="bg-gradient-to-r from-pink-100 to-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">

                                {{ $trx->paymentMethod->name ?? '-' }}

                            </span>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="p-4 text-gray-600">

                            <div>

                                {{ $trx->created_at->format('d M Y') }}

                            </div>

                            <div class="text-sm text-gray-400 mt-1">

                                {{ $trx->created_at->format('H:i') }}

                            </div>

                        </td>

                        {{-- AKSI --}}
                        <td class="p-4">

                            <div class="flex gap-2 justify-center">

                                {{-- DETAIL --}}
                                <a href="{{ route('transactions.show', $trx->id) }}"
                                   class="bg-gradient-to-r from-indigo-300 to-blue-300 hover:from-indigo-400 hover:to-blue-400 text-white px-4 py-2 rounded-xl shadow">

                                    Detail

                                </a>

                                {{-- STRUK --}}
                                <a href="{{ route('transactions.struk', $trx->id) }}"
                                   target="_blank"
                                   class="bg-gradient-to-r from-pink-300 to-rose-300 hover:from-pink-400 hover:to-rose-400 text-white px-4 py-2 rounded-xl shadow">

                                    Struk

                                </a>

                                {{-- WHATSAPP --}}
                                <a href="{{ route('transactions.whatsapp', $trx->id) }}"
                                   target="_blank"
                                   class="bg-gradient-to-r from-emerald-300 to-green-300 hover:from-emerald-400 hover:to-green-400 text-white px-4 py-2 rounded-xl shadow">

                                    WhatsApp

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="6"
                            class="p-10 text-center text-pink-300 text-lg">

                            Belum ada transaksi

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection