<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\PenggunaRequest;
use App\Http\Resources\Api\V1\PenggunaCollection;
use App\Http\Resources\Api\V1\PenggunaResource;
use App\Models\Pengguna;
use App\Models\MutasiBarang;
use App\Http\Resources\Api\V1\MutasiBarangCollection;
use Illuminate\Http\Request;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('nama_lengkap', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })
            ->when($request->has('role'), function ($query) use ($request) {
                $query->where('role', $request->role);
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        $pengguna = $query->paginate($request->input('per_page', 15));

        return new PenggunaCollection($pengguna);
    }

    public function show(Pengguna $pengguna)
    {
        return new PenggunaResource($pengguna);
    }

    public function update(PenggunaRequest $request, Pengguna $pengguna)
    {
        $data = $request->validated();
        
        if ($request->has('password')) {
            $data['password'] = Hash::make($data['password']);
        }

        $pengguna->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil diupdate',
            'data' => new PenggunaResource($pengguna)
        ]);
    }

    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();

        return response()->json([
            'success' => true,
            'message' => 'Pengguna berhasil dihapus'
        ]);
    }
    public function riwayatMutasi(Pengguna $pengguna, Request $request)
{
    $query = $pengguna->mutasiBarang()
        ->with(['barang', 'lokasiAsal', 'lokasiTujuan'])
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
