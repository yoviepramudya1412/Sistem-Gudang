<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\MutasiBarangRequest;
use App\Http\Resources\Api\V1\MutasiBarangCollection;
use App\Http\Resources\Api\V1\MutasiBarangResource;
use App\Models\MutasiBarang;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MutasiBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = MutasiBarang::with(['barang', 'pengguna', 'lokasiAsal', 'lokasiTujuan'])
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('nomor_referensi', 'like', "%$search%")
                    ->orWhereHas('barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', "%$search%");
                    });
            })
            ->when($request->has('jenis_mutasi'), function ($query) use ($request) {
                $query->where('jenis_mutasi', $request->jenis_mutasi);
            })
            ->when($request->has('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->has('barang_id'), function ($query) use ($request) {
                $query->where('barang_id', $request->barang_id);
            })
            ->when($request->has('pengguna_id'), function ($query) use ($request) {
                $query->where('pengguna_id', $request->pengguna_id);
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $mutasi = $query->paginate($request->input('per_page', 15));

        return new MutasiBarangCollection($mutasi);
    }

    public function store(MutasiBarangRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $data = $request->validated();
            $data['pengguna_id'] = $request->user()->id;
            
            $mutasi = MutasiBarang::create($data);

            // Update stok barang
            $barang = $mutasi->barang;
            $stokSebelumnya = $barang->stok;
            
            if ($mutasi->jenis_mutasi === 'masuk') {
                $barang->stok += $mutasi->jumlah;
            } elseif ($mutasi->jenis_mutasi === 'keluar') {
                $barang->stok -= $mutasi->jumlah;
            } elseif ($mutasi->jenis_mutasi === 'pemindahan') {
                // Stok tetap sama, hanya lokasi yang berubah
            }
            
            $barang->save();

            // Catat riwayat stok
            RiwayatStok::create([
                'barang_id' => $barang->id,
                'mutasi_id' => $mutasi->id,
                'stok_sebelumnya' => $stokSebelumnya,
                'perubahan_stok' => $mutasi->jenis_mutasi === 'masuk' ? $mutasi->jumlah : -$mutasi->jumlah,
                'stok_sekarang' => $barang->stok,
                'tipe_perubahan' => 'mutasi_' . $mutasi->jenis_mutasi,
                'pengguna_id' => $request->user()->id,
                'keterangan' => $mutasi->keterangan,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mutasi barang berhasil ditambahkan',
                'data' => new MutasiBarangResource($mutasi)
            ], 201);
        });
    }

    public function show(MutasiBarang $mutasiBarang)
    {
        $mutasiBarang->load(['barang', 'pengguna', 'lokasiAsal', 'lokasiTujuan']);
        return new MutasiBarangResource($mutasiBarang);
    }

    public function update(MutasiBarangRequest $request, MutasiBarang $mutasiBarang)
    {
        if ($mutasiBarang->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya mutasi dengan status draft yang dapat diupdate'
            ], 422);
        }

        $mutasiBarang->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Mutasi barang berhasil diupdate',
            'data' => new MutasiBarangResource($mutasiBarang)
        ]);
    }

    public function destroy(MutasiBarang $mutasiBarang)
    {
        if ($mutasiBarang->status !== 'draft') {
            return response()->json([
                'success' => false,
                'message' => 'Hanya mutasi dengan status draft yang dapat dihapus'
            ], 422);
        }

        $mutasiBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mutasi barang berhasil dihapus'
        ]);
    }

    public function riwayatByPengguna(Request $request, $penggunaId)
    {
        $query = MutasiBarang::with(['barang', 'lokasiAsal', 'lokasiTujuan'])
            ->where('pengguna_id', $penggunaId)
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('nomor_referensi', 'like', "%$search%")
                    ->orWhereHas('barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', "%$search%");
                    });
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $mutasi = $query->paginate($request->input('per_page', 15));

        return new MutasiBarangCollection($mutasi);
    }
}
