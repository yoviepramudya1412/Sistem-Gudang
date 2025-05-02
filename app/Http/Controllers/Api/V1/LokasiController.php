<?php


namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LokasiRequest;
use App\Http\Resources\Api\V1\LokasiCollection;
use App\Http\Resources\Api\V1\LokasiResource;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Lokasi::query()
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('nama_lokasi', 'like', "%$search%")
                    ->orWhere('kode_lokasi', 'like', "%$search%");
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        }

        $lokasi = $query->paginate($request->input('per_page', 15));

        return new LokasiCollection($lokasi);
    }

    public function store(LokasiRequest $request)
    {
        $lokasi = Lokasi::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil ditambahkan',
            'data' => new LokasiResource($lokasi)
        ], 201);
    }

    public function show(Lokasi $lokasi)
    {
        return new LokasiResource($lokasi);
    }

    public function update(LokasiRequest $request, Lokasi $lokasi)
    {
        $lokasi->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil diupdate',
            'data' => new LokasiResource($lokasi)
        ]);
    }

    public function destroy(Lokasi $lokasi)
    {
        $lokasi->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lokasi berhasil dihapus'
        ]);
    }
}
