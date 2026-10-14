<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toko RPL Jaya</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">Toko RPL Jaya</a>
        <a href="{{ route('barang.index') }}" class="btn btn-light btn-sm">
            Data Barang
        </a>
    </div>
</nav>

<main class="container py-5">
    <div class="bg-white rounded-3 shadow-sm p-4 p-md-5">
        <p class="text-primary fw-semibold mb-2">SISTEM INFORMASI PENJUALAN</p>

        <h1 class="fw-bold mb-3">Selamat Datang di Toko RPL Jaya</h1>

        <p class="text-secondary mb-4">
            Kelola data barang, pantau stok, dan lakukan pengelolaan
            transaksi penjualan melalui satu aplikasi.
        </p>

        <a href="{{ route('barang.index') }}" class="btn btn-primary">
            Kelola Data Barang
        </a>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5>Data Barang</h5>
                    <p class="text-secondary small">
                        Tambah, lihat, ubah, dan hapus data barang.
                    </p>
                    <a href="{{ route('barang.index') }}" class="btn btn-outline-primary btn-sm">
                        Buka Data Barang
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5>Transaksi</h5>
                    <p class="text-secondary small">
                        Fitur transaksi penjualan akan tersedia setelah modul transaksi dibuat.
                    </p>
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                        Belum Tersedia
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5>Riwayat Penjualan</h5>
                    <p class="text-secondary small">
                        Riwayat transaksi dapat ditampilkan setelah modul transaksi selesai.
                    </p>
                    <button class="btn btn-outline-secondary btn-sm" disabled>
                        Belum Tersedia
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>

<footer class="text-center text-secondary py-4 small">
    &copy; {{ date('Y') }} Toko RPL Jaya
</footer>

</body>
</html>