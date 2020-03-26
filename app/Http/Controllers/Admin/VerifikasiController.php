<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Perpanjangan;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class VerifikasiController extends Controller
{
    public function index()
    {
        $konten = Konten::where('status','verifikasi')->get();

        $kontenPerpanjangan = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'verifikasi');
        })->with('perpanjangan')->get();
        
        //$perpanjangan = Perpanjangan::where('status','verifikasi')->with('konten')->get();

        $user = User::where('is_verif',false)->get();

        return view('admin.verifikasi.index', compact('konten','kontenPerpanjangan','user'));
    }

    public function showKonten($id)
    {
        $konten = Konten::with('user')->find($id);

        if (!$konten) {
            return redirect()->route('admin.verifikasi.index')
                        ->with('danger','Konten penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.kontenShow', compact('konten'));
    }

    public function showPerpanjangan($id)
    {
        $kontenPerpanjangan = Konten::with('perpanjangan','user')->find($id);

        if (!$kontenPerpanjangan) {
            return redirect()->route('admin.verifikasi.index')
                        ->with('danger','Perpanjangan penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.perpanjanganShow', compact('kontenPerpanjangan'));
    }

    public function showUser($id)
    {
        $user = User::where('is_verif',false)->find($id);

        if (!$user) {
            return redirect()->route('admin.verifikasi.index')
                        ->with('danger','Penggalang Dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.userShow', compact('user'));
    }

    public function approveKonten($id)
    {
        Konten::where('id', $id)->update(array('status' => 'aktif'));

        return redirect()->route('admin.verifikasi.index')
                        ->with('success','Verifikasi diterima');
    }

    public function disapproveKonten($id)
    {
        //Konten::where('id', $id)->delete();
        Konten::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.index')
                        ->with('warning','Verifikasi ditolak');
    }

    public function approvePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->update(array('status' => 'diterima'));

        $perpanjangan = Perpanjangan::where('id', $id)->first();

        $konten = Konten::where('id',$perpanjangan->id_konten)->increment('lama_donasi', $perpanjangan->jumlah_hari);

        return redirect()->route('admin.verifikasi.index')
                        ->with('success','Verifikasi perpanjangan diterima');
    }

    public function disapprovePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.index')
                        ->with('warning','Verifikasi perpanjangan ditolak');
    }

    public function approveUser($id)
    {
        User::where('id', $id)->update(array('is_verif' => true));

        return redirect()->route('admin.verifikasi.index')
                        ->with('success','Verifikasi diterima');
    }

    // public function disaproveUser($id)
    // {
    //     $user = User::where('id', $id)->update(array('is_verif' => false));

    //     return redirect()->route('admin.verifikasi.index')
    //                     ->with('success','Verifikasi ditolak');
    // }

    //record dihapus
    public function disapproveUser($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('admin.verifikasi.index')
                        ->with('warning','Verifikasi ditolak');
    }
}
