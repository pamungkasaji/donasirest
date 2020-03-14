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

        return view('admin.verifikasi.index', compact('konten','kontenPerpanjangan'));
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

        return redirect()->route('admin.verifikasi.index')
                        ->with('success','Verifikasi perpanjangan diterima');
    }

    public function disapprovePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.index')
                        ->with('warning','Verifikasi perpanjangan ditolak');
    }
}
