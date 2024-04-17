<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\TransaksiDetailModel;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\UserModel;
use App\Models\StokModel;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar Transaksi',
            'list' => ['Home', 'Transaksi']
        ];

        $page = (object) [
            'title' => 'Daftar transaksi yang terdaftar dalam sistem'
        ];

        $activeMenu = 'transaksi';

        $users = UserModel::all();
        return view('transaksi.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $users]);
    }

    public function list(Request $request)
    {
        $transaksis = TransaksiModel::select('penjualan_id', 'penjualan_kode', 'user_id', 'pembeli', 'penjualan_tanggal')->with('user');

        if ($request->user_id) {
            $transaksis->where('user_id', $request->user_id);
        }


        return DataTables::of($transaksis)
            ->addIndexColumn()
            ->addColumn('aksi', function ($transaksi) {
                $btn = '<a href="' . url('/transaksi/' . $transaksi->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/transaksi/' . $transaksi->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/transaksi/' . $transaksi->penjualan_id) . '">' .
                    csrf_field() . method_field('DELETE') .
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Transaksi',
            'list' => ['Home', 'Transaksi', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Transaksi'
        ];

        $activeMenu = 'transaksi';

        $users = UserModel::all();
        $barang = BarangModel::all();

        return view('transaksi.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user' => $users, 'barang' => $barang]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'pembeli' => 'required|string|max:100',
        ]);

        $transaksi = new TransaksiModel();
        $transaksi->user_id = $request->user_id;
        $transaksi->pembeli = $request->pembeli;
        $transaksi->penjualan_kode = 'PJ-' . date('YmdHis');
        $transaksi->penjualan_tanggal = date('Y-m-d H:i:s');
        $transaksi->save();

        for ($i = 0; $i < count($request->barang_id); $i++) {
            $detail = new TransaksiDetailModel();
            $detail->penjualan_id = $transaksi->penjualan_id;
            $detail->barang_id = $request->barang_id[$i];
            $detail->jumlah = $request->jumlah[$i];

            $barang = BarangModel::find($request->barang_id[$i]);
            $detail->harga = $barang->harga_jual;

            $detail->save();

            StokModel::where('barang_id', $request->barang_id[$i])->decrement('stok_jumlah', $request->jumlah[$i]);
        }


        return redirect('/transaksi')->with('success', 'Data transaksi berhasil disimpan');
    }


    public function show($id)
    {
        $transaksi = TransaksiModel::with('user')->with('detail_penjualan')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi',
            'list' => ['Home', 'Transaksi', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Transaksi'
        ];

        $activeMenu = 'transaksi';

        return view('transaksi.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'transaksi' => $transaksi]);
    }

    public function edit($id)
    {
        $transaksi = TransaksiModel::with('user')->with('detail_penjualan')->find($id);

        $breadcrumb = (object) [
            'title' => 'Edit Transaksi',
            'list' => ['Home', 'Transaksi', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Transaksi'
        ];

        $activeMenu = 'transaksi'; //set menu yang aktif

        $barang = BarangModel::all();
        $users = UserModel::all();

        return view('transaksi.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'transaksi' => $transaksi, 'barang' => $barang, 'user' => $users]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'pembeli' => 'required|string|max:100',
        ]);

        $transaksi = TransaksiModel::find($id);
        $transaksi->user_id = $request->user_id;
        $transaksi->pembeli = $request->pembeli;
        $transaksi->save();

        $transaksi->detail_penjualan()->delete();

        for ($i = 0; $i < count($request->barang_id); $i++) {
            $detail = new TransaksiDetailModel();
            $detail->penjualan_id = $transaksi->penjualan_id;
            $detail->barang_id = $request->barang_id[$i];
            $detail->jumlah = $request->jumlah[$i];

            $barang = BarangModel::find($request->barang_id[$i]);
            $detail->harga = $barang->harga_jual;

            $detail->save();
            $barang->save();
        }

        return redirect('/transaksi')->with('success', 'Data transaksi berhasil diubah');
    }

    public function destroy($id)
    {
        $check = TransaksiModel::find($id);
        if (!$check) {
            return redirect('/transaksi')->with('error', 'Data transaksi tidak ditemukan');
        }

        try {
            TransaksiDetailModel::where('penjualan_id', $id)->delete();
            TransaksiModel::find($id)->delete();
            return redirect('/transaksi')->with('success', 'Data transaksi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/transaksi')->with('error', 'Data transaksi gagal dihapus ' . $e->getMessage());
        }
    }
}