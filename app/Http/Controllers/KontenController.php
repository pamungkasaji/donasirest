<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class KontenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store, indexUser, showUser');
    }

    public function index()
    {
        $konten = Konten::with('user')->where('status', '!=', 'verifikasi')->where('status', '!=', 'ditolak')->get();

        foreach ($konten as $k) {
            $k->links = [
                'donatur' => 'konten/' . $k->id . '/donatur',
                'perkembangan' => 'konten/' . $k->id . '/perkembangan'
            ];
        }

        return response()->json([
            'message' => 'Daftar konten donasi',
            'data' => $konten
        ], 200);
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
        $file_name = uniqid() . str_slug($request->judul) . '.jpg';
        $file_path = public_path() . '/images/konten';
        $request->file('gambar')->move($file_path, $file_name);

        $konten->gambar = $file_name;
        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->target = $request->target;
        $konten->lama_donasi = $request->lama_donasi;
        $konten->nomorrekening = $request->nomorrekening;
        $konten->bank = $request->bank;

        if ($user->konten()->save($konten)) {
            return response()->json(['message' => 'Tunggu verifikasi kami'], 201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }

    //pencarian berdasarkan judul
    public function showByJudul($judul)
    {
        $konten = Konten::where([
            ['judul', 'LIKE', '%' . $judul . '%'],
            ['status', '!=', 'verifikasi'],
            ['status', '!=', 'ditolak']
        ])
        ->with('user')
        ->get();

        return response()->json([
            'message' => 'Daftar konten donasi',
            'data' => $konten
        ], 200);
    }

    //daftar konten donasi yang dibuat user
    public function indexUser()
    {
        $user = auth('api')->authenticate();

        $konten = $user->konten()->with('user')->get();

        return response()->json([
            'message' => 'Daftar konten donasi user',
            'data' => $konten
        ], 200);
    }

    //detail konten donasi yang dibuat user
    public function isUser($id)
    {
        $user = auth('api')->authenticate();

        $konten = $user->konten()->with('user', 'perpanjangan')->find($id);

        if (!$konten) {
            return response()->json(['message' => 'Bukan penggalang dana'], 404);
        }

        return response()->json([
            'message' => 'Detail konten penggalangan dana',
            'konten' => $konten
        ], 200);
    }
}
