<?php

namespace App\Http\Controllers;

use App\Konten;
use App\Donatur;
use App\Http\Resources\DonaturResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use JWTAuth;
use File;

class DonaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('approve, disapprove, indexUser, showUser');
    }

    public function index(Konten $konten) 
    {    
        //ambil daftar donatur yg sudah diterima
        $donatur = $konten->donatur()->where('is_diterima',true)->latest()->get();

        //ubah nama menjadi anonim untuk is_anonim true
        foreach($donatur as $key => $value) { 
            if ($donatur[$key]['is_anonim'] == true) {
                $donatur[$key]['nama'] = 'anonim';
            }
        }

        return response()->json([
            'message' => 'Daftar donatur masuk',
            'data' => $donatur
        ],200);
    }

    public function store(Konten $konten, Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'is_anonim' => 'required',
            'jumlah' => 'required|integer',
            'bukti' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lengkapi formulir dengan benar'], 422);
        }

        $donatur = new Donatur();

        //upload dan atur nama file
        $file_name = uniqid().str_slug($request->nama).'.jpg';
        $file_path = public_path().'/images/donatur';
        $request->file('bukti')->move($file_path, $file_name);

        $donatur->bukti = $file_name;
        $donatur->nama = $request->nama;
        $donatur->is_anonim = $request->is_anonim;
        $donatur->jumlah = $request->jumlah;
        $donatur->nohp = $request->nohp;

        if ($konten->donatur()->save($donatur)) {
            $response = [
                'message' => "Tunggu verifikasi penggalang dana",
                'path' => $file_path,
                'donatur' => $donatur
            ];
            return response()->json($response,201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan donasi'], 500);
        }
    }

    public function show(Konten $konten, $id)
    {
        $donatur = $konten->donatur()->with('konten')->find($id);

        if (!$donatur) {
            return response()->json(['message' => 'Donatur tidak ditemukan'], 404);
        }

        return response()->json([
            'message' => 'Informasi donatur',
            'donatur' => $donatur
        ],200);
    }

    public function approve(Request $request, Konten $konten, $id)
    {
        if (!$donatur = $konten->donatur()->find($id)) {
            return response()->json(['message' => 'Donatur tidak ditemukan'], 404);
        }

        $user = auth('api')->authenticate();

        //mencari tahu apakan user memiliki akses ke konten
        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }

        if($request->has('is_diterima')) {
            ($donatur->update(['is_diterima' => $request->is_diterima]));
            $konten->increment('terkumpul', $donatur->jumlah);
            return response()->json(['message' => 'Validasi donatur berhasil'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan validasi donatur'], 500);
        }
    }

    public function disapprove(Konten $konten, $id)
    {
        if (!$donatur = $konten->donatur()->find($id)) {
            return response()->json(['message' => 'Donatur tidak ditemukan'], 404);
        }

        $user = auth('api')->authenticate();

        //mencari tahu apakan user memiliki akses ke konten
        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }
    
        //cari path file
        $file_path = public_path().'/images/donatur/'.$donatur->bukti;

        //hapus di record DB dan file gambar
        if ($donatur->delete() && unlink($file_path)) {
            return response()->json(['message' => 'Validasi donatur tidak diterima'], 200);

        } else {
            return response()->json(['message' => 'Terjadi kesalahan validasi donatur'], 500);
        }
    }

    public function indexUser()
    {
        $user = auth('api')->authenticate();

        $donatur = DB::table('donatur')
        ->select('konten.judul', 'donatur.*')
		->join('konten', 'konten.id', '=', 'donatur.id_konten')
		->join('users', 'users.id', '=', 'konten.id_user')
		->where('donatur.is_diterima' , false)
		->where('users.id', $user->id)
        ->orderBy('judul')
        ->first()
		->get(); 

        if (!$donatur) {
            return response()->json(['message' => 'Daftar donatur tidak ditemukan'], 404);
        }
        return response()->json([
            'message' => 'Daftar donatur masuk',
            'data' => $donatur
        ],200);
    }

    // public function showUser($id)
    // {
    //     $user = auth('api')->authenticate();

    //     //pilih satu
    //     $donatur = $user->konten()->with('donatur')->find($id);

    //     // $donatur = $user->konten()
    //     // ->with('donatur')
    //     // ->get()
    //     // ->pluck('donatur')
    //     // ->collapse();

    //     return $donatur;
    // }
}
