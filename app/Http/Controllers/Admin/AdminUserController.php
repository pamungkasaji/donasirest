<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Konten;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'diterima')->paginate(20);

        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);
        
        $konten = DB::table('konten')
        ->where('id_user', '=', $user->id)
        ->where(function ($query) {
            $query->where('status','=','aktif')
                  ->orWhere('status','=','selesai');
        })
        ->get();
  
        return view('admin.user.show', compact('user','konten'));
    }

    public function delete($id)
    {
        $user = User::find($id);

        //cari path file untuk menghapus gambar
        $file_path = public_path() . '/images/ktp/' . $user->fotoktp;

        //hapus file dan record db
        unlink($file_path);
        $user->delete();

        return redirect()->route('admin.user.index')
                        ->with('warning','Akun penggalang dana dihapus');
    }
}
