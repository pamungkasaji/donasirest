<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Perpanjangan;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class AdminVerifikasiUserController extends Controller
{
    public function indexVerifikasi()
    {
        $user = User::where('is_verif',false)->get();

        return view('admin.user.indexVerifikasi', compact('user'));
    }

    public function showVerifikasi($id)
    {
        $user = User::where('is_verif',false)->find($id);
  
        return view('admin.verifikasi.showVerifikasi', compact('user'));
    }

    public function approve($id)
    {
        $user = User::where('is_verif',false)->find($id);

        
    }

    public function dissaprove($id)
    {

    }
}
