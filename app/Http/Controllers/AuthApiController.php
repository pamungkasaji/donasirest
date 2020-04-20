<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthApiController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required|string|min:6',
            'namalengkap' => 'required|string',
            'alamat' => 'required',
            'nomorktp' => 'required',
            'nohp' => 'required',
            'fotoktp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Lengkapi formulir dengan benar'], 422);
        }

        if ($user = User::where('username', $request->username)->first()) {
            return response()->json(['message' => 'Username sudah digunakan'], 409);
        }

        $user = new User();

        //upload dan atur nama file
        $file_name = uniqid() . str_slug($request->namalengkap) . '.jpg';
        $file_path = public_path() . '/images/ktp';
        $request->file('fotoktp')->move($file_path, $file_name);

        $user->fotoktp = $file_name;
        $user->namalengkap = $request->namalengkap;
        $user->alamat = $request->alamat;
        $user->nomorktp = $request->nomorktp;
        $user->nohp = $request->nohp;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json(['message' => 'Tunggu verifikasi kami'], 201);
        } else {
            return response()->json(['message' => 'Terjadi kesalahan'], 404);
        }
    }

    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $jwt_token = null;

        if (!$jwt_token = auth('api')->attempt($input)) {
            return response()->json(['message' => 'Username atau password salah'], 401);
        }

        $user = User::where('username', $request->username)->first();

        if ($user->status == 'diterima') {
            return response()->json([
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $jwt_token,
            ]);
        } else if ($user->status == 'verifikasi') {
            return response()->json(['message' => 'Silahkan tunggu verifikasi admin'], 403);
        } else {
            return response()->json(['message' => 'Verifikasi anda ditolak'], 403);
        }
    }

    public function logout()
    {
        try {
            auth('api')->invalidate();

            return response()->json(['message' => 'Berhasil logout'], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'message' => 'Logout gagal'
            ], 500);
        }
    }
}
