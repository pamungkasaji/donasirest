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

        if (!$user->konten()->where('konten.id_user', $konten->id_user)->first()) {
            return response()->json(['message' => 'Anda tidak memiliki akses pada fitur ini'], 401);
        }

        if ($konten->lama_donasi != 0) {
            return response()->json(['message' => 'Anda belum bisa mengajukan perpanjangan'], 403);
        }
        if ($konten->terkumpul < $konten->target) {
            if ($konten->perpanjangan()->exists()) {
                return response()->json(['message' => 'Anda sudah mengajukan perpanjangan sebelumnya'], 403);
            }
        } else {
            return response()->json(['message' => 'Target penggalangan dana sudah terpenuhi. Anda tidak bisa mengajukan perpanjangan'], 403);
        }

        $perpanjangan = new Perpanjangan($request->all());

        if ($konten->perpanjangan()->save($perpanjangan)) {
            return response()->json(['message' => 'Permintaan perpanjangan dikirim'], 201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan permintaan perpanjangan'], 500);
        }
    }
}
