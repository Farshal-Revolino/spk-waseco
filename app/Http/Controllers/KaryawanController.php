<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::orderBy('nama', 'ASC')->get();
        return view('karyawan.index', compact('karyawan'));
    }


    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:100',
            'tanggal_masuk' => 'nullable|date',
            'status' => 'required|in:aktif,non-aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/karyawan'), $filename);
            $data['foto'] = $filename;
        }

        Karyawan::create($data);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $karyawan = Karyawan::with(['penilaian', 'hasilPerhitungan'])->findOrFail($id);
        return view('karyawan.show', compact('karyawan'));
    }

    public function edit(string $id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, string $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $request->validate([
            'nik' => 'required|unique:karyawan,nik,' . $id,
            'nama' => 'required|string|max:255',
            'jabatan' => 'nullable|string|max:100',
            'unit_kerja' => 'nullable|string|max:100',
            'tanggal_masuk' => 'nullable|date',
            'status' => 'required|in:aktif,non-aktif',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('foto');

        if ($request->hasFile('foto')) {
            if ($karyawan->foto && file_exists(public_path('uploads/karyawan/' . $karyawan->foto))) {
                unlink(public_path('uploads/karyawan/' . $karyawan->foto));
            }

            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/karyawan'), $filename);
            $data['foto'] = $filename;
        }

        $karyawan->update($data);

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        if ($karyawan->foto && file_exists(public_path('uploads/karyawan/' . $karyawan->foto))) {
            unlink(public_path('uploads/karyawan/' . $karyawan->foto));
        }

        $karyawan->delete();

        return redirect()->route('karyawan.index')
            ->with('success', 'Data karyawan berhasil dihapus');
    }
}