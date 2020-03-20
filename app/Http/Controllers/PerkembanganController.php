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

    public function index(Konten $konten)
    {
        $perkembangan = $konten->perkembangan()->orderBy('created_at', 'desc')->get();

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

        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        $perkembangan = new Perkembangan();

        //upload dan atur nama file
        $file_name = uniqid().str_slug($request->judul).'.jpg';
        $file_path = public_path().'/images/perkembangan';
        $request->file('gambar')->move($file_path, $file_name);

        $perkembangan->gambar = $file_name;
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
    
        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        //cari path file
        $file_path = public_path().'/images/konten/'.$perkembangan->gambar;

        //hapus di record DB dan file gambar
        if ($perkembangan->delete() && unlink($file_path)) {
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
