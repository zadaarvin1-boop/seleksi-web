<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{

    public function index()
    {
        $transaksis = Transaksi::with('details.barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('kode_barang')->get();

        $nomorTransaksi = 'TRX-' . now()->format('YmdHis')
            . '-' . strtoupper(Str::random(4));

        return view('transaksi.create', compact('barangs', 'nomorTransaksi'));
    }


    // Menyimpan transaksi dan detail barang
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|array|min:1',
            'barang_id.*' => 'required|integer|exists:barangs,id',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $items = [];
                $total = 0;

                foreach ($validated['barang_id'] as $index => $barangId) {
                    $jumlah = (int) $validated['jumlah'][$index];

                    if ($jumlah === 0) {
                        continue;
                    }

                    $barang = Barang::whereKey($barangId)
                        ->lockForUpdate()
                        ->firstOrFail();

                    if ($jumlah > $barang->stok) {
                        throw ValidationException::withMessages([
                            'jumlah' => "Stok {$barang->nama_barang} tidak mencukupi. Stok tersedia: {$barang->stok}.",
                        ]);
                    }

                    $harga = (float) $barang->harga;
                    $subtotal = $harga * $jumlah;

                    $items[] = [
                        'barang' => $barang,
                        'jumlah' => $jumlah,
                        'harga' => $harga,
                        'subtotal' => $subtotal,
                    ];

                    $total += $subtotal;
                }

                if (empty($items)) {
                    throw ValidationException::withMessages([
                        'barang_id' => 'Pilih minimal satu barang dengan jumlah lebih dari nol.',
                    ]);
                }

                // Membuat nomor transaksi otomatis
                $nomorTransaksi = DB::transaction(function () {
                    $terakhir = Transaksi::orderByDesc('id')
                        ->lockForUpdate()
                        ->first();

                    $nomor = $terakhir
                        ? ((int) $terakhir->id + 1)
                        : 1;

                    return 'TRX-' . str_pad(
                        (string) $nomor,
                        4,
                        '0',
                        STR_PAD_LEFT
                    );
                });

                // Menyimpan transaksi utama
                $transaksi = Transaksi::create([
                    'nomor_transaksi' => $nomorTransaksi,
                    'tanggal' => $validated['tanggal'],
                    'total' => $total,
                ]);

                // Menyimpan detail dan mengurangi stok
                foreach ($items as $item) {
                    DetailTransaksi::create([
                        'transaksi_id' => $transaksi->id,
                        'barang_id' => $item['barang']->id,
                        'harga' => $item['harga'],
                        'jumlah' => $item['jumlah'],
                        'subtotal' => $item['subtotal'],
                    ]);

                    $item['barang']->decrement(
                        'stok',
                        $item['jumlah']
                    );
                }
            });

            return redirect()
                ->route('transaksi.index')
                ->with('success', 'Transaksi berhasil disimpan.');

        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->with('error', 'Transaksi gagal disimpan. Periksa konfigurasi model dan database.');
        }
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaksi = Transaksi::with('details.barang')
            ->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}