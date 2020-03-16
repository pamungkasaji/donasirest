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
            'password' => 'required|string|min:6|max:20',
            'namalengkap' => 'required',
            'alamat' => 'required',
            'nomorktp' => 'required',
            'nohp' => 'required',
            'fotoktp' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Lengkapi formulir dengan benar',
            ], 422);
        }

        if($user = User::where('username',$request->username)->first()) {
            return response()->json([
                'success' => false,
                'message' => 'Username sudah digunakan',
            ], 422);
        }

        $user = new User();

        //upload dan atur nama file
        $file_name = uniqid().str_slug($request->namalengkap).'.jpg';
        $file_path = public_path().'/images/ktp';
        $request->file('fotoktp')->move($file_path, $file_name);

        $user->fotoktp = $file_name;
        $user->namalengkap = $request->namalengkap;
        $user->alamat = $request->alamat;
        $user->nomorktp = $request->nomorktp;
        $user->nohp = $request->nohp;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Tunggu verifikasi kami',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan',
            ], 404);
        }
    }
 
    public function login(Request $request)
    {
        $input = $request->only('username', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = auth('api')->attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        if ($user = User::where( [['username', $request->username], ['is_verif', 1]] )->first()) {
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => $user,
                'token' => $jwt_token,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan tunggu verifikasi admin',
            ], 401);
        }
    }
 
    public function logout(Request $request)
    {
        try {
            auth('api')->invalidate();
 
            return response()->json([
                'success' => true,
                'message' => 'Berhasil logout'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal'
            ], 500);
        }
    }
 
    public function getAuthUser(Request $request)
    {
        try {
            $user = auth('api')->authenticate();
            return response()->json([
                'success' => true,
                'message' => 'Data user',
                'user' => $user
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Data user gagal diperoleh'
            ], 500);
        }

    }
}
