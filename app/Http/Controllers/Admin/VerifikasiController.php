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
        $konten = Konten::where('status','verifikasi')->paginate(20, ['*'], 'konten');
        $konten_ditolak = Konten::where('status','ditolak')->paginate(20, ['*'], 'konten_ditolak');

        return view('admin.verifikasi.indexKonten', compact('konten','konten_ditolak'));
    }

    public function showKonten($id)
    {
        $konten = Konten::with('user')->find($id);

        if (!$konten) {
            return redirect()->route('admin.verifikasi.konten.index')
                        ->with('danger','Konten penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showKonten', compact('konten'));
    }

    public function approveKonten($id)
    {
        Konten::where('id', $id)->update(array('status' => 'aktif'));

        return redirect()->route('admin.verifikasi.konten.index')
                        ->with('success','Verifikasi diterima');
    }

    public function disapproveKonten($id)
    {
        //Konten::where('id', $id)->delete();
        Konten::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.konten.index')
                        ->with('warning','Verifikasi ditolak');
    }

    public function deleteKonten($id)
    {
        $konten = Konten::where('id', $id)->first();

        //mencari file gambar untuk dihapus
        $file_path = public_path().'/images/konten/'.$konten->gambar;

        if ($konten->delete() && unlink($file_path)) {
            return redirect()->route('admin.verifikasi.konten.index')
                            ->with('warning','Konten donasi dihapus');
        } else {
            redirect()->route('admin.verifikasi.konten.index')
                        ->with('danger','Konten donasi gagal dihapus');
        }
    }

    //daftar konten yang memiliki perpanjangan
    public function indexPerpanjangan()
    {
        $perpanjangan = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'verifikasi');
        })->with('perpanjangan')->paginate(20, ['*'], 'perpanjangan');
        $perpanjangan_ditolak = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'ditolak');
        })->with('perpanjangan')->paginate(20, ['*'], 'perpanjangan_ditolak');

        return view('admin.verifikasi.indexPerpanjangan', compact('perpanjangan','perpanjangan_ditolak'));
    }

    public function showPerpanjangan($id)
    {
        $kontenPerpanjangan = Konten::with('perpanjangan','user')->find($id);

        if (!$kontenPerpanjangan) {
            return redirect()->route('admin.verifikasi.perpanjangan.index')
                        ->with('danger','Perpanjangan penggalangan dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showPerpanjangan', compact('kontenPerpanjangan'));
    }

    public function approvePerpanjangan($id)
    {
        $perpanjangan = Perpanjangan::where('id', $id)->first();

        $konten = Konten::where('id',$perpanjangan->id_konten)->increment('lama_donasi', $perpanjangan->jumlah_hari);

        $konten->update(array('status' => 'aktif'));

        $perpanjangan->delete();

        return redirect()->route('admin.verifikasi.perpanjangan.index')
                        ->with('success','Verifikasi perpanjangan diterima');
    }

    public function disapprovePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.perpanjangan.index')
                        ->with('warning','Verifikasi perpanjangan ditolak');
    }

    public function deletePerpanjangan($id)
    {
        Perpanjangan::where('id', $id)->delete();

        return redirect()->route('admin.verifikasi.perpanjangan.index')
                        ->with('warning','Permintaan perpanjangan dihapus');
    }

    public function indexUser()
    {
        $user = User::where('status','verifikasi')->paginate(20, ['*'], 'user');
        $user_ditolak = User::where('status','ditolak')->paginate(20, ['*'], 'user_ditolak');

        return view('admin.verifikasi.indexUser', compact('user','user_ditolak'));
    }

    public function showUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('admin.verifikasi.user.index')
                        ->with('danger','Penggalang Dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.showUser', compact('user'));
    }

    public function approveUser($id)
    {
        User::where('id', $id)->update(array('status' => 'diterima'));

        return redirect()->route('admin.verifikasi.user.index')
                        ->with('success','Verifikasi diterima');
    }

    public function disapproveUser($id)
    {
        $user = User::where('id', $id)->update(array('status' => 'ditolak'));

        return redirect()->route('admin.verifikasi.user.index')
                        ->with('success','Verifikasi ditolak');
    }

    public function deleteUser($id)
    {
        $user = User::where('id', $id)->first();

        //mencari file gambar untuk dihapus
        $file_path = public_path().'/images/ktp/'.$user->fotoktp;

        if ($user->delete() && unlink($file_path)) {
            return redirect()->route('admin.verifikasi.user.index')
                            ->with('warning','Data verifikasi user dihapus');
        } else {
            redirect()->route('admin.verifikasi.user.index')
                        ->with('danger','Data verifikasi user gagal dihapus');
        }
    }
}
