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
        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 403);
        }

        $perkembangan = new Perkembangan($request->all());
        
        //jika ada gambar
        if ($request->has('gambar')) {
            //upload dan atur nama file
            $file_name = uniqid().str_slug($request->judul).'.jpg';
            $file_path = public_path().'/images/perkembangan';
            $request->file('gambar')->move($file_path, $file_name);

            $perkembangan->gambar = $file_name;
        } 

        if ($konten->perkembangan()->save($perkembangan)) {
            return response()->json(['message' => 'Perkembangan ditambahkan'],201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan penambahan perkembangan'], 404);
        }
    }
}
