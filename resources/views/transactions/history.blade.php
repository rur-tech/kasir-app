@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-pink-700">
                History Transaksi
            </h1>

            <p class="text-gray-500 mt-1">
                Daftar seluruh transaksi kasir parfum
            </p>

        </div>

        {{-- BUTTON --}}
        <div class="flex flex-wrap gap-3">

            <a href="/transactions"
               class="bg-gradient-to-r from-pink-300 to-indigo-300 hover:from-pink-400 hover:to-indigo-400 text-white px-5 py-3 rounded-2xl shadow-lg transition">

                ← Kembali

            </a>

        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-2xl shadow">

            {{ session('success') }}

        </div>

    @endif

    {{-- CARD --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-pink-100 overflow-hidden">

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full border-collapse">

                {{-- HEAD --}}
                <thead class="bg-gradient-to-r from-pink-200 via-pink-100 to-indigo-200 text-gray-700">

                    <tr>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            No
                        </th>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            Kasir
                        </th>

                        <th class="p-4 text-left font-bold">
                            Produk
                        </th>

                        <th class="p-4 text-left font-bold">
                            Bundling
                        </th>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            Cabang
                        </th>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            Pembayaran
                        </th>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            Total
                        </th>

                        <th class="p-4 text-left font-bold whitespace-nowrap">
                            Tanggal
                        </th>

                        <th class="p-4 text-center font-bold whitespace-nowrap">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($transactions as $trx)

                    <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-indigo-50 transition duration-300">

                        {{-- NO --}}
                        <td class="p-4 align-top text-gray-700 font-medium">

                            {{ $transactions->firstItem() + $loop->index }}

                        </td>

                        {{-- KASIR --}}
                        <td class="p-4 align-top">

                            <div class="flex items-center gap-2">

                                <div class="w-10 h-10 rounded-xl bg-pink-100 flex items-center justify-center text-pink-700 font-bold">

                                    👤

                                </div>

                                <div>

                                    <div class="font-bold text-pink-700">

                                        {{ $trx->user->name ?? auth()->user()->name ?? 'Admin' }}

                                    </div>

                                </div>

                            </div>

                        </td>

                        {{-- PRODUK --}}
                        <td class="p-4 align-top min-w-[220px]">

                            @php
                                $produkAda = false;
                            @endphp

                            @foreach($trx->details as $detail)

                                @if(empty($detail->bundle_name))

                                    @php
                                        $produkAda = true;
                                    @endphp

                                    <div class="mb-2 bg-pink-50 border border-pink-100 rounded-2xl px-4 py-3">

                                        <div class="font-semibold text-pink-700">

                                            🧴 {{ $detail->product->name ?? '-' }}

                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">

                                            Qty :
                                            {{ $detail->qty }}

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                            @if(!$produkAda)

                                <span class="text-gray-400 italic">

                                    Tidak ada produk

                                </span>

                            @endif

                        </td>

                        {{-- BUNDLING --}}
                        <td class="p-4 align-top min-w-[220px]">

                            @php
                                $bundleAda = false;
                            @endphp

                            @foreach($trx->details as $detail)

                                @if(!empty($detail->bundle_name))

                                    @php
                                        $bundleAda = true;
                                    @endphp

                                    <div class="mb-2 bg-indigo-50 border border-indigo-100 rounded-2xl px-4 py-3">

                                        <div class="font-semibold text-indigo-700">

                                            🎁 {{ $detail->bundle_name }}

                                        </div>

                                        <div class="text-sm text-gray-500 mt-1">

                                            Qty :
                                            {{ $detail->qty }}

                                        </div>

                                        <div class="text-sm text-gray-400">

                                            Bundle Produk

                                        </div>

                                    </div>

                                @endif

                            @endforeach

                            @if(!$bundleAda)

                                <span class="text-gray-400 italic">

                                    Tidak ada bundling

                                </span>

                            @endif

                        </td>

                        {{-- CABANG --}}
                        <td class="p-4 align-top">

                            <span class="inline-flex items-center bg-pink-100 text-pink-700 px-4 py-2 rounded-xl font-semibold whitespace-nowrap">

                                {{ $trx->branch->name ?? '-' }}

                            </span>

                        </td>

                        {{-- PEMBAYARAN --}}
                        <td class="p-4 align-top">

                            <span class="inline-flex items-center bg-indigo-100 text-indigo-700 px-4 py-2 rounded-xl font-semibold whitespace-nowrap">

                                {{ $trx->paymentMethod->name ?? '-' }}

                            </span>

                        </td>

                        {{-- TOTAL --}}
                        <td class="p-4 align-top whitespace-nowrap">

                            <div class="font-bold text-green-600 text-lg">

                                Rp {{ number_format($trx->grand_total ?? 0,0,',','.') }}

                            </div>

                            <div class="text-sm text-rose-500 mt-1">

                                Diskon :
                                Rp {{ number_format($trx->discount_total ?? 0,0,',','.') }}

                            </div>

                        </td>

                        {{-- TANGGAL --}}
                        <td class="p-4 align-top text-gray-600 whitespace-nowrap">

                            <div>

                                {{ $trx->created_at->format('d M Y') }}

                            </div>

                            <div class="text-sm text-gray-400 mt-1">

                                {{ $trx->created_at->format('H:i') }}

                            </div>

                        </td>

                        {{-- AKSI --}}
                        <td class="p-4 align-top">

                            <div class="flex flex-wrap justify-center gap-2">

                                {{-- DETAIL --}}
                                <a href="{{ route('transactions.show', $trx->id) }}"
                                   class="bg-indigo-400 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl shadow transition">

                                    Detail

                                </a>

                                {{-- STRUK --}}
                                <a href="{{ route('transactions.struk', $trx->id) }}"
                                   target="_blank"
                                   class="bg-pink-400 hover:bg-pink-500 text-white px-4 py-2 rounded-xl shadow transition">

                                    Struk

                                </a>

                                {{-- WHATSAPP --}}
                                <a href="{{ route('transactions.whatsapp', $trx->id) }}"
                                   target="_blank"
                                   class="bg-indigo-400 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl shadow transition">

                                    WA

                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="9"
                            class="p-10 text-center text-pink-300 text-lg font-semibold">

                            Belum ada transaksi

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINATION --}}
        <div class="p-5 border-t border-pink-100">

            {{ $transactions->links() }}

        </div>

    </div>

</div>

@endsection