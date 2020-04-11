<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Konten;
use App\User;
use App\Perpanjangan;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $konten_verifikasi = Konten::where('status', 'verifikasi')->count();
        $konten_ditolak = Konten::where('status', 'ditolak')->count();

        $konten_aktif = Konten::where('status', 'aktif')->count();
        $konten_selesai = Konten::where('status', 'selesai')->count();

        $konten_terpenuhi = Konten::whereRaw('konten.terkumpul >= konten.target')->where('status', '=', 'aktif')->orWhere('status', '=', 'selesai')->count();
        $konten_belum_terpenuhi = Konten::whereRaw('konten.terkumpul <= konten.target')->where('status', '=', 'aktif')->orWhere('status', '=', 'selesai')->count();

        $user_verif = User::where('status', 'verifikasi')->count();
        $user_ditolak = User::where('status', 'ditolak')->count();
        $user_diterima = User::where('status', "diterima")->count();

        $perpanjangan_verif = Perpanjangan::where('status', 'verifikasi')->count();
        $perpanjangan_diterima = Perpanjangan::where('status', 'verifikasi')->count();
        $perpanjangan_ditolak = Perpanjangan::where('status', 'verifikasi')->count();

        return view('admin.dashboard')->with([
            'konten_aktif'=>$konten_aktif, 
            'konten_selesai'=>$konten_selesai,
            'konten_verifikasi'=>$konten_verifikasi,
            'konten_ditolak'=>$konten_ditolak,

            'konten_terpenuhi'=>$konten_terpenuhi,
            'konten_belum_terpenuhi'=>$konten_belum_terpenuhi,

            'user_verif'=>$user_verif,
            'user_ditolak'=>$user_ditolak,
            'user_diterima'=>$user_diterima,

            'perpanjangan'=>$perpanjangan_verif,
            'perpanjangan'=>$perpanjangan_diterima,
            'perpanjangan'=>$perpanjangan_ditolak,
            
            ]);
    }
}
