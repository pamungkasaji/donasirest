<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
// use JWTAuth;

class KontenController extends Controller
{

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function index()
    {
        $konten = Konten::with('user')->get();
 
        //return response()->json($konten,200);

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
            'id_user' => 'required',
            'target' => 'required',
            'lama_donasi' => 'required',
            'nomorrekening' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi formulir dengan benar',
            ], 422);
        }

        $konten = new Konten();

        //$judul_slug = str_slug($request->judul,"-");
        $file_name = str_slug($request->judul,"-").'_'.$request->id_user.'.jpg';
        $file_path = '../storage/images/konten';
        $path = $request->file('gambar')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/konten/'.$file_name);
        $konten->gambar = $urlgambar;

        $konten->id_user = $request->id_user;
        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->target = $request->target;
        $konten->lama_donasi = $request->lama_donasi;
        $konten->nomorrekening = $request->nomorrekening;

        if ($konten->save()) {
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
        $konten = Konten::with('user')->find($id);
 
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

        //cara pendek
        //return Konten::with('user')->find($id);
    }

    public function update(Request $request, $id)
    {
        // $konten = Konten::find($id);
 
        // if (!$konten) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Konten penggalangan dana tidak ditemukan'
        //     ], 404);
        // }

        // //if ($konten->update($request->input('is_verif'))) {

        // if ($konten->is_verif = $verifikasi) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Update berhasil',
        //         'data' => $konten
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Terjadi kesalahan update',
        //     ], 500);
        // }

        // $konten->update($request->all());

        // return new KontenResource($konten);
    }

    public function destroy($id)
    {
        $konten = Konten::find($id);
 
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
                'message' => 'Konten penggalangan dana tidak dapat dihapus'
            ], 500);
        }

        // $konten->delete();

        // return response()->json();
    }
}
