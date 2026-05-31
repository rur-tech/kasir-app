<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title>
        Laporan PDF Transaksi
    </title>

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
            font-size:12px;
            color:#374151;
            margin:25px;
        }

        .header{
            text-align:center;
            margin-bottom:25px;
        }

        .title{
            font-size:24px;
            font-weight:bold;
            color:#be185d;
        }

        .subtitle{
            font-size:12px;
            color:#6b7280;
            margin-top:5px;
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
        }

        table,
        th,
        td{
            border:1px solid #e5e7eb;
        }

        th{
            background:#ec4899;
            color:white;
            font-size:12px;
            font-weight:bold;
            text-align:center;
            padding:10px;
        }

        td{
            padding:10px;
            vertical-align:top;
        }

        .text-center{
            text-align:center;
        }

        .text-right{
            text-align:right;
        }

        .text-green{
            color:#16a34a;
            font-weight:bold;
        }

        .text-red{
            color:#dc2626;
            font-weight:bold;
        }

        .text-pink{
            color:#be185d;
            font-weight:bold;
        }

        .badge{
            display:inline-block;
            padding:4px 8px;
            background:#fce7f3;
            border-radius:8px;
            font-size:11px;
            color:#be185d;
            font-weight:bold;
        }

        .footer{
            margin-top:30px;
            text-align:right;
        }

        .grand-total{
            font-size:18px;
            font-weight:bold;
            color:#16a34a;
        }

        .note{
            margin-top:40px;
            text-align:center;
            font-size:11px;
            color:#9ca3af;
        }

    </style>

</head>

<body>

    {{-- HEADER --}}
    <div class="header">

        <div class="title">

            ✨ STAR'S PARFUM HYBRID ✨

        </div>

        <div class="subtitle">

            Laporan History Transaksi

            <br>

            Dicetak :
            {{ now()->format('d M Y H:i') }}

        </div>

    </div>

    {{-- TABLE --}}
    <table>

        <thead>

            <tr>

                <th width="5%">
                    No
                </th>

                <th width="15%">
                    Tanggal
                </th>

                <th width="15%">
                    Nama Kasir
                </th>

                <th width="12%">
                    Cabang
                </th>

                <th width="20%">
                    Produk / Bundling
                </th>

                <th width="10%">
                    Pembayaran
                </th>

                <th width="8%">
                    Diskon
                </th>

                <th width="15%">
                    Total
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($transactions as $transaction)

                <tr>

                    {{-- NO --}}
                    <td class="text-center">

                        {{ $loop->iteration }}

                    </td>

                    {{-- TANGGAL --}}
                    <td>

                        {{ $transaction->created_at->format('d M Y') }}

                        <br>

                        <small>
                            {{ $transaction->created_at->format('H:i') }}
                        </small>

                    </td>

                    {{-- KASIR --}}
                    <td class="text-pink">

                        {{ $transaction->user->name ?? 'Admin' }}

                    </td>

                    {{-- CABANG --}}
                    <td>

                        {{ $transaction->branch->name ?? '-' }}

                    </td>

                    {{-- PRODUK --}}
                    <td>

                        @forelse($transaction->details as $detail)

                            @if(!empty($detail->bundle_name))

                                <div style="margin-bottom:8px;">

                                    <span class="badge">

                                        🎁 {{ $detail->bundle_name }}

                                    </span>

                                    <br>

                                    Qty :
                                    {{ $detail->qty }}

                                </div>

                            @else

                                <div style="margin-bottom:8px;">

                                    🧴
                                    {{ $detail->product->name ?? '-' }}

                                    <br>

                                    Qty :
                                    {{ $detail->qty }}

                                </div>

                            @endif

                        @empty

                            -

                        @endforelse

                    </td>

                    {{-- PEMBAYARAN --}}
                    <td class="text-center">

                        {{ $transaction->paymentMethod->name ?? '-' }}

                    </td>

                    {{-- DISKON --}}
                    <td class="text-right text-red">

                        Rp {{ number_format($transaction->discount_total ?? 0,0,',','.') }}

                    </td>

                    {{-- TOTAL --}}
                    <td class="text-right text-green">

                        Rp {{ number_format($transaction->grand_total ?? 0,0,',','.') }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8"
                        class="text-center"
                        style="padding:20px; color:#9ca3af;">

                        Tidak ada data transaksi

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    {{-- TOTAL --}}
    <div class="footer">

        <div class="grand-total">

            Total Pendapatan :
            Rp {{ number_format($transactions->sum('grand_total'),0,',','.') }}

        </div>

    </div>

    {{-- FOOTER --}}
    <div class="note">

        STAR'S PARFUM HYBRID

        <br>

        Premium Fragrance & Luxury Aroma

    </div>

</body>
</html>