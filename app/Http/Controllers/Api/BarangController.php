<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangModel;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = BarangModel::with('kategori', 'stok')->get();

        return response()->json([
            'status_code' => 200,
            'data' => $barangs
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|unique:m_barang',
            'barang_nama' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $barang = BarangModel::create($request->all());

        return response()->json([
            'status_code' => 201,
            'data' => $barang
        ]);
    }

    public function show(BarangModel $barang)
    {
        $barang->load('kategori', 'stok');

        return response()->json([
            'status_code' => 200,
            'data' => $barang
        ]);
    }

    public function update(Request $request, BarangModel $barang)
    {
        $barang->update($request->all());

        return response()->json([
            'status_code' => 200,
            'data' => $barang
        ]);
    }

    public function destroy(BarangModel $barang)
    {
        $barang->delete();

        return response()->json([
            'status_code' => 204,
            'success' => true,
            'message' => 'Barang terhapus',
        ]);
    }
}
