@extends('layouts.master', ['title' => 'Permintaan Produk'])

@section('content')
    <x-container>
        <div class="row">
            <div class="col-12">
                <x-card title="TAMBAH PERMINTAAN PRODUK" class="card-body">
                    <form action="{{ route('admin.order.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <x-select title="Produk" name="product_id">
                            <option value>Silahkan Pilih</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </x-select>
                        <x-input title="Tambahan Stok Produk" name="quantity" type="number"
                                 placeholder="Tambahan Stok Produk" :value="0" />
                        <x-button-save title="Simpan" icon="save" class="btn btn-primary" />
                        <x-button-link title="Kembali" icon="arrow-left" :url="route('admin.order.index')" class="btn btn-dark"
                            style="mr-1" />
                    </form>
                </x-card>
            </div>
        </div>
    </x-container>
@endsection
