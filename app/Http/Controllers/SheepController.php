<?php

namespace App\Http\Controllers;

use App\Models\Sheep;
use App\Models\Pen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SheepController extends Controller
{
  /**
   * Display a listing of the sheep.
   */
  public function index(Request $request)
  {
    $query = Sheep::query();

    // Apply filters if provided
    if ($request->filled('search')) {
      $search = $request->input('search');
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('uid', 'like', "%{$search}%");
      });
    }

    if ($request->filled('gender')) {
      $query->where('gender', $request->input('gender'));
    }

    if ($request->filled('breed')) {
      $query->where('breed', $request->input('breed'));
    }

    if ($request->filled('health_status')) {
      $query->where('health_status', $request->input('health_status'));
    }

    if ($request->filled('pen_id')) {
      $query->where('pen_id', $request->input('pen_id'));
    }

    // Default sort by newest, but allow custom sorting
    $sortField = $request->input('sort', 'created_at');
    $sortDirection = $request->input('direction', 'desc');
    $query->orderBy($sortField, $sortDirection);

    $sheep = $query->paginate(10)->withQueryString();
    $pens = Pen::all();

    // Get unique breed values for the filter dropdown
    $breeds = Sheep::distinct()->pluck('breed')->filter();

    return view('dashboard.sheep.index', compact('sheep', 'pens', 'breeds'));
  }

  /**
   * Show the form for creating a new sheep.
   */
  public function create()
  {
      // Pastikan UID ada di cache
      $uid = Cache::get('rfid_uid');
    return view('dashboard.sheep.create');
  }

  /**
   * Store a newly created sheep in storage.
   */
  public function store(Request $request)
  {

     // Pastikan UID ada di cache
     $uid = Cache::get('rfid_uid');

    // Validate the request data
$validated = $request->validate([
    'uid' => 'required|string|max:255|unique:sheep,uid',
    'name' => 'required|string|max:255',
    'gender' => 'required|in:male,female',
    'birth_date' => 'required|date',
    'breed' => 'required|string',
    'weight' => 'required|numeric|min:0',
    'health_status' => 'required|in:Sehat,Sakit,Pemulihan,Karantina',
    'pen_id' => 'nullable|exists:pens,id',
    'last_check_date' => 'nullable|date',
    'last_vaccination_date' => 'nullable|date',
], [
    'uid.required' => 'UID wajib diisi.',
    'uid.string' => 'UID harus berupa teks.',
    'uid.max' => 'UID maksimal 255 karakter.',
    'uid.unique' => 'Tag sudah pernah digunakan.',
    'name.required' => 'Nama wajib diisi.',
    'gender.required' => 'Jenis kelamin wajib dipilih.',
    'gender.in' => 'Jenis kelamin harus laki-laki (male) atau perempuan (female).',
    'birth_date.required' => 'Tanggal lahir wajib diisi.',
    'birth_date.date' => 'Tanggal lahir harus berupa tanggal yang valid.',
    'breed.required' => 'Ras wajib diisi.',
    'weight.required' => 'Berat wajib diisi.',
    'weight.numeric' => 'Berat harus berupa angka.',
    'weight.min' => 'Berat minimal adalah 0.',
    'health_status.required' => 'Status kesehatan wajib dipilih.',
    'health_status.in' => 'Status kesehatan harus salah satu dari: Sehat, Sakit, Pemulihan, Karantina.',
    'pen_id.exists' => 'Kandang tidak valid.',
    'last_check_date.date' => 'Tanggal cek terakhir harus berupa tanggal yang valid.',
    'last_vaccination_date.date' => 'Tanggal vaksinasi terakhir harus berupa tanggal yang valid.',
]);
    // Create the sheep record
    $sheep = new Sheep($validated);

    // // Handle photo upload if provided
    // if ($request->hasFile('photo')) {
    //   $photoPath = $request->file('photo')->store('sheep-photos', 'public');
    //   $sheep->photo_path = $photoPath;
    // }

    $sheep->save();

    Cache::forget('rfid_uid');

    return redirect()->route('dashboard.sheep.index')
      ->with('success', 'Domba berhasil ditambahkan ke dalam sistem.');
  }

  /**
   * Display the specified sheep.
   */
  public function show(Sheep $sheep)
  {
    return view('dashboard.sheep.show', compact('sheep'));
  }

  /**
   * Show the form for editing the specified sheep.
   */
  public function edit($id)
  {
    $sheep = Sheep::findOrFail($id); 
    return view('dashboard.sheep.update', compact('sheep'));

  }

  /**
   * Update the specified sheep in storage.
   */
  public function update(Request $request, $id)
  {
        $sheep = Sheep::findOrFail($id);

        $validated = $request->validate([
            'uid' => 'required|string|max:255|unique:sheep,uid,' . $id,
            'name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'breed' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'health_status' => 'required|in:Sehat,Sakit,Pemulihan,Karantina',
            'pen_id' => 'nullable|exists:pens,id',
            'last_check_date' => 'nullable|date',
            'last_vaccination_date' => 'nullable|date',
        ]);

        $sheep->update($validated);

        return redirect()->route('dashboard.sheep.index')->with('success', 'Data domba berhasil diperbarui.');
  }

  /**
   * Remove the specified sheep from storage.
   */
  public function destroy(Sheep $sheep)
  {
    // Implementation for deleting a sheep
    $sheep->delete();
    return redirect()->route('dashboard.sheep.index')
      ->with('success', 'Domba berhasil dihapus dari sistem.');
  }

  /**
   * Display a search interface and handle RFID search.
   */
  public function search(Request $request)
  {
    $sheep = null;
    $searchPerformed = false;
    $uid = Cache::get('rfid_uid');

    if ($request->filled('uid')) {
      $searchPerformed = true;
      $uid = $request->input('uid');
      $sheep = Sheep::where('uid', $uid)->first();
    }

    return view('dashboard.sheep.search', compact('sheep', 'searchPerformed'));
  }
}