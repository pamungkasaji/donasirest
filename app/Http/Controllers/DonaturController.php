<?php

namespace App\Http\Controllers;

use App\Konten;
use App\Donatur;
use App\Http\Resources\DonaturResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DonaturController extends Controller
{
    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function index(Konten $konten) 
    {    
        $donatur = $konten->donatur()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar donatur masuk',
            'data' => $donatur
        ],200);
    }

    public function store(Konten $konten, Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'is_anonim' => 'required',
            'jumlah' => 'required',
            'bukti' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi formulir dengan benar',
            ], 422);
        }

        $donatur = new Donatur();

        $file_name = str_slug($request->nama).'_donatur.jpg';
        $file_path = '../storage/images/donatur';
        $path = $request->file('bukti')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/donatur/'.$file_name);

        $donatur->nama = $request->nama;
        $donatur->is_anonim = $request->is_anonim;
        $donatur->jumlah = $request->jumlah;
        $donatur->bukti = $request->bukti;

        $donatur->bukti = $urlgambar;

        if ($konten->donatur()->save($donatur)) {
            $response = [
                'success' => true,
                'message' => "Tunggu verifikasi penggalang dana",
                'donatur' => $donatur
            ];
            return response()->json($response,201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan donasi',
            ], 404);
        }
    }

    public function show(Konten $konten, $id)
    {
        $donatur = $konten->donatur()->find($id);

        if (!$donatur) {
            return response()->json([
                'success' => false,
                'message' => 'Donatur tidak ditemukan'
            ], 400);
        }

        return response()->json([
            'message' => 'Informasi donatur',
            'success' => true,
            'data' => $donatur
        ],200);
    }

    public function update(Request $request, Konten $konten, $id)
    {
        $donatur = $konten->donatur()->find($id);

        if (!$donatur) {
            return response()->json([
                'success' => false,
                'message' => 'Donatur tidak ditemukan'
            ], 404);
        }

        if($request->has('is_diterima')) {
            ($donatur->update(['is_diterima' => $request->is_diterima]));
            return response()->json([
                'success' => true,
                'message' => 'Validasi donatur berhasil',
                'data' => $donatur
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi donatur',
            ], 500);
        }
    }

    public function destroy(Konten $konten, $id)
    {
        $donatur = $konten->donatur()->find($id);

        if (!$donatur) {
            return response()->json([
                'success' => false,
                'message' => 'Donatur tidak ditemukan'
            ], 404);
        }
    
        if ($donatur->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Validasi donatur tidak diterima'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan penghapusan konten'
            ], 500);
        }
    }
}
