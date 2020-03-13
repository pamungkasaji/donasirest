<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Perpanjangan;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class AdminVerifikasiController extends Controller
{
    public function index()
    {
        $konten = Konten::where('status','verifikasi')->get();

        $perpanjangan = Konten::whereHas('perpanjangan', function (Builder $query) {
            $query->where('status', 'verifikasi');
        })->with('perpanjangan')->get();

        return view('admin.verifikasi.index', compact('konten','perpanjangan'));
    }

    public function showKonten($id)
    {
        $konten = Konten::with('user')->find($id);
  
        return view('admin.verifikasi.showKonten', compact('konten'));
    }

    public function showPerpanjangan($id)
    {
        //$perpanjangan = Konten::with('perpanjangan')->find($id);
        $perpanjangan = Konten::with('perpanjangan','user')->find($id);

        // $donatur = $user->konten()
        // ->with('donatur')
        // ->get()
        // ->pluck('donatur')
        // ->collapse();
  
        return view('admin.verifikasi.showPerpanjangan', compact('perpanjangan'));
    }

    public function edit(Perpanjangan $perpanjangan)
    {
        //
    }

    public function update(Request $request, Perpanjangan $perpanjangan)
    {
        //
    }

    public function destroy(Perpanjangan $perpanjangan)
    {
        //
    }
}
