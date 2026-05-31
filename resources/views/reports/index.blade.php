@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-pink-500">
                Laporan Transaksi
            </h1>

            <p class="text-blue-300 mt-1">
                Data seluruh transaksi kasir parfum
            </p>

        </div>

        <div class="flex flex-wrap gap-3">

            {{-- EXPORT EXCEL --}}
            <a href="{{ route('reports.excel') }}"
               class="bg-gradient-to-r from-pink-300 via-pink-200 to-blue-300 hover:from-pink-400 hover:via-pink-300 hover:to-blue-400 text-white px-5 py-3 rounded-2xl shadow-lg transition duration-300 font-semibold">

                Export Excel

            </a>

        </div>

    </div>

    {{-- ALERT SUCCESS --}}
    @if(session('success'))

        <div class="bg-pink-100 border border-pink-200 text-pink-600 px-5 py-4 rounded-2xl shadow">

            {{ session('success') }}

        </div>

    @endif

    {{-- CARD TABLE --}}
    <div class="bg-gradient-to-br from-pink-50 via-blue-50 to-pink-100 rounded-3xl shadow-2xl overflow-hidden border border-pink-100">

        <div class="overflow-x-auto">

            <table class="w-full border-collapse min-w-[1200px]">

                {{-- HEAD --}}
                <thead class="bg-gradient-to-r from-pink-300 via-pink-200 to-blue-300 text-white">

                    <tr>

                        <th class="p-4 text-left font-bold">No</th>
                        <th class="p-4 text-left font-bold">Tanggal</th>
                        <th class="p-4 text-left font-bold">Nama Kasir</th>
                        <th class="p-4 text-left font-bold">Cabang</th>

                        <th class="p-4 text-left font-bold w-[260px]">
                            Produk
                        </th>

                        <th class="p-4 text-left font-bold w-[220px]">
                            Bundling
                        </th>

                        <th class="p-4 text-left font-bold">Kategori</th>
                        <th class="p-4 text-left font-bold">Pembayaran</th>
                        <th class="p-4 text-left font-bold">Diskon</th>
                        <th class="p-4 text-left font-bold">Bayar</th>
                        <th class="p-4 text-left font-bold">Kembalian</th>
                        <th class="p-4 text-left font-bold">Total</th>
                        <th class="p-4 text-center font-bold">Aksi</th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($transactions as $transaction)

                    @php
                        $kasir =
                            $transaction->user->name
                            ?? auth()->user()->name
                            ?? 'Kasir';
                    @endphp

                    <tr class="border-b border-pink-100 hover:bg-gradient-to-r hover:from-pink-50 hover:to-blue-50 transition duration-300">

                        {{-- NO --}}
                        <td class="p-4 align-top font-bold text-pink-500">
                            {{ $loop->iteration }}
                        </td>

                        {{-- TANGGAL --}}
                        <td class="p-4 align-top text-gray-600">
                            {{ $transaction->created_at->format('d M Y') }}
                            <br>
                            <span class="text-sm text-blue-300">
                                {{ $transaction->created_at->format('H:i') }}
                            </span>
                        </td>

                        {{-- KASIR --}}
                        <td class="p-4 align-top">
                            <div class="font-bold text-pink-500">
                                👤 {{ $kasir }}
                            </div>
                        </td>

                        {{-- CABANG --}}
                        <td class="p-4 align-top">
                            <span class="inline-flex items-center bg-pink-100 text-pink-500 px-4 py-2 rounded-xl font-semibold">
                                {{ $transaction->branch->name ?? '-' }}
                            </span>
                        </td>

                        {{-- PRODUK (FIX) --}}
                        <td class="p-4 align-top">
                            <div class="max-h-40 overflow-y-auto pr-2 space-y-2">

                                @php $produkAda = false; @endphp

                                @foreach($transaction->details as $detail)

                                    @if(empty($detail->bundle_name))

                                        @php $produkAda = true; @endphp

                                        <div class="bg-white border border-pink-100 rounded-2xl px-3 py-2 shadow-sm min-w-[200px]">

                                            <div class="font-medium text-pink-500 break-words">
                                                🧴 {{ $detail->product->name ?? '-' }}
                                            </div>

                                            <div class="text-sm text-gray-500 mt-1">
                                                Qty : {{ $detail->qty }}
                                            </div>

                                            <div class="text-sm text-blue-400 font-semibold mt-1">
                                                Rp {{ number_format($detail->subtotal,0,',','.') }}
                                            </div>

                                        </div>

                                    @endif

                                @endforeach

                                @if(!$produkAda)
                                    <span class="text-gray-400 italic">Tidak ada produk</span>
                                @endif

                            </div>
                        </td>

                        {{-- BUNDLING (FIX) --}}
                        <td class="p-4 align-top">
                            <div class="max-h-40 overflow-y-auto pr-2 space-y-2">

                                @php $bundleAda = false; @endphp

                                @foreach($transaction->details as $detail)

                                    @if(!empty($detail->bundle_name))

                                        @php $bundleAda = true; @endphp

                                        <div class="bg-blue-50 border border-blue-100 rounded-2xl px-3 py-2 min-w-[180px]">

                                            <div class="font-semibold text-blue-500 break-words">
                                                🎁 {{ $detail->bundle_name }}
                                            </div>

                                            <div class="text-sm text-gray-500 mt-1">
                                                Qty : {{ $detail->qty }}
                                            </div>

                                        </div>

                                    @endif

                                @endforeach

                                @if(!$bundleAda)
                                    <span class="text-gray-400 italic">Tidak ada bundling</span>
                                @endif

                            </div>
                        </td>

                        {{-- KATEGORI --}}
                        <td class="p-4 align-top">
                            @php $kategoriDitampilkan = []; @endphp

                            @foreach($transaction->details as $detail)

                                @php $kategori = $detail->product->category->name ?? null; @endphp

                                @if($kategori && !in_array($kategori, $kategoriDitampilkan))

                                    @php $kategoriDitampilkan[] = $kategori; @endphp

                                    <div class="mb-2 bg-pink-50 border border-pink-100 rounded-2xl px-3 py-2 text-pink-500 font-medium">
                                        {{ $kategori }}
                                    </div>

                                @endif

                            @endforeach

                            @if(count($kategoriDitampilkan) == 0)
                                <span class="text-gray-400 italic">Tidak ada kategori</span>
                            @endif
                        </td>

                        {{-- PEMBAYARAN --}}
                        <td class="p-4 align-top">
                            <span class="inline-flex items-center bg-blue-100 text-blue-500 px-4 py-2 rounded-xl font-semibold">
                                {{ $transaction->paymentMethod->name ?? '-' }}
                            </span>
                        </td>

                        {{-- DISKON --}}
                        <td class="p-4 align-top text-pink-400 font-bold">
                            Rp {{ number_format($transaction->discount_total ?? 0,0,',','.') }}
                        </td>

                        {{-- BAYAR --}}
                        <td class="p-4 align-top text-blue-500 font-bold">
                            Rp {{ number_format($transaction->cash ?? 0,0,',','.') }}
                        </td>

                        {{-- KEMBALIAN --}}
                        <td class="p-4 align-top text-indigo-400 font-bold">
                            Rp {{ number_format($transaction->change ?? 0,0,',','.') }}
                        </td>

                        {{-- TOTAL --}}
                        <td class="p-4 align-top text-pink-500 font-bold text-lg">
                            Rp {{ number_format($transaction->grand_total ?? 0,0,',','.') }}
                        </td>

                        {{-- AKSI --}}
                        <td class="p-4 align-top">

                            <div class="flex flex-col gap-2">

                                <a href="{{ route('transactions.show', $transaction->id) }}"
                                   class="bg-gradient-to-r from-blue-300 to-blue-400 hover:from-blue-400 hover:to-blue-500 text-white px-4 py-2 rounded-xl shadow text-center">
                                    Detail
                                </a>

                                <a href="{{ route('transactions.struk', $transaction->id) }}"
                                   target="_blank"
                                   class="bg-gradient-to-r from-pink-300 to-pink-400 hover:from-pink-400 hover:to-pink-500 text-white px-4 py-2 rounded-xl shadow text-center">
                                    Struk
                                </a>

                                <a href="{{ route('transactions.whatsapp', $transaction->id) }}"
                                   target="_blank"
                                   class="bg-gradient-to-r from-pink-300 to-blue-300 hover:from-pink-400 hover:to-blue-400 text-white px-4 py-2 rounded-xl shadow text-center">
                                    WhatsApp
                                </a>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="13" class="p-10 text-center text-pink-300 text-lg font-semibold">
                            Belum ada laporan transaksi
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection