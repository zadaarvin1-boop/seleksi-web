@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Transaksi Penjualan</h2>
    <hr>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('transaksi.create') }}" class="btn btn-primary mb-3">+ Buat Transaksi Baru</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Transaksi</th>
                <th>Tanggal</th>
                <th>Total (Rp)</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $index => $trx)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $trx->nomor_transaksi }}</td>
                <td>{{ $trx->tanggal }}</td>
                <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                <td>
                    <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-info btn-sm">Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection