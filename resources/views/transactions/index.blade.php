@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex justify-between items-center flex-wrap gap-3">

        <h1 class="text-3xl font-bold text-pink-700">
            Kasir Transaksi
        </h1>

        <a href="/transactions/history"
           class="bg-gradient-to-r from-pink-300 to-indigo-300 text-white px-5 py-3 rounded-xl shadow hover:opacity-90 transition">

            History

        </a>

    </div>

    {{-- ALERT --}}
    @if(session('success'))

        <div class="bg-green-100 text-green-700 p-4 rounded-2xl">
            {{ session('success') }}
        </div>

    @endif

    @if(session('error'))

        <div class="bg-red-100 text-red-700 p-4 rounded-2xl">
            {{ session('error') }}
        </div>

    @endif

    {{-- ERROR --}}
    @if ($errors->any())

        <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-2xl">

            <ul class="list-disc pl-5 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- FORM --}}
    <form action="{{ route('transactions.store') }}"
          method="POST"
          class="bg-white p-6 rounded-3xl shadow-xl">

        @csrf

        {{-- CABANG --}}
        <div class="grid md:grid-cols-2 gap-5">

            <div>

                <label class="font-semibold text-pink-700">
                    Cabang
                </label>

                <select name="branch_id"
                        id="branch_id"
                        class="w-full border p-3 rounded-2xl mt-2"
                        required>

                    <option value="">
                        -- Pilih Cabang --
                    </option>

                    @foreach($branches as $branch)

                        <option value="{{ $branch->id }}">
                            {{ $branch->name }}
                        </option>

                    @endforeach

                </select>

            </div>

            {{-- PAYMENT --}}
            <div>

                <label class="font-semibold text-indigo-700">
                    Metode Pembayaran
                </label>

                <select name="payment_method_id"
                        class="w-full border p-3 rounded-2xl mt-2"
                        required>

                    @foreach($payments as $payment)

                        <option value="{{ $payment->id }}">
                            {{ $payment->name }}
                        </option>

                    @endforeach

                </select>

            </div>

        </div>

        {{-- DISKON --}}
        <div class="mt-5">

            <label class="font-semibold text-red-500">
                Diskon Manual (%)
            </label>

            <input type="number"
                   name="manual_discount"
                   id="manual_discount"
                   value="0"
                   min="0"
                   max="100"
                   class="w-full border p-3 rounded-2xl mt-2">

        </div>

        {{-- BUNDLING --}}
        <div class="mt-6">

            <label class="font-semibold text-indigo-700 text-lg">
                Bundling Produk
            </label>

            <div class="grid md:grid-cols-2 gap-4 mt-3">

                @forelse($bundles as $bundle)

                    <button type="button"
                            onclick="addBundle(
                                '{{ $bundle->id }}',
                                '{{ $bundle->name }}',
                                '{{ $bundle->bundle_price }}'
                            )"
                            class="bg-gradient-to-r from-pink-50 to-indigo-50 border border-pink-100 rounded-2xl p-5 text-left hover:shadow-lg transition">

                        <div class="font-bold text-pink-700 text-lg">
                            🎁 {{ $bundle->name }}
                        </div>

                        @if($bundle->product_name)

                            <div class="text-gray-500 mt-2 text-sm">
                                {{ $bundle->product_name }}
                            </div>

                        @endif

                        <div class="mt-3 text-green-600 font-bold text-lg">
                            Rp {{ number_format($bundle->bundle_price,0,',','.') }}
                        </div>

                    </button>

                @empty

                    <div class="text-gray-400 italic">
                        Belum ada bundling
                    </div>

                @endforelse

            </div>

        </div>

        {{-- SEARCH PRODUK --}}
        <div class="mt-6">

            <label class="font-semibold text-pink-700">
                Cari Produk
            </label>

            <input type="text"
                   id="search"
                   placeholder="Ketik nama produk..."
                   class="w-full border p-3 rounded-2xl mt-2 bg-pink-50">

            <div id="result"
                 class="mt-3 space-y-2"></div>

        </div>

        {{-- CART --}}
        <div class="mt-6">

            <h2 class="font-bold text-xl text-pink-700 mb-4">
                Keranjang
            </h2>

            <div id="cart"
                 class="space-y-3"></div>

            <div id="cart-inputs"></div>

            <input type="hidden"
                   name="grand_total"
                   id="grand_total">

        </div>

        {{-- CASH --}}
        <div class="mt-6">

            <label class="font-semibold text-green-700">
                Uang Bayar
            </label>

            <input type="number"
                   name="cash"
                   id="cash"
                   placeholder="Masukkan uang bayar"
                   class="w-full border p-3 rounded-2xl mt-2"
                   required>

        </div>

        {{-- TOTAL --}}
        <div class="mt-6 bg-pink-50 rounded-3xl p-6 space-y-4">

            <div class="flex justify-between">

                <span>Subtotal</span>

                <span id="subtotal">
                    Rp 0
                </span>

            </div>

            <div class="flex justify-between text-red-500">

                <span>Diskon</span>

                <span id="discount_value">
                    Rp 0
                </span>

            </div>

            <hr>

            <div class="flex justify-between font-bold text-xl">

                <span>Total Bayar</span>

                <span id="total">
                    Rp 0
                </span>

            </div>

            <div class="flex justify-between text-green-600 font-bold">

                <span>Kembalian</span>

                <span id="change">
                    Rp 0
                </span>

            </div>

        </div>

        {{-- BUTTON --}}
        <button type="submit"
                class="mt-6 w-full bg-gradient-to-r from-pink-400 to-indigo-400 text-white py-4 rounded-2xl font-bold text-lg shadow-lg hover:opacity-90 transition">

            Simpan Transaksi

        </button>

    </form>

