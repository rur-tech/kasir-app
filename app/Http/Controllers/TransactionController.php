<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Branch;
use App\Models\Bundle;
use App\Models\Transaction;
use App\Models\PaymentMethod;
use App\Models\TransactionDetail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $products = Product::with([
            'branch',
            'category'
        ])->get();

        $branches = Branch::all();

        $payments = PaymentMethod::all();

        $bundles = Bundle::latest()->get();

        return view('transactions.index', compact(
            'products',
            'branches',
            'payments',
            'bundles'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([

            'branch_id' => 'required',

            'payment_method_id' => 'required',

            'cash' => 'required|numeric|min:0',

            'products' => 'nullable|array',

            'bundles' => 'nullable|array',

        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | SUBTOTAL
            |--------------------------------------------------------------------------
            */
            $subtotal = 0;

            $discountPercent =
                $request->manual_discount ?? 0;

            /*
            |--------------------------------------------------------------------------
            | BUAT TRANSAKSI
            |--------------------------------------------------------------------------
            */
            $transaction = Transaction::create([

                /*
                |--------------------------------------------------------------------------
                | USER LOGIN / KASIR
                |--------------------------------------------------------------------------
                */
                'user_id' => auth()->id(),

                'branch_id' =>
                    $request->branch_id,

                'payment_method_id' =>
                    $request->payment_method_id,

                'subtotal' => 0,

                'discount_total' => 0,

                'grand_total' => 0,

                'cash' =>
                    $request->cash,

                'change' => 0,

            ]);

            /*
            |--------------------------------------------------------------------------
            | PRODUK NORMAL
            |--------------------------------------------------------------------------
            */
            if ($request->products) {

                foreach ($request->products as $item) {

                    $qty = $item['qty'] ?? 0;

                    if ($qty > 0) {

                        $product =
                            Product::findOrFail(
                                $item['id']
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | VALIDASI STOCK
                        |--------------------------------------------------------------------------
                        */
                        if ($product->stock < $qty) {

                            throw new \Exception(

                                'Stock produk '
                                . $product->name .
                                ' tidak cukup'

                            );
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | HITUNG SUBTOTAL
                        |--------------------------------------------------------------------------
                        */
                        $sub =
                            $product->price * $qty;

                        /*
                        |--------------------------------------------------------------------------
                        | SIMPAN DETAIL
                        |--------------------------------------------------------------------------
                        */
                        TransactionDetail::create([

                            'transaction_id' =>
                                $transaction->id,

                            'product_id' =>
                                $product->id,

                            'price' =>
                                $product->price,

                            'qty' =>
                                $qty,

                            'subtotal' =>
                                $sub,

                            'bundle_name' =>
                                null,

                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | KURANGI STOCK
                        |--------------------------------------------------------------------------
                        */
                        $product->decrement(
                            'stock',
                            $qty
                        );

                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL
                        |--------------------------------------------------------------------------
                        */
                        $subtotal += $sub;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | BUNDLE MANUAL
            |--------------------------------------------------------------------------
            */
            if ($request->bundles) {

                foreach ($request->bundles as $bundleItem) {

                    $bundleQty =
                        $bundleItem['qty'] ?? 0;

                    if ($bundleQty > 0) {

                        /*
                        |--------------------------------------------------------------------------
                        | AMBIL BUNDLE
                        |--------------------------------------------------------------------------
                        */
                        $bundle =
                            Bundle::findOrFail(
                                $bundleItem['id']
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | HITUNG TOTAL BUNDLE
                        |--------------------------------------------------------------------------
                        */
                        $bundleSubtotal =
                            $bundle->bundle_price
                            * $bundleQty;

                        /*
                        |--------------------------------------------------------------------------
                        | SIMPAN DETAIL BUNDLE
                        |--------------------------------------------------------------------------
                        */
                        TransactionDetail::create([

                            'transaction_id' =>
                                $transaction->id,

                            /*
                            |--------------------------------------------------------------------------
                            | PRODUCT NULL
                            |--------------------------------------------------------------------------
                            */
                            'product_id' => null,

                            'price' =>
                                $bundle->bundle_price,

                            'qty' =>
                                $bundleQty,

                            'subtotal' =>
                                $bundleSubtotal,

                            'bundle_name' =>
                                $bundle->name,

                        ]);

                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL
                        |--------------------------------------------------------------------------
                        */
                        $subtotal +=
                            $bundleSubtotal;
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | DISKON
            |--------------------------------------------------------------------------
            */
            $discountTotal =
                ($subtotal * $discountPercent)
                / 100;

            /*
            |--------------------------------------------------------------------------
            | GRAND TOTAL
            |--------------------------------------------------------------------------
            */
            $grandTotal =
                $subtotal - $discountTotal;

            /*
            |--------------------------------------------------------------------------
            | KEMBALIAN
            |--------------------------------------------------------------------------
            */
            $change =
                $request->cash - $grandTotal;

            if ($change < 0) {

                throw new \Exception(
                    'Uang bayar kurang'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | UPDATE TRANSAKSI
            |--------------------------------------------------------------------------
            */
            $transaction->update([

                'subtotal' =>
                    $subtotal,

                'discount_total' =>
                    $discountTotal,

                'grand_total' =>
                    $grandTotal,

                'change' =>
                    $change,

            ]);

            DB::commit();

            return redirect()
                ->route('transactions.history')
                ->with(
                    'success',
                    'Transaksi berhasil disimpan'
                );

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $transaction = Transaction::with([

            'details.product',

            'branch',

            'paymentMethod',

            'user',

        ])->findOrFail($id);

        return view(
            'transactions.show',
            compact('transaction')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HISTORY TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function history()
    {
        $transactions = Transaction::with([

            'branch',

            'paymentMethod',

            'details.product',

            'user',

        ])
        ->latest()
        ->paginate(10);

        return view(
            'transactions.history',
            compact('transactions')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS TRANSAKSI
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $transaction =
                Transaction::with('details')
                ->findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | KEMBALIKAN STOCK
            |--------------------------------------------------------------------------
            */
            foreach (
                $transaction->details
                as $detail
            ) {

                if ($detail->product_id) {

                    $product = Product::find(
                        $detail->product_id
                    );

                    if ($product) {

                        $product->increment(
                            'stock',
                            $detail->qty
                        );
                    }
                }
            }

            /*
            |--------------------------------------------------------------------------
            | HAPUS DETAIL
            |--------------------------------------------------------------------------
            */
            $transaction->details()
                ->delete();

            /*
            |--------------------------------------------------------------------------
            | HAPUS TRANSAKSI
            |--------------------------------------------------------------------------
            */
            $transaction->delete();

            DB::commit();

            return back()->with(
                'success',
                'Transaksi berhasil dihapus'
            );

        } catch (\Exception $e) {

            DB::rollback();

            return back()->with(
                'error',
                $e->getMessage()
            );
        }
    }
}