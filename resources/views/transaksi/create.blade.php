@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2>Form Transaksi Penjualan</h2>
        <hr>

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('transaksi.store') }}" method="POST">
            @csrf

            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nomor_transaksi" class="form-label">Nomor Transaksi</label>
                        <input type="text" class="form-control" id="nomor_transaksi" name="nomor_transaksi"
                            value="{{ $nomorTransaksi }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}"
                            required>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="card-header bg-primary text-white">Daftar Barang yang Dibeli</div>
                    <div class="card-body">
                        <table class="table table-bordered" id="table-transaksi">
                            <thead>
                                <tr>
                                    <th>Pilihan Barang</th>
                                    <th>Harga (Rp)</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal (Rp)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="item-row">
                                    <td>
                                        <select name="barang_id[]" class="form-control barang-select" required>
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach ($barangs as $barang)
                                                <option value="{{ $barang->id }}" data-harga="{{ $barang->harga }}"
                                                    data-stok="{{ $barang->stok }}">
                                                    {{ $barang->nama_barang }} (Stok: {{ $barang->stok }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control harga-text" readonly value="0">
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control jumlah-input"
                                            value="0" min="0" required>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control subtotal-text" readonly value="0">
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success btn-sm" id="add-row">+ Tambah Baris</button>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body text-end">
                        <h3>Total: Rp <span id="grand-total">0</span></h3>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Simpan Transaksi</button>
            </form>
    </div>

    <!-- JavaScript untuk Perhitungan Dinamis -->
    <script>
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('jumlah-input') || e.target.classList.contains('barang-select')) {
                hitungTotal();
            }
        });

        document.getElementById('add-row').addEventListener('click', function() {
            let tbody = document.querySelector('#table-transaksi tbody');
            let newRow = tbody.rows[0].cloneNode(true);
            newRow.querySelector('.barang-select').value = '';
            newRow.querySelector('.harga-text').value = '0';
            newRow.querySelector('.jumlah-input').value = '0';
            newRow.querySelector('.subtotal-text').value = '0';
            tbody.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-row')) {
                let tbody = document.querySelector('#table-transaksi tbody');
                if (tbody.rows.length > 1) {
                    e.target.closest('tr').remove();
                    hitungTotal();
                } else {
                    alert('Minimal harus ada 1 barang dalam transaksi.');
                }
            }
        });

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('barang-select')) {
                let row = e.target.closest('tr');
                let selectedOption = e.target.options[e.target.selectedIndex];
                let harga = selectedOption.getAttribute('data-harga') || 0;
                let jumlahInput = row.querySelector('.jumlah-input');

                row.querySelector('.harga-text').value = harga;

                if (e.target.value !== '') {
                    if (jumlahInput.value === '0' || jumlahInput.value === '') {
                        jumlahInput.value = '1';
                    }
                } else {
                    jumlahInput.value = '0';
                }

                hitungTotal();
            }
        });

        function hitungTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.item-row').forEach(row => {
                let select = row.querySelector('.barang-select');
                let jumlahInput = row.querySelector('.jumlah-input');
                let subtotalText = row.querySelector('.subtotal-text');

                let harga = parseFloat(select.options[select.selectedIndex]?.getAttribute('data-harga')) || 0;
                let jumlah = parseInt(jumlahInput.value) || 0;

                let subtotal = harga * jumlah;
                subtotalText.value = subtotal;
                grandTotal += subtotal;
            });

            document.getElementById('grand-total').innerText = grandTotal.toLocaleString('id-ID');
        }
    </script>
@endsection
