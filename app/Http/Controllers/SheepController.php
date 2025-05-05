<?php

namespace App\Http\Controllers;

use App\Models\Sheep;
use App\Models\Pen;
use Illuminate\Http\Request;

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
          ->orWhere('rfid', 'like', "%{$search}%");
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
    return view('dashboard.sheep.create');
  }

  /**
   * Store a newly created sheep in storage.
   */
  public function store(Request $request)
  {
    // Validate the request data
    $validated = $request->validate([
      'rfid' => 'required|string|unique:sheep,rfid',
      'name' => 'required|string|max:255',
      'gender' => 'required|in:male,female',
      'birth_date' => 'required|date',
      'breed' => 'required|string',
      'weight' => 'required|numeric|min:0',
      'health_status' => 'required|in:healthy,sick,recovering,quarantined',
      'pen_id' => 'nullable|exists:pens,id',
      'parent_sire' => 'nullable|string',
      'parent_dam' => 'nullable|string',
      'notes' => 'nullable|string',
      'last_check_date' => 'nullable|date',
      'last_vaccination_date' => 'nullable|date',
      'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Create the sheep record
    $sheep = new Sheep($validated);

    // Handle photo upload if provided
    if ($request->hasFile('photo')) {
      $photoPath = $request->file('photo')->store('sheep-photos', 'public');
      $sheep->photo_path = $photoPath;
    }

    $sheep->save();

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
  public function edit(Sheep $sheep)
  {
    return view('dashboard.sheep.edit', compact('sheep'));
  }

  /**
   * Update the specified sheep in storage.
   */
  public function update(Request $request, Sheep $sheep)
  {
    // Implementation for updating a sheep
  }

  /**
   * Remove the specified sheep from storage.
   */
  public function destroy(Sheep $sheep)
  {
    // Implementation for deleting a sheep
  }

  /**
   * Display a search interface and handle RFID search.
   */
  public function search(Request $request)
  {
    $sheep = null;
    $searchPerformed = false;

    if ($request->filled('rfid')) {
      $searchPerformed = true;
      $rfid = $request->input('rfid');
      $sheep = Sheep::where('rfid', $rfid)->first();
    }

    return view('dashboard.sheep.search', compact('sheep', 'searchPerformed'));
  }
}