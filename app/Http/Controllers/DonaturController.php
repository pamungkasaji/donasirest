<?php

namespace App\Http\Controllers;

use App\Konten;
use App\Donatur;
use App\Http\Resources\DonaturResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class DonaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('update, delete');
    }

    //mencari tahu apakan user memiliki akses ke konten
    public function haveAccess(Konten $konten) {
        $user = JWTAuth::parseToken()->authenticate();

        if (!$user->konten()->where('konten.id_user', $konten->id_user)->first()) {
            return false;
        } else {
            return true;
        }
    }

        // //mencari tahu apakan user memiliki akses ke konten
        // if (!$user->konten()->where('konten.id_user', $konten->id_user)->first()) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Anda tidak memiliki akses pada fitur ini'
        //     ], 403);
        // };

    public function index(Konten $konten) 
    {    
        //ambil daftar donatur yg sudah diterima
        $donatur = $konten->donatur()->where('is_diterima',true)->get();

        //ubah nama menjadi anonim untuk is_anonim true
        foreach($donatur as $key => $value) { 
            if ($donatur[$key]['is_anonim'] == true) {
                $donatur[$key]['nama'] = 'anonim';
            }
        }

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
            'donatur' => $donatur
        ],200);
    }

    public function update(Request $request, Konten $konten, $id)
    {
        if (!$donatur = $konten->donatur()->find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Donatur tidak ditemukan'
            ], 404);
        }

        //mencari tahu apakan user memiliki akses ke konten
        if( !$this->haveAccess($konten) ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        if($request->has('is_diterima')) {
            ($donatur->update(['is_diterima' => $request->is_diterima]));
            return response()->json([
                'success' => true,
                'message' => 'Validasi donatur berhasil',
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
        if (!$donatur = $konten->donatur()->find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Donatur tidak ditemukan'
            ], 404);
        }

        //mencari tahu apakan user memiliki akses ke konten
        if( !$this->haveAccess($konten) ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }
    
        if ($donatur->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Validasi donatur tidak diterima'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan validasi donatur'
            ], 500);
        }
    }
}
