@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Data Barang</h2>
            <p class="text-muted mb-0">Toko RPL</p>
        </div>

        <a href="{{ route('barang.create') }}" class="btn btn-primary">
            + Tambah Barang
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">No.</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($barangs as $barang)
                        <tr>
                            <td class="ps-3">{{ $loop->iteration }}</td>
                            <td><span class="badge bg-secondary">{{ $barang->kode_barang }}</span></td>
                            <td class="fw-semibold">{{ $barang->nama_barang }}</td>
                            <td>
                                Rp{{ number_format($barang->harga, 0, ',', '.') }}
                            </td>
                            <td>
                                @if($barang->stok <= 5)
                                    <span class="badge bg-danger">{{ $barang->stok }} (Menipis)</span>
                                @else
                                    <span class="badge bg-success">{{ $barang->stok }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('barang.edit', $barang->id) }}"
                                    class="btn btn-sm btn-warning text-white">Edit</a>

                                <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection