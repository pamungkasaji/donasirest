<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Donatur;
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

        $donatur = $user->konten()
        ->with('donatur')
        ->get()
        ->pluck('donatur')
        ->collapse();

        if (!$donatur) {
            return response()->json([
                'success' => false,
                'message' => 'Daftar donatur tidak ditemukan'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'message' => 'Daftar donatur masuk',
            'data' => $donatur
        ],200);
    }

    public function show($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        //pilih satu
        $donatur = $user->konten()->with('donatur')->find($id);

        // $donatur = $user->konten()
        // ->with('donatur')
        // ->get()
        // ->pluck('donatur')
        // ->collapse();

        return $donatur;
    }
}
