@extends('layouts.master', ['title' => 'Barang Keluar'])

@section('content')
    <x-container>
        <div class="col-12">
            <form action="{{ route('admin.report') }}" method="GET">
                <div class="row">
                    <div class="col-6">
                        <x-input title="Tanggal Awal" name="from" type="date" placeholder="" value="{{ $fromDate }}" />
                    </div>
                    <div class="col-6">
                        <x-input title="Tanggal Akhir" name="to" type="date" placeholder="" value="{{ $toDate }}" />
                    </div>
                </div>
                <x-button-save title="Cari Data" icon="search" class="btn btn-primary" />
            </form>
        </div>
        @isset($fromDate, $toDate)
            <div class="col-12 my-3">
                <x-card title="LAPORAN DATA BARANG" class="card-body p-0">
                    <x-table>
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
{{--                                <th>Kategori Barang</th>--}}
                                <th>Perubahan Kuantitas</th>
{{--                                <th>Kuantitas Barang Saat Ini</th>--}}
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($datas as $transaction)
                                @if ($transaction->details)
                                    @foreach ($transaction->details as $detail)
                                        <tr>
                                            <td>{{ $detail->product->name ?? $transaction->name }}</td>
{{--                                            <td>{{ $detail->product->category->name ?? '-' }}</td>--}}
                                            <td>{{ isset($detail->quantity) ? '- ' . $detail->quantity : '+ ' . $transaction->quantity }}</td>
{{--                                            <td>{{ $detail->product->quantity ?? 0 }}</td>--}}
                                            <td>{{ $transaction->created_at }}</td>
                                        </tr>
                                  @endforeach
                                @else
                                    <tr>
                                        <td>{{ $transaction->details[0]->product->name ?? $transaction->name }}</td>
{{--                                        <td>{{ $transaction->details[0]->product->category->name ?? '-' }}</td>--}}
                                        <td>{{ isset($transaction->details[0]->quantity) ? '- ' . $transaction->details[0]->quantity : '+ ' . $transaction->quantity }}</td>
{{--                                        <td>{{ $transaction->details[0]->product->quantity ?? 0 }}</td>--}}
                                        <td>{{ $transaction->created_at }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </x-table>
                </x-card>
            </div>
        @endisset
    </x-container>
@endsection
