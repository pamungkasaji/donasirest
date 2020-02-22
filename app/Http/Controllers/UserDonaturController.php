<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class UserDonaturController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $donatur = $user->konten()->donatur()->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar konten penggalangan dana',
            'data' => $donatur
        ],200);
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $donatur = $user->konten()->donatur()->find($id);
 
        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Penggalangan Dana tidak ditemukan'
            ], 400);
        }
     
        return response()->json([
            'success' => true,
            'message' => 'Detail konten penggalangan dana',
            'konten' => $konten
        ],200);
    }
}
