<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerpanjanganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store');
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
        //ambil daftar permintaan perpanjangan
        $perpanjangan = $konten->perpanjangan()->where('is_request',true)->with('konten')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar permintaan perpanjangan',
            'data' => $perpanjangan
        ],200);
    }

    public function store(Request $request, Konten $konten)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_hari' => 'required',
            'alasan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi form perpanjangan',
            ], 422);
        }

        if( !$this->haveAccess($konten) ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        $perpanjangan = new Perpanjangan($request->all());

        if ( $konten->perpanjangan()->save($perpanjangan) ) {
            $response = [
                'success' => true,
                'message' => "Permintaan perpanjangan dikirim",
                'perpanjangan' => $perpanjangan
            ];
            return response()->json($response,201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan permintaan perpanjangan',
            ], 404);
        }
    }

    public function show(Konten $konten, $id)
    {
        $perpanjangan = $konten->perpanjangan()->with('konten')->find($id);

        if (!$perpanjangan) {
            return response()->json([
                'success' => false,
                'message' => 'Perpanjangan tidak ditemukan'
            ], 400);
        }

        return response()->json([
            'message' => 'Informasi perpanjangan',
            'success' => true,
            'perpanjangan' => $perpanjangan
        ],200);
    }
}
