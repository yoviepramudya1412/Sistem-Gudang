<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\KategoriBarangRequest;
use App\Http\Resources\Api\V1\KategoriBarangCollection;
use App\Http\Resources\Api\V1\KategoriBarangResource;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriBarang::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('nama_kategori', 'like', "%$search%")
                    ->orWhere('kode_kategori', 'like', "%$search%");
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        $kategori = $query->paginate($request->input('per_page', 15));

        return new KategoriBarangCollection($kategori);
    }

    public function store(KategoriBarangRequest $request)
{
    try {
        $kategori = KategoriBarang::create($request->validated());
        
        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat',
            'data' => new KategoriBarangResource($kategori)
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat kategori',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function show(KategoriBarang $kategoriBarang)
    {
        return new KategoriBarangResource($kategoriBarang);
    }

    public function update(KategoriBarangRequest $request, KategoriBarang $kategoriBarang)
    {
        $kategoriBarang->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Kategori barang berhasil diupdate',
            'data' => new KategoriBarangResource($kategoriBarang)
        ]);
    }

    public function destroy(KategoriBarang $kategoriBarang)
    {
        $kategoriBarang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori barang berhasil dihapus'
        ]);
    }
}
