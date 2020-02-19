<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
use Illuminate\Support\Facades\Validator;
// use JWTAuth;

class AdminKontenController extends Controller
{
    public function update(Request $request, $id)
    {

        $konten = Konten::find($id);

        $konten->is_verif = 1;

        $konten->save();

        // $konten = Konten::find($id);
 
        // if (!$konten) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Konten penggalangan dana tidak ditemukan'
        //     ], 404);
        // }

        // //if ($konten->update($request->input('is_verif'))) {

        // if ($konten->is_verif = $verifikasi) {
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'Update berhasil',
        //         'data' => $konten
        //     ], 200);
        // } else {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Terjadi kesalahan update',
        //     ], 500);
        // }

        // $konten->update($request->all());

        // return new KontenResource($konten);
    }
}
