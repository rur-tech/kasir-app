<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Kirim WhatsApp</title>

</head>

<body>

@php

$kasir =
    $transaction->user->name
    ?? auth()->user()->name
    ?? 'Admin';

/*
|--------------------------------------------------------------------------
| FUNCTION CLEAN TEXT (ANTI � / EMOJI)
|--------------------------------------------------------------------------
*/
function cleanWaText($text)
{
    // hapus emoji & karakter non-ASCII aman WA
    return preg_replace('/[^\x20-\x7E\x0A\x0D]/u', '', $text);
}

/*
|--------------------------------------------------------------------------
| HEADER
|--------------------------------------------------------------------------
*/

$pesan  = "JURAGAN WANGI\n";
$pesan .= "Tampil percaya diri dengan wangi yang elegan\n";
$pesan .= "Parfum berkualitas tanpa mahal\n";
$pesan .= "082131442763\n";
$pesan .= "====================================\n\n";

/*
|--------------------------------------------------------------------------
| INFO TRANSAKSI
|--------------------------------------------------------------------------
*/

$pesan .= "Tanggal : ";
$pesan .= $transaction->created_at->format('d M Y H:i');
$pesan .= "\n";

$pesan .= "Nama Kasir : ";
$pesan .= $kasir;
$pesan .= "\n";

$pesan .= "Cabang : ";
$pesan .= $transaction->branch->name ?? '-';
$pesan .= "\n";

$pesan .= "Pembayaran : ";
$pesan .= $transaction->paymentMethod->name ?? '-';
$pesan .= "\n\n";

/*
|--------------------------------------------------------------------------
| RINCIAN PESANAN
|--------------------------------------------------------------------------
*/

$pesan .= "RINCIAN PESANAN\n";
$pesan .= "------------------------------------\n";

foreach($transaction->details as $item){

    if(!empty($item->bundle_name)){

        $pesan .= "Bundle : ";
        $pesan .= $item->bundle_name;
        $pesan .= "\n";

        if($item->product){
            $pesan .= "   -> ";
            $pesan .= $item->product->name;
            $pesan .= "\n";
        }else{
            $pesan .= "   -> Paket Bundle\n";
        }

    } else {

        $pesan .= "";
        $pesan .= $item->product->name ?? 'Produk';
        $pesan .= "\n";
    }

    $pesan .= $item->qty;
    $pesan .= " x Rp ";
    $pesan .= number_format($item->price ?? 0,0,',','.');
    $pesan .= " = Rp ";
    $pesan .= number_format($item->subtotal ?? 0,0,',','.');
    $pesan .= "\n\n";
}

/*
|--------------------------------------------------------------------------
| TOTAL
|--------------------------------------------------------------------------
*/

$pesan .= "------------------------------------\n";

$pesan .= "Subtotal : Rp ";
$pesan .= number_format($transaction->subtotal ?? 0,0,',','.');
$pesan .= "\n";

$pesan .= "Diskon : Rp ";
$pesan .= number_format($transaction->discount_total ?? 0,0,',','.');
$pesan .= "\n";

$pesan .= "Grand Total : Rp ";
$pesan .= number_format($transaction->grand_total ?? 0,0,',','.');
$pesan .= "\n";

$pesan .= "Bayar : Rp ";
$pesan .= number_format($transaction->cash ?? 0,0,',','.');
$pesan .= "\n";

$pesan .= "Kembalian : Rp ";
$pesan .= number_format($transaction->change ?? 0,0,',','.');
$pesan .= "\n\n";

/*
|--------------------------------------------------------------------------
| FOOTER
|--------------------------------------------------------------------------
*/

$pesan .= "====================================\n";
$pesan .= "Terima kasih telah berbelanja\n";
$pesan .= "Semoga puas dan datang kembali dipembelian berikutnya\n";
$pesan .= "JURAGAN WANGI";

$pesan = cleanWaText($pesan);

@endphp

<script>

    window.location.href =
        "https://wa.me/?text={{ urlencode($pesan) }}";

</script>

</body>
</html>