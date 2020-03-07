<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
use JWTAuth;

class UserKontenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.jwt');
    }

    public function index()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $konten = $user->konten()->with('user')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar konten penggalangan dana',
            'data' => $konten
        ],200);
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $konten = $user->konten()->with('user','perpanjangan')->find($id);
 
        if (!$konten) {
            return response()->json([
                'success' => false,
                'message' => 'Konten penggalangan dana tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail konten penggalangan dana',
            'konten' => $konten
        ],200);
    }
}
