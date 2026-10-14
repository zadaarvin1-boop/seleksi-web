@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Nota Transaksi: {{ $transaksi->nomor_transaksi }}</h2>
            <!-- Tombol Cetak yang tidak ikut tercetak -->
            <button onclick="window.print()" class="btn btn-secondary d-print-none">🖨️ Cetak Nota</button>
        </div>
        <p><strong>Tanggal:</strong> {{ $transaksi->tanggal }}</p>
        <hr>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($transaksi->details as $detail)
                    <tr>
                        <td>{{ $detail->barang->kode_barang }}</td>
                        <td>{{ $detail->barang->nama_barang }}</td>
                        <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td>{{ $detail->jumlah }}</td>
                        <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada detail barang untuk transaksi ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <h4>Total Keseluruhan: Rp {{ number_format($transaksi->total, 0, ',', '.') }}</h4>

        <div class="mt-4 d-print-none">
            <a href="{{ route('transaksi.index') }}" class="btn btn-primary">Kembali ke Riwayat</a>
        </div>
    </div>

    <!-- CSS agar saat tombol cetak ditekan, tampilan bersih seperti nota -->
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .container,
            .container * {
                visibility: visible;
            }

            .container {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .d-print-none {
                display: none !important;
            }
        }
    </style>
@endsection
