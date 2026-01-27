<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\Participant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    public function index()
    {
        $regions = Region::all();
        return view('tambah-daerah', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $region = Region::create([
            'name' => $request->name,
        ]);

        return redirect()->route('tambah.daerah')->with('success', 'Daerah berhasil ditambahkan');
    }

    public function show($id)
    {
        $region = Region::with('participants', 'users')->findOrFail($id);
        $participants = $region->participants;

        return view('detail-daerah', compact('region', 'participants'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $region = Region::findOrFail($id);

        $region->update([
            'name' => $request->name,
        ]);

        return redirect()->route('detail.daerah', $region->id)->with('success', 'Daerah berhasil diperbarui');
    }

    public function destroy($id)
    {
        $region = Region::findOrFail($id);

        // Check if region has participants or users assigned
        if ($region->participants()->count() > 0 || $region->users()->count() > 0) {
            return redirect()->back()->withErrors(['error' => 'Daerah ini masih memiliki peserta atau user terkait dan tidak bisa dihapus']);
        }

        $region->delete();

        return redirect()->route('tambah.daerah')->with('success', 'Daerah berhasil dihapus');
    }
}
