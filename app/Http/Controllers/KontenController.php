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
        $this->middleware('auth.jwt')->only('store, update, delete, indexUser, showUser');
    }

    public function index()
    {
        $konten = Konten::with('user')->where('status', '!=', 'verifikasi')->where('status', '!=', 'ditolak')->get();

        return response()->json([
            'message' => 'Daftar konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required',
            'deskripsi' => 'required',
            'target' => 'required',
            'lama_donasi' => 'required|integer',
            'gambar' => 'required',
            'nomorrekening' => 'required',
            'bank' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lengkapi formulir dengan benar'], 422);
        }

        $user = auth('api')->authenticate();

        $konten = new Konten();

        //upload dan atur nama file
        $file_name = uniqid().str_slug($request->judul).'.jpg';
        $file_path = public_path().'/images/konten';
        $request->file('gambar')->move($file_path, $file_name);

        $konten->gambar = $file_name;
        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->target = $request->target;
        $konten->lama_donasi = $request->lama_donasi;
        $konten->nomorrekening = $request->nomorrekening;
        $konten->bank = $request->bank;

        if ($user->konten()->save($konten)) {
            return response()->json([
                'message' => 'Tunggu verifikasi kami',
                'konten' => $konten
            ], 201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    public function show($id)
    {
        $konten = Konten::with('user')->where('status', '!=', 'verifikasi')->find($id);
 
        if (!$konten) {
            return response()->json(['message' => 'Penggalangan Dana tidak ditemukan'], 404);
        }
     
        //return response()->json($konten,200);

        return response()->json([
            'message' => 'Detail konten penggalangan dana',
            'konten' => $konten
        ],200);
    }

    public function update(Request $request, $id)
    {
        $user = auth('api')->authenticate();

        $konten = $user->konten()->find($id);
 
        if (!$konten) {
            return response()->json(['message' => 'Konten penggalangan dana tidak ditemukan'], 404);
        }

        if($request->has('status')) {
            ($konten->update(['status' => $request->status]));
            return response()->json([
                'message' => 'Update berhasil',
                'konten' => $konten
            ], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan update'], 500);
        }
    }

    public function destroy($id)
    {
        $user = auth('api')->authenticate();

        //$konten = Konten::find($id);
        $konten = $user->konten()->find($id);
 
        if (!$konten) {
            return response()->json(['message' => 'Konten penggalangan dana tidak ditemukan'], 404);
        }

        //cari path file
        $file_path = public_path().'/images/konten/'.$konten->gambar;
    
        //hapus di record DB dan file gambar
        if ($konten->delete() && unlink($file_path)) {
            return response()->json(['message' => 'Konten penggalangan dana berhasil dihapus'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan penghapusan konten'], 500);
        }
    }

    //pencarian berdasarkan judul
    public function showByJudul($judul)
    {
        $konten = Konten::where([
            ['judul', 'LIKE', '%'.$judul.'%'],
            ['status', '!=', 'verifikasi']])
            ->get();

        return response()->json([
            'message' => 'Daftar konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function indexUser()
    {
        $user = auth('api')->authenticate();

        $konten = $user->konten()->with('user')->get();

        return response()->json([
            'message' => 'Daftar konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function showUser($id)
    {
        $user = auth('api')->authenticate();

        $konten = $user->konten()->with('user','perpanjangan')->find($id);
 
        if (!$konten) {
            return response()->json(['message' => 'Konten penggalangan dana tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Detail konten penggalangan dana',
            'konten' => $konten
        ],200);
    }
}