</div>

<script>

let products = [];
let cart = [];

/* ====================================
   FORMAT RUPIAH
==================================== */
function formatRupiah(num){

    return 'Rp ' + Number(num).toLocaleString('id-ID');

}

/* ====================================
   LOAD PRODUK
==================================== */
document.querySelector('#branch_id')
.addEventListener('change', function(){

    let branchId = this.value;

    if(!branchId){

        products = [];
        cart = [];

        renderCart();

        return;
    }

    fetch(`/api/products-by-branch/${branchId}`)

        .then(res => res.json())

        .then(res => {

            products = res.data || [];

            cart = [];

            renderCart();

        });

});

/* ====================================
   SEARCH PRODUK
==================================== */
document.getElementById('search')
.addEventListener('input', function(){

    let keyword = this.value.toLowerCase();

    let result = document.getElementById('result');

    result.innerHTML = '';

    if(keyword.length === 0) return;

    products.forEach(product => {

        if(product.name.toLowerCase().includes(keyword)){

            let div = document.createElement('div');

            div.className =
                "bg-white border border-pink-100 p-4 rounded-2xl cursor-pointer hover:bg-pink-50 transition";

            div.innerHTML = `
                <div class="font-bold text-pink-700">
                    ${product.name}
                </div>

                <div class="text-green-600 mt-1">
                    Rp ${Number(product.price).toLocaleString('id-ID')}
                </div>
            `;

            div.onclick = function(){

                addToCart(product);

                document.getElementById('search').value = '';

                result.innerHTML = '';

            };

            result.appendChild(div);

        }

    });

});

/* ====================================
   ADD PRODUK
==================================== */
function addToCart(product){

    let found = cart.find(item =>
        item.id == product.id &&
        !item.is_bundle
    );

    if(found){

        found.qty++;

    }else{

        cart.push({

            id: product.id,

            name: product.name,

            price: parseInt(product.price),

            qty: 1,

            is_bundle: false

        });

    }

    renderCart();

}

/* ====================================
   ADD BUNDLE
==================================== */
function addBundle(id, name, price){

    let found = cart.find(item =>
        item.bundle_id == id &&
        item.is_bundle
    );

    if(found){

        found.qty++;

    }else{

        cart.push({

            id: 'bundle-' + Date.now(),

            bundle_id: id,

            name: '🎁 ' + name,

            price: parseInt(price),

            qty: 1,

            is_bundle: true

        });

    }

    renderCart();

}

/* ====================================
   RENDER CART
==================================== */
function renderCart(){

    let cartDiv =
        document.getElementById('cart');

    let inputDiv =
        document.getElementById('cart-inputs');

    cartDiv.innerHTML = '';
    inputDiv.innerHTML = '';

    let subtotal = 0;

    cart.forEach((item,index) => {

        let totalItem =
            item.price * item.qty;

        subtotal += totalItem;

        let row = document.createElement('div');

        row.className =
            "flex justify-between items-center border border-pink-100 p-4 rounded-2xl";

        row.innerHTML = `

            <div>

                <div class="font-bold text-pink-700">
                    ${item.name}
                </div>

                <div class="text-gray-500 text-sm mt-1">
                    ${formatRupiah(item.price)}
                </div>

            </div>

            <div class="flex items-center gap-2">

                <input type="number"
                       min="1"
                       value="${item.qty}"
                       onchange="updateQty(${index}, this.value)"
                       class="border rounded-xl w-16 p-2 text-center">

                <button type="button"
                        onclick="removeItem(${index})"
                        class="bg-red-100 text-red-500 px-4 py-2 rounded-xl">

                    Hapus

                </button>

            </div>

        `;

        cartDiv.appendChild(row);

        /* ================================
           INPUT BUNDLE
        ================================= */
        if(item.is_bundle){

            inputDiv.innerHTML += `

                <input type="hidden"
                       name="bundles[${index}][id]"
                       value="${item.bundle_id}">

                <input type="hidden"
                       name="bundles[${index}][qty]"
                       value="${item.qty}">

            `;

        }else{

            /* ================================
               INPUT PRODUK
            ================================= */
            inputDiv.innerHTML += `

                <input type="hidden"
                       name="products[${index}][id]"
                       value="${item.id}">

                <input type="hidden"
                       name="products[${index}][qty]"
                       value="${item.qty}">

                <input type="hidden"
                       name="products[${index}][price]"
                       value="${item.price}">

            `;
        }

    });

    let discountPercent =
        parseInt(document.getElementById('manual_discount').value) || 0;

    let discount =
        subtotal * discountPercent / 100;

    let grandTotal =
        subtotal - discount;

    let cash =
        parseInt(document.getElementById('cash').value) || 0;

    let change =
        cash - grandTotal;

    document.getElementById('subtotal')
        .innerText = formatRupiah(subtotal);

    document.getElementById('discount_value')
        .innerText = '- ' + formatRupiah(discount);

    document.getElementById('total')
        .innerText = formatRupiah(grandTotal);

    document.getElementById('change')
        .innerText = formatRupiah(
            change > 0 ? change : 0
        );

    document.getElementById('grand_total')
        .value = grandTotal;

}

/* ====================================
   UPDATE QTY
==================================== */
function updateQty(index, qty){

    qty = parseInt(qty);

    if(qty <= 0){

        removeItem(index);

        return;
    }

    cart[index].qty = qty;

    renderCart();

}

/* ====================================
   REMOVE ITEM
==================================== */
function removeItem(index){

    cart.splice(index,1);

    renderCart();

}

/* ====================================
   EVENT
==================================== */
document.getElementById('cash')
.addEventListener('input', renderCart);

document.getElementById('manual_discount')
.addEventListener('input', renderCart);

</script>

@endsection