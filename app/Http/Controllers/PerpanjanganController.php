<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Konten;
use App\Perpanjangan;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class PerpanjanganController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store,destroy');
    }

    //admin
    public function index(Konten $konten) 
    {    
        //ambil daftar permintaan perpanjangan
        //$perpanjangan = $konten->perpanjangan()->where('is_request',true)->with('konten')->get();
        $perpanjangan = Perpanjangan::with('konten')-where('status', '=', 'verifikasi')->get();

        if (!$perpanjangan) {
            return response()->json([
                'success' => false,
                'message' => 'Penggalangan Dana tidak ditemukan'
            ], 400);
        }

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

        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses pada fitur ini'
            ], 403);
        }

        if ($konten->perpanjangan()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Perpanjangan sudah diajukan'
            ]);
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

    public function destroy(Konten $konten, $id)
    {
        if (!$perpanjangan = $konten->perpanjangan()->find($id)) {
            return response()->json([
                'success' => false,
                'message' => 'Perpanjangan tidak ditemukan'
            ], 404);
        }

        if ($perpanjangan->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Permintaan perpanjangan tidak diterima'
            ], 200);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan'
            ], 500);
        }
    }
}
