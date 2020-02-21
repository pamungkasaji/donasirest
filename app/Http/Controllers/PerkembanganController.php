<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perkembangan;
use App\Konten;
use App\Http\Resources\PerkembanganResource; 
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class PerkembanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store, delete');
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

    public function index(Konten $konten)
    {
        $perkembangan = $konten->perkembangan()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar perkembangan penggalangan dana',
            'data' => $perkembangan
        ],200);
    }

    public function store(Request $request, Konten $konten)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'gambar' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi form perkembangan',
            ], 422);
        }

        if( !$this->haveAccess($konten) ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        $file_name = str_slug($request->judul).'_perkembangan.jpg';
        $file_path = '../storage/images/perkembangan';
        $path = $request->file('gambar')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/perkembangan/'.$file_name);

        $perkembangan = new Perkembangan();

        $perkembangan->gambar = $urlgambar;
        $perkembangan->judul = $request->judul;
        $perkembangan->deskripsi = $request->deskripsi;

        if ($konten->perkembangan()->save($perkembangan)) {
            $response = [
                'success' => true,
                'message' => "Perkembangan ditambahkan",
                'perkembangan' => $perkembangan
            ];
            return response()->json($response,201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan penambahan perkembangan',
            ], 404);
        }
    }

    public function destroy(Konten $konten, $id)
    {
        $perkembangan = $konten->perkembangan()->find($id);

        if (!$perkembangan) {
            return response()->json([
                'success' => false,
                'message' => 'Perkembangan tidak ditemukan'
            ], 404);
        }
    
        //mencari tahu apakan user memiliki akses ke konten
        if( !$this->haveAccess($konten) ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        if ($perkembangan->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Perkembangan berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan penghapusan perkembangan'
            ], 500);
        }
    }
}
