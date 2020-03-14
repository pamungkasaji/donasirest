<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Perpanjangan;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class VerifikasiUserController extends Controller
{
    public function index()
    {
        $user = User::where('is_verif',false)->get();

        return view('admin.verifikasi.userIndex', compact('user'));
    }

    public function show($id)
    {
        $user = User::where('is_verif',false)->find($id);

        if (!$user) {
            return redirect()->route('admin.verifikasi.user.index')
                        ->with('danger','Penggalang Dana tidak ditemukan');
        }
  
        return view('admin.verifikasi.userShow', compact('user'));
    }

    public function approve($id)
    {
        User::where('id', $id)->update(array('is_verif' => true));

        return redirect()->route('admin.verifikasi.user.index')
                        ->with('success','Verifikasi diterima');
    }

    // public function disaprove($id)
    // {
    //     $user = User::where('id', $id)->update(array('is_verif' => false));

    //     return redirect()->route('admin.verifikasi.user.index')
    //                     ->with('success','Verifikasi tidak ditolak');
    // }

    //record dihapus
    public function disapprove($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('admin.verifikasi.user.index')
                        ->with('warning','Verifikasi ditolak');
    }
}
