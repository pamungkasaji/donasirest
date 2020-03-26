<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Konten;
use App\Perpanjangan;
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class PerpanjanganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt')->only('store,destroy');
    }

    //admin
    public function index(Konten $konten) 
    {    
        $perpanjangan = Perpanjangan::with('konten')-where('status', '=', 'verifikasi')->get();

        if (!$perpanjangan) {
            return response()->json(['message' => 'Penggalangan Dana tidak ditemukan'], 400);
        }

        return response()->json([
            'message' => 'Daftar permintaan perpanjangan',
            'data' => $perpanjangan
        ],200);
    }

    public function store(Request $request, Konten $konten)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_hari' => 'required|integer',
            'alasan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lengkapi form perpanjangan',], 422);
        }

        $user = auth('api')->authenticate();

        if( !$user->konten()->where('konten.id_user', $konten->id_user)->first() ){
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }

        if ($konten->lama_donasi != 0) {
            return response()->json(['message' => 'Anda belum bisa mengajukan perpanjangan'], 403);
        } if ($konten->terkumpul < $konten->target) {
            if ($konten->perpanjangan()->exists()) {
                return response()->json(['message' => 'Anda sudah mengajukan perpanjangan sebelumnya'], 403);
            }
        } else {
            return response()->json(['message' => 'Target penggalangan dana sudah terpenuhi. Anda tidak bisa mengajukan perpanjangan'], 403);
        }

        $perpanjangan = new Perpanjangan($request->all());

        if ( $konten->perpanjangan()->save($perpanjangan) ) {
            $response = [
                'message' => "Permintaan perpanjangan dikirim",
                'perpanjangan' => $perpanjangan
            ];
            return response()->json($response,201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan permintaan perpanjangan'], 500);
        }
    }

    public function show(Konten $konten, $id)
    {
        $perpanjangan = $konten->perpanjangan()->with('konten')->find($id);

        if (!$perpanjangan) {
            return response()->json(['message' => 'Perpanjangan tidak ditemukan'], 400);
        }

        return response()->json([
            'message' => 'Informasi perpanjangan',
            'perpanjangan' => $perpanjangan
        ],200);
    }

    public function destroy(Konten $konten, $id)
    {
        if (!$perpanjangan = $konten->perpanjangan()->find($id)) {
            return response()->json(['message' => 'Perpanjangan tidak ditemukan'], 404);
        }

        if ($perpanjangan->delete()) {
            return response()->json(['message' => 'Permintaan perpanjangan tidak diterima'], 200);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 500);
        }
    }
}
