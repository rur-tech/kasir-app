<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <title>Struk Parfum</title>

    <style>

        body{
            font-family: Arial, sans-serif;
            width: 320px;
            margin: auto;
            font-size: 13px;
            color: #111;
        }

        .center{
            text-align: center;
        }

        table{
            width: 100%;
            border-collapse: collapse;
        }

        td{
            padding: 4px 0;
            vertical-align: top;
        }

        .line{
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .small{
            font-size: 12px;
        }

        .bold{
            font-weight: bold;
        }

        .total{
            font-size: 15px;
            font-weight: bold;
        }

        .bundle-box{
            background: #f9fafb;
            border: 1px dashed #999;
            padding: 6px 8px;
            border-radius: 8px;
            margin-top: 5px;
        }

        .footer{
            margin-top: 15px;
            text-align: center;
            font-size: 12px;
        }

        .text-right{
            text-align: right;
        }

        .product-name{
            font-weight: bold;
            padding-top: 6px;
        }

        @media print{

            body{
                width: 100%;
            }

        }

    </style>

</head>

<body>

@php

    /*
    |--------------------------------------------------------------------------
    | NAMA KASIR DARI AKUN LOGIN
    |--------------------------------------------------------------------------
    */
    $kasir = $transaction->user->name ?? auth()->user()->name ?? 'Kasir';

@endphp

{{-- HEADER --}}
<div class="center">

    <h2 style="margin-bottom:5px;">

        JURAGAN WANGI🧴

    </h2>

    <div class="small">

        Tampil percaya diri dengan wangi yang elegan

    </div>

    <div class="small">

        Parfum berkualitas tanpa mahal

    </div>

    <div class="small">

        082131442763

    </div>

</div>

<div class="line"></div>

{{-- INFO TRANSAKSI --}}
<table>

    <tr>

        <td>Tanggal</td>

        <td class="text-right">

            {{ $transaction->created_at->format('d M Y H:i') }}

        </td>

    </tr>

    <tr>

        <td>Kasir</td>

        <td class="text-right bold text-pink-600">

            {{ $kasir }}

        </td>

    </tr>

    <tr>

        <td>Pembayaran</td>

        <td class="text-right">

            {{ $transaction->paymentMethod->name ?? '-' }}

        </td>

    </tr>

    <tr>

        <td>Cabang</td>

        <td class="text-right">

            {{ $transaction->branch->name ?? '-' }}

        </td>

    </tr>

</table>

<div class="line"></div>

{{-- RINCIAN --}}
<div class="bold">

    Rincian Pesanan

</div>

<table>

    @forelse($transaction->details as $item)

        {{-- BUNDLE --}}
        @if(!empty($item->bundle_name))

            <tr>

                <td colspan="2">

                    <div class="bundle-box">

                        <div class="bold">

                            🎁 {{ $item->bundle_name }}

                        </div>

                    </div>

                </td>

            </tr>

        @endif

        {{-- NAMA PRODUK --}}
        <tr>

            <td colspan="2" class="product-name">

                🧴 {{ $item->product->name ?? 'Produk Bundle' }}

            </td>

        </tr>

        {{-- HARGA --}}
        <tr>

            <td>

                {{ $item->qty }} x
                Rp {{ number_format($item->price,0,',','.') }}

            </td>

            <td class="text-right">

                Rp {{ number_format($item->subtotal,0,',','.') }}

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="2" class="center">

                Tidak ada detail transaksi

            </td>

        </tr>

    @endforelse

</table>

<div class="line"></div>

{{-- TOTAL --}}
<table>

    <tr>

        <td>Subtotal</td>

        <td class="text-right">

            Rp {{ number_format($transaction->subtotal ?? 0,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>Diskon</td>

        <td class="text-right">

            - Rp {{ number_format($transaction->discount_total ?? 0,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td class="total">

            Total

        </td>

        <td class="text-right total">

            Rp {{ number_format($transaction->grand_total ?? 0,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>Bayar</td>

        <td class="text-right">

            Rp {{ number_format($transaction->cash ?? 0,0,',','.') }}

        </td>

    </tr>

    <tr>

        <td>Kembalian</td>

        <td class="text-right">

            Rp {{ number_format($transaction->change ?? 0,0,',','.') }}

        </td>

    </tr>

</table>

<div class="line"></div>

{{-- FOOTER --}}
<div class="footer">

    <div>

        Terima kasih telah berbelanja ✨

    </div>

    <div style="margin-top:5px;">

        Semoga puas & datang kembali dipembelian berikutnya😊

    </div>

    <div style="margin-top:10px; font-weight:bold;">

        JURAGAN WANGI

    </div>

</div>

</body>
</html>