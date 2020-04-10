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
    public function indexKonten()
    {
        $konten = Konten::where('status','verifikasi')->get();
        $konten_ditolak = Konten::where('status','ditolak')->get();

        return view('admin.verifikasi.indexKonten', compact('konten','konten_ditolak'));
    }

    public function showKonten($id)
    {
        $konten = Konten::with('user')->find($id);

        if (!$konten) {
            return redirect()->route('admin.verifikasi.indexKonten')
                        ->with('danger','Konten penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showKonten', compact('konten'));
    }

    public function approveKonten($id)
    {
        Konten::where('id', $id)->update(array('status' => 'aktif'));

        return redirect()->route('admin.verifikasi.indexKonten')
                        ->with('success','Verifikasi diterima');
    }

    public function disapproveKonten($id)
    {
        //Konten::where('id', $id)->delete();
        Konten::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.indexKonten')
                        ->with('warning','Verifikasi ditolak');
    }

    public function indexPerpanjangan()
    {
        $perpanjangan = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'verifikasi');
        })->with('perpanjangan')->get();
        $perpanjangan_ditolak = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'ditolak');
        })->with('perpanjangan')->get();

        return view('admin.verifikasi.indexPerpanjangan', compact('perpanjangan','perpanjangan_ditolak'));
    }

    public function showPerpanjangan($id)
    {
        $kontenPerpanjangan = Konten::with('perpanjangan','user')->find($id);

        if (!$kontenPerpanjangan) {
            return redirect()->route('admin.verifikasi.indexPerpanjangan')
                        ->with('danger','Perpanjangan penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showPerpanjangan', compact('kontenPerpanjangan'));
    }

    public function approvePerpanjangan($id)
    {
        //Perpanjangan::where('id', $id)->update(array('status' => 'diterima'));

        $perpanjangan = Perpanjangan::where('id', $id)->first();

        $konten = Konten::where('id',$perpanjangan->id_konten)->increment('lama_donasi', $perpanjangan->jumlah_hari);

        $perpanjangan->delete();

        return redirect()->route('admin.verifikasi.indexPerpanjangan')
                        ->with('success','Verifikasi perpanjangan diterima');
    }

    public function disapprovePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.indexPerpanjangan')
                        ->with('warning','Verifikasi perpanjangan ditolak');
    }

    public function indexUser()
    {
        $user = User::where('status','verifikasi')->get();
        $user_ditolak = User::where('status','ditolak')->get();

        return view('admin.verifikasi.indexUser', compact('user','user_ditolak'));
    }

    public function showUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.verifikasi.indexUser')
                        ->with('danger','Penggalang Dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showUser', compact('user'));
    }

    public function approveUser($id)
    {
        User::where('id', $id)->update(array('status' => 'diterima'));

        return redirect()->route('admin.verifikasi.indexUser')
                        ->with('success','Verifikasi diterima');
    }

    public function disapproveUser($id)
    {
        $user = User::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.indexUser')
                        ->with('success','Verifikasi ditolak');
    }

    //record dihapus
    // public function disapproveUser($id)
    // {
    //     User::where('id', $id)->delete();

    //     return redirect()->route('admin.verifikasi.index')
    //                     ->with('warning','Verifikasi ditolak');
    // }
}
