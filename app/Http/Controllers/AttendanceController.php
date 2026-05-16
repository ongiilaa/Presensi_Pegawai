<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // READ: Menampilkan semua data
    public function index()
    {
        $attendances = Attendance::orderBy('id', 'desc')->get();
        return view('attendance.index', compact('attendances'));
    }

    // CREATE: Menampilkan form tambah data
    public function create()
    {
        return view('attendance.create');
    }

    // STORE: Menyimpan data baru + Validasi ketat
    public function store(Request $request)
    {
        $request->validate([
            'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|numeric|unique:attendances,nip',
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'keterangan_kehadiran' => 'required|in:Hadir,Sakit,Izin,Dinas Luar'
        ], [
            'nama_pegawai.required' => 'Nama pegawai wajib diisi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.unique' => 'NIP ini sudah terdaftar di sistem.',
            'tanggal.required' => 'Tanggal presensi wajib diisi.',
            'jam_masuk.required' => 'Jam masuk wajib ditentukan.',
            'keterangan_kehadiran.required' => 'Pilih keterangan kehadiran yang valid.'
        ]);

        Attendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Data presensi berhasil ditambahkan!');
    }

    public function show(string $id) { // Kosongkan saja 
    }

    // EDIT: Menampilkan form edit berdasarkan data ID tertentu
    public function edit(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        return view('attendance.edit', compact('attendance'));
    }

    // UPDATE: Memperbarui data lama ke database + Validasi unik kecualikan ID ini
    public function update(Request $request, string $id)
    {
    // 1. Cari data berdasarkan ID
    $attendance = Attendance::findOrFail($id);

    // 2. Validasi (Sangat penting agar data tidak error saat masuk DB)
    $request->validate([
         'nama_pegawai' => 'required|string|max:255',
            'nip' => 'required|numeric|unique:attendances,nip,' . $id,
            'tanggal' => 'required|date',
            'jam_masuk' => 'required',
            'keterangan_kehadiran' => 'required|in:Hadir,Sakit,Izin,Dinas Luar'
        ], [
            'nama_pegawai.required' => 'Nama pegawai tidak boleh kosong.',
            'nip.required' => 'NIP tidak boleh kosong.',
            'nip.numeric' => 'NIP wajib berupa angka.',
            'nip.unique' => 'NIP sudah digunakan pegawai lain.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'jam_masuk.required' => 'Jam masuk wajib diisi.'
        ]);

    // 3. Eksekusi Perubahan
    $attendance->update($request->all());

    // 4. Kembali ke halaman utama dengan pesan sukses
    return redirect()->route('attendance.index')
                     ->with('success', 'DATABASE_UPDATED: Log berhasil diperbarui.');
}

    // DELETE: Menghapus data dari database
    public function destroy(string $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Data catatan kehadiran berhasil dihapus!');
    }
}