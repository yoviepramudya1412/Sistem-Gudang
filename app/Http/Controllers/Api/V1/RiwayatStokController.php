<?php

// app/Http/Controllers/Api/V1/RiwayatStokController.php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\RiwayatStokCollection;
use App\Http\Resources\Api\V1\RiwayatStokResource;
use App\Models\Barang;
use Illuminate\Http\Request;

class RiwayatStokController extends Controller
{
    public function riwayatByBarang(Request $request, $barangId)
    {
        $query = Barang::findOrFail($barangId)
            ->riwayatStok()
            ->with(['pengguna', 'mutasi'])
            ->when($request->has('search'), function ($query) use ($request) {
                $search = $request->search;
                $query->where('keterangan', 'like', "%$search%")
                    ->orWhere('tipe_perubahan', 'like', "%$search%");
            })
            ->when($request->has('tipe_perubahan'), function ($query) use ($request) {
                $query->where('tipe_perubahan', $request->tipe_perubahan);
            });

        if ($request->has('sort_by')) {
            $sortField = $request->sort_by;
            $sortDirection = $request->input('sort_dir', 'asc');
            $query->orderBy($sortField, $sortDirection);
        } else {
            $query->latest();
        }

        $riwayat = $query->paginate($request->input('per_page', 15));

        return new RiwayatStokCollection($riwayat);
    }
}