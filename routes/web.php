<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Branch;
use App\Models\Bundle;

use App\Exports\TransactionsExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    return redirect('/dashboard');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    return view('dashboard', [

        /*
        |--------------------------------------------------------------------------
        | PEMASUKAN
        |--------------------------------------------------------------------------
        */

        'todayIncome' => Transaction::whereDate(
            'created_at',
            today()
        )->sum('grand_total'),

        'monthIncome' => Transaction::whereMonth(
            'created_at',
            now()->month
        )->sum('grand_total'),

        'yearIncome' => Transaction::whereYear(
            'created_at',
            now()->year
        )->sum('grand_total'),

        'allIncome' => Transaction::sum(
            'grand_total'
        ),

        /*
        |--------------------------------------------------------------------------
        | TOTAL DATA
        |--------------------------------------------------------------------------
        */

        'totalTransactions' => Transaction::count(),

        'totalProducts' => Product::count(),

        'totalBundles' => Bundle::count(),

        'totalStock' => Product::sum('stock'),

        'totalBranches' => Branch::count(),

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */

        'transactions' => Transaction::with([
                'branch',
                'user'
            ])
            ->latest()
            ->take(10)
            ->get(),

    ]);

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTH MIDDLEWARE
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | CABANG
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'branches',
        BranchController::class
    );

    /*
    |--------------------------------------------------------------------------
    | KATEGORI
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'categories',
        CategoryController::class
    );

    /*
    |--------------------------------------------------------------------------
    | PRODUK
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'products',
        ProductController::class
    );

    /*
    |--------------------------------------------------------------------------
    | BUNDLING
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'bundles',
        BundleController::class
    );

    /*
    |--------------------------------------------------------------------------
    | METODE PEMBAYARAN
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'payment-methods',
        PaymentMethodController::class
    );

    /*
    |--------------------------------------------------------------------------
    | API PRODUK BERDASARKAN CABANG
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/api/products-by-branch/{id}',
        [ProductController::class, 'byBranch']
    );

    /*
    |--------------------------------------------------------------------------
    | TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions/history',
        [TransactionController::class, 'history']
    )->name('transactions.history');

    /*
    |--------------------------------------------------------------------------
    | STRUK TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions/{id}/struk',
        [ReportController::class, 'struk']
    )->name('transactions.struk');

    /*
    |--------------------------------------------------------------------------
    | WHATSAPP STRUK
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/transactions/{id}/whatsapp',
        [ReportController::class, 'whatsapp']
    )->name('transactions.whatsapp');

    /*
    |--------------------------------------------------------------------------
    | RESOURCE TRANSAKSI
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'transactions',
        TransactionController::class
    );

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports',
        [ReportController::class, 'index']
    )->name('reports.index');

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/excel/export',
        function () {

            return Excel::download(
                new TransactionsExport,
                'laporan-transaksi.xlsx'
            );

        }

    )->name('reports.excel');

    /*
    |--------------------------------------------------------------------------
    | STRUK DARI LAPORAN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/reports/struk/{id}',
        [ReportController::class, 'struk']
    )->name('reports.struk');

});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';