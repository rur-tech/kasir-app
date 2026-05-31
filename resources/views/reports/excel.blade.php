<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Export Excel Laporan Transaksi
    </title>

    <style>

        body{
            font-family: Arial, sans-serif;
            color:#374151;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        th{
            background:#fbcfe8;
            color:#831843;
            font-weight:bold;
            text-align:center;
        }

        th,
        td{
            border:1px solid #e5e7eb;
            padding:10px;
            font-size:12px;
            vertical-align:top;
        }

        .title{
            font-size:24px;
            font-weight:bold;
            text-align:center;
            color:#be185d;
            margin-bottom:5px;
        }

        .subtitle{
            text-align:center;
            font-size:12px;
            margin-bottom:25px;
            color:#6b7280;
        }

        .green{
            color:#16a34a;
            font-weight:bold;
        }

        .red{
            color:#dc2626;
            font-weight:bold;
        }

        .blue{
            color:#2563eb;
            font-weight:bold;
        }

        .pink{
            color:#be185d;
            font-weight:bold;
        }

        .center{
            text-align:center;
        }

        .right{
            text-align:right;
        }

        .nowrap{
            white-space:nowrap;
        }

        .badge{
            display:inline-block;
            padding:4px 8px;
            border-radius:8px;
            background:#eef2ff;
            color:#4338ca;
            font-size:11px;
            font-weight:bold;
        }

    </style>

</head>

<body>

@php

    /*
    |--------------------------------------------------------------------------
    | NAMA LOGIN KASIR
    |--------------------------------------------------------------------------
    */
    $loginKasir = auth()->user()->name ?? 'Kasir';

@endphp

    {{-- HEADER --}}
    <div class="title">

        ✨ STAR'S PARFUM HYBRID ✨

    </div>

    <div class="subtitle">

        Laporan History Transaksi

        <br>

        Dicetak :
        {{ now()->format('d M Y H:i') }}

        <br>

        Dicetak Oleh :
        {{ $loginKasir }}

    </div>

    {{-- TABLE --}}
    <table>

        <thead>

            <tr>

                <th>No</th>

                <th>Nama Kasir</th>

                <th>Tanggal</th>

                <th>Cabang</th>

                <th>Produk</th>

                <th>Bundling</th>

                <th>Kategori</th>

                <th>Qty</th>

                <th>Harga</th>

                <th>Subtotal</th>

                <th>Pembayaran</th>

                <th>Diskon</th>

                <th>Grand Total</th>

                <th>Bayar</th>

                <th>Kembalian</th>

            </tr>

        </thead>

        <tbody>

            @php
                $no = 1;
            @endphp

            @forelse($transactions as $trx)

                @foreach($trx->details as $detail)

                    <tr>

                        {{-- NO --}}
                        <td class="center nowrap">

                            {{ $no++ }}

                        </td>

                        {{-- NAMA KASIR --}}
                        <td class="pink">

                            {{ $trx->user->name ?? $loginKasir }}

                        </td>

                        {{-- TANGGAL --}}
                        <td class="nowrap">

                            {{ $trx->created_at->format('d M Y') }}

                            <br>

                            <small>
                                {{ $trx->created_at->format('H:i') }}
                            </small>

                        </td>

                        {{-- CABANG --}}
                        <td>

                            {{ $trx->branch->name ?? '-' }}

                        </td>

                        {{-- PRODUK --}}
                        <td>

                            @if(!empty($detail->bundle_name))

                                <span class="badge">

                                    Bundle Product

                                </span>

                            @else

                                🧴
                                {{ $detail->product->name ?? '-' }}

                            @endif

                        </td>

                        {{-- BUNDLING --}}
                        <td class="blue">

                            @if(!empty($detail->bundle_name))

                                🎁 {{ $detail->bundle_name }}

                            @else

                                -

                            @endif

                        </td>

                        {{-- KATEGORI --}}
                        <td>

                            {{ $detail->product->category->name ?? '-' }}

                        </td>

                        {{-- QTY --}}
                        <td class="center">

                            {{ $detail->qty }}

                        </td>

                        {{-- HARGA --}}
                        <td class="right nowrap">

                            Rp {{ number_format($detail->price,0,',','.') }}

                        </td>

                        {{-- SUBTOTAL --}}
                        <td class="right nowrap">

                            Rp {{ number_format($detail->subtotal,0,',','.') }}

                        </td>

                        {{-- PEMBAYARAN --}}
                        <td>

                            {{ $trx->paymentMethod->name ?? '-' }}

                        </td>

                        {{-- DISKON --}}
                        <td class="right red nowrap">

                            Rp {{ number_format($trx->discount_total ?? 0,0,',','.') }}

                        </td>

                        {{-- TOTAL --}}
                        <td class="right green nowrap">

                            Rp {{ number_format($trx->grand_total ?? 0,0,',','.') }}

                        </td>

                        {{-- BAYAR --}}
                        <td class="right nowrap">

                            Rp {{ number_format($trx->cash ?? 0,0,',','.') }}

                        </td>

                        {{-- KEMBALIAN --}}
                        <td class="right nowrap">

                            Rp {{ number_format($trx->change ?? 0,0,',','.') }}

                        </td>

                    </tr>

                @endforeach

            @empty

                <tr>

                    <td colspan="15"
                        class="center"
                        style="padding:20px; color:#9ca3af;">

                        Belum ada transaksi

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</body>
</html>