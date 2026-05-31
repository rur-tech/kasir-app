<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::latest()->get();

        return view('bundles.index', compact('bundles'));
    }

    public function create()
    {
        return view('bundles.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'name' => 'required',

            'product_name' => 'required',

            'bundle_price' => 'required|numeric',

            'stock' => 'required|numeric',

            'description' => 'nullable',

        ]);

        Bundle::create([

            'name' => $request->name,

            'product_name' => $request->product_name,

            'bundle_price' => $request->bundle_price,

            'stock' => $request->stock,

            'description' => $request->description,

        ]);

        return redirect('/bundles')
            ->with('success', 'Bundling berhasil ditambahkan');
    }

    public function edit(Bundle $bundle)
    {
        return view('bundles.edit', compact('bundle'));
    }

    public function update(Request $request, Bundle $bundle)
    {
        $request->validate([

            'name' => 'required',

            'product_name' => 'required',

            'bundle_price' => 'required|numeric',

            'stock' => 'required|numeric',

            'description' => 'nullable',

        ]);

        $bundle->update([

            'name' => $request->name,

            'product_name' => $request->product_name,

            'bundle_price' => $request->bundle_price,

            'stock' => $request->stock,

            'description' => $request->description,

        ]);

        return redirect('/bundles')
            ->with('success', 'Bundling berhasil diupdate');
    }

    public function destroy(Bundle $bundle)
    {
        $bundle->delete();

        return back()
            ->with('success', 'Bundling berhasil dihapus');
    }
}