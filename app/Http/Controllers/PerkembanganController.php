<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perkembangan;
use App\Konten;
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
            'message' => 'Daftar perkembangan penggalangan dana',
            'data' => $perkembangan
        ],200);
    }

    public function store(Request $request, Konten $konten)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lengkapi form perkembangan'], 422);
        }

        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }

        $perkembangan = new Perkembangan();

        if($request->has('gambar')) {
            //upload dan atur nama file
            $file_name = uniqid().str_slug($request->judul).'.jpg';
            $file_path = public_path().'/images/perkembangan';
            $request->file('gambar')->move($file_path, $file_name);
    
            $perkembangan->gambar = $file_name;
        }
        
        $perkembangan->judul = $request->judul;
        $perkembangan->deskripsi = $request->deskripsi;

        if ($konten->perkembangan()->save($perkembangan)) {
            $response = [
                'message' => "Perkembangan ditambahkan",
                'perkembangan' => $perkembangan
            ];
            return response()->json($response,201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan penambahan perkembangan'], 500);
        }
    }

    public function destroy(Konten $konten, $id)
    {
        $perkembangan = $konten->perkembangan()->find($id);

        if (!$perkembangan) {
            return response()->json(['message' => 'Perkembangan tidak ditemukan'], 404);
        }
    
        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }

        //cari path file
        $file_path = public_path().'/images/konten/'.$perkembangan->gambar;

        //hapus di record DB dan file gambar
        if ($perkembangan->delete() && unlink($file_path)) {
            return response()->json(['message' => 'Perkembangan berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan penghapusan perkembangan'], 500);
        }
    }
}
