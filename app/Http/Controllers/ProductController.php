<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Branch;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $products = Product::with([
                'branch',
                'category'
            ])
            ->latest()
            ->get();

        return view(
            'products.index',
            compact('products')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $branches = Branch::all();

        $categories = Category::all();

        return view(
            'products.create',
            compact(
                'branches',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([

            'branch_id' => 'required',

            'category_id' => 'required',

            'name' => 'required',

            'price' => 'required|numeric',

            'stock' => 'required|numeric',

        ]);

        Product::create([

            'branch_id' => $request->branch_id,

            'category_id' => $request->category_id,

            'name' => $request->name,

            'price' => $request->price,

            'stock' => $request->stock,

        ]);

        return redirect('/products')
            ->with(
                'success',
                'Produk berhasil ditambah'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit(Product $product)
    {
        $branches = Branch::all();

        $categories = Category::all();

        return view(
            'products.edit',
            compact(
                'product',
                'branches',
                'categories'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        Product $product
    ) {

        $request->validate([

            'branch_id' => 'required',

            'category_id' => 'required',

            'name' => 'required',

            'price' => 'required|numeric',

            'stock' => 'required|numeric',

        ]);

        $product->update([

            'branch_id' => $request->branch_id,

            'category_id' => $request->category_id,

            'name' => $request->name,

            'price' => $request->price,

            'stock' => $request->stock,

        ]);

        return redirect('/products')
            ->with(
                'success',
                'Produk berhasil diupdate'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/products')
            ->with(
                'success',
                'Produk berhasil dihapus'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | API PRODUK BERDASARKAN CABANG
    |--------------------------------------------------------------------------
    */
    public function byBranch($id)
    {
        $products = Product::where(
                'branch_id',
                $id
            )
            ->select(
                'id',
                'name',
                'price',
                'stock'
            )
            ->latest()
            ->get();

        return response()->json([

            'success' => true,

            'data' => $products

        ]);
    }
}