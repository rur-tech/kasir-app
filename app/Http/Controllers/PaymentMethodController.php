<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = PaymentMethod::latest()->get();

        return view('payment-methods.index', compact('paymentMethods'));
    }

    public function create()
    {
        return view('payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        PaymentMethod::create([
            'name' => $request->name
        ]);

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        return view('payment-methods.show', compact('paymentMethod'));
    }

    public function edit(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        return view('payment-methods.edit', compact('paymentMethod'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $paymentMethod = PaymentMethod::findOrFail($id);

        $paymentMethod->update([
            'name' => $request->name
        ]);

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil diupdate');
    }

    public function destroy(string $id)
    {
        $paymentMethod = PaymentMethod::findOrFail($id);

        $paymentMethod->delete();

        return redirect()
            ->route('payment-methods.index')
            ->with('success', 'Metode pembayaran berhasil dihapus');
    }
}