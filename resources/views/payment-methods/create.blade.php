@extends('layouts.app')

@section('content')

<h1 class="text-3xl font-bold mb-6 text-pink-700">
    Tambah Metode Pembayaran
</h1>

<form action="{{ route('payment-methods.store') }}"
      method="POST"
      class="bg-gradient-to-br from-pink-50 via-blue-50 to-pink-100
             p-8 rounded-3xl shadow-2xl border border-pink-200 space-y-5">

    @csrf

    <div>

        <label class="block mb-2 font-semibold text-pink-700">
            Nama Metode Pembayaran
        </label>

        <input type="text"
               name="name"
               class="w-full border-2 border-pink-200 bg-white/80
                      p-3 rounded-2xl
                      focus:outline-none
                      focus:ring-4 focus:ring-pink-200
                      focus:border-blue-300
                      transition"
               placeholder="Cash / QRIS / Transfer">

    </div>

    <button
        class="bg-gradient-to-r from-pink-400 to-blue-400
               hover:from-pink-500 hover:to-blue-500
               text-white font-semibold
               px-6 py-3 rounded-2xl shadow-lg transition">

        Simpan

    </button>

</form>

@endsection