<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_verif = User::where('is_verif', true)->get();
        $user_not_verif = User::where('is_verif', false)->get();
        $konten_aktif = Konten::where('status', 'aktif')->get();
        $konten_selesai = Konten::where('status', 'selesai')->get();
        $konten_verifikasi = Konten::where('status', 'verifikasi')->get();
        $konten_ditolak = Konten::where('status', 'ditolak')->get();
        return view('admin.dashboard', compact('konten_aktif','konten_selesai','konten_ditolak','user_verif','user_not_verif'));
    }

    // public function index()
    // {
    //     return view('admin.dashboard');
    // }
}
