<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use App\Exports\TransactionsExport;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX REPORT
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $transactions = Transaction::with([
            'branch',
            'paymentMethod',
            'details.product',
            'user',
        ])->latest()->get();

        return view(
            'reports.index',
            compact('transactions')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function excel()
    {
        return Excel::download(
            new TransactionsExport,
            'laporan-transaksi.xlsx'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT PDF
    |--------------------------------------------------------------------------
    */
    public function pdf()
    {
        $transactions = Transaction::with([
            'branch',
            'paymentMethod',
            'details.product',
            'user',
        ])->latest()->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG DISKON
        |--------------------------------------------------------------------------
        */
        foreach ($transactions as $transaction) {

            $subtotal =
                $transaction->details->sum(function ($detail) {

                    return $detail->price * $detail->qty;
                });

            $transaction->subtotal_asli =
                $subtotal;

            $transaction->diskon_manual =
                $transaction->discount_total ?? 0;
        }

        $pdf = Pdf::loadView(
            'reports.pdf',
            compact('transactions')
        );

        return $pdf->download(
            'laporan-transaksi.pdf'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STRUK
    |--------------------------------------------------------------------------
    */
    public function struk($id)
    {
        $transaction = Transaction::with([
            'details.product',
            'branch',
            'paymentMethod',
            'user',
        ])->findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | HITUNG SUBTOTAL
        |--------------------------------------------------------------------------
        */
        $subtotal =
            $transaction->details->sum(function ($detail) {

                return $detail->price * $detail->qty;
            });

        $transaction->subtotal_asli =
            $subtotal;

        $transaction->diskon_manual =
            $transaction->discount_total ?? 0;

        return view(
            'reports.struk',
            compact('transaction')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | WHATSAPP
    |--------------------------------------------------------------------------
    */
    public function whatsapp($id)
    {
        $transaction = Transaction::with([
            'details.product',
            'branch',
            'paymentMethod',
            'user',
        ])->findOrFail($id);

        return view(
            'transactions.whatsapp',
            compact('transaction')
        );
    }
}