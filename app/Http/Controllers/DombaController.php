<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    
use App\Models\Domba;

class DombaController extends Controller
{

    
// Lihat semua domba
public function index()
{
    $domba = Domba::with('kandang')->get();
    return response()->json($domba);
}

// Tambah domba (misalnya dipanggil lewat MQTT listener)
public function store(Request $request)
{
    $validated = $request->validate([
        'nomor_tag' => 'required',
        'jenis_kelamin' => 'required|in:Jantan,Betina',
        'berat' => 'required|numeric',
        'id_kandang' => 'required|exists:kandang,id_kandang',
    ]);

    // Cek apakah domba dengan nomor_tag nya sudah ada
    $existing = Domba::where('nomor_tag', $validated['nomor_tag'])->first();

    if ($existing) {
        return response()->json([
            'message' => 'Domba dengan tag ini sudah terdaftar.',
            'data' => $existing
        ], 200); // Atau 409 kalau mau dianggap "conflict"
    }

    // Kalau belum ada, simpan
    $domba = Domba::create($validated);

    return response()->json([
        'message' => 'Domba berhasil ditambahkan.',
        'data' => $domba
    ], 201);
}


// Detail domba
public function show($id)
{
    $domba = Domba::with(['kandang', 'riwayatKesehatan', 'perkawinanSebagaiJantan', 'perkawinanSebagaiBetina'])
                  ->findOrFail($id);

    return response()->json($domba);
}

// Update data domba
public function update(Request $request, $id)
{
    $domba = Domba::findOrFail($id);

    $validated = $request->validate([
        'berat' => 'nullable|numeric',
        'id_kandang' => 'nullable|exists:kandang,id_kandang',
    ]);

    $domba->update($validated);
    return response()->json($domba);
}

// Hapus domba
public function destroy($id)
{
    $domba = Domba::findOrFail($id);
    $domba->delete();
    return response()->json(['message' => 'Domba berhasil dihapus']);
}
}