<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
//use JWTAuth;
//use Tymon\JWTAuth\Exceptions\JWTException;

class AuthApiController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
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

        $user = new User();
        
        $file_name = $request->username.'_ktp.jpg';
        $file_path = '../storage/images/ktp';
        $path = $request->file('fotoktp')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/ktp/'.$file_name);

        $user->namalengkap = $request->namalengkap;
        $user->alamat = $request->alamat;
        $user->nomorktp = $request->nomorktp;
        $user->nohp = $request->nohp;
        $user->fotoktp = $urlgambar;
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
        // if(!empty($request->input('new_password'))) {
        //     $new_password = bcrypt($request->input('new_password'));
        //     $user->password = $new_password;
        //     $user->save();
        // }

        $input = $request->only('username', 'password');
        $jwt_token = null;
 
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah',
            ], 401);
        }

        $username = $request->username;
        $usernamelogin = new UserResource(user::where('username', $username)->first());
 
        return response()->json([
            'success' => true,
            'user' => $usernamelogin,
            'token' => $jwt_token,
        ]);
    }
 
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], 500);
        }
    }
 
    public function getAuthUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);
 
        $user = JWTAuth::authenticate($request->token);
 
        return response()->json(['user' => $user]);
    }
}
