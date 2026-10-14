@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Dashboard Toko RPL Jaya</h2>
    <hr>
    
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Jenis Barang</h5>
                    <h3>{{ $jumlahBarang }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <h3>{{ $jumlahTransaksi }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Total Pendapatan</h5>
                    <h3>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    
    @if($stokMenipis->count() > 0)
    <div class="alert alert-danger mt-3">
        <strong>Perhatian!</strong> Ada barang dengan stok menipis:
        <ul>
            @foreach($stokMenipis as $b)
                <li>{{ $b->nama_barang }} (Sisa stok: {{ $b->stok }})</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection