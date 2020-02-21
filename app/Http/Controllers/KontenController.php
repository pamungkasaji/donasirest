<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class KontenController extends Controller
{

    //protected $user;

    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store, update, delete');
    }

    public function index()
    {
        $konten = Konten::with('user')->where('is_verif',true)->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
            //'id_user' => 'required',
            'target' => 'required',
            'lama_donasi' => 'required',
            'gambar' => 'required',
            'nomorrekening' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi formulir dengan benar',
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();

        $konten = new Konten();

        //$judul_slug = str_slug($request->judul,"-");
        $file_name = str_slug($request->judul).'_konten_'.$request->id_user.'.jpg';
        $file_path = '../storage/images/konten';
        $path = $request->file('gambar')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/konten/'.$file_name);
        $konten->gambar = $urlgambar;

        //$konten->id_user = $request->id_user;
        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->target = $request->target;
        $konten->lama_donasi = $request->lama_donasi;
        $konten->nomorrekening = $request->nomorrekening;

        if ($user->konten()->save($konten)) {
            return response()->json([
                'success' => true,
                'message' => 'Tunggu verifikasi kami',
                'data' => $konten
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
            ], 404);
        }
    }

    public function show($id)
    {
        $konten = Konten::with('user')->where('is_verif',true)->find($id);
 
        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Penggalangan Dana tidak ditemukan'
            ], 400);
        }
     
        //return response()->json($konten,200);

        return response()->json([
            'success' => true,
            'message' => 'Detail konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function update(Request $request, $id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $konten = $user->konten()->find($id);
 
        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Konten penggalangan dana tidak ditemukan'
            ], 404);
        }

        if($request->has('is_verif')) {
            ($konten->update(['is_verif' => $request->is_verif]));
            return response()->json([
                'success' => true,
                'message' => 'Update berhasil',
                'data' => $konten
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan update',
            ], 500);
        }
    }

    public function destroy($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        //$konten = Konten::find($id);
        $konten = $user->konten()->find($id);
 
        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Konten penggalangan dana tidak ditemukan'
            ], 404);
        }
    
        if ($konten->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Konten penggalangan dana berhasil dihapus'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan penghapusan konten'
            ], 500);
        }
    }
}
