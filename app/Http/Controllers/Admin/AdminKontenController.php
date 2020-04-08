<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Builder;

class AdminKontenController extends Controller
{
    public function index()
    {
        $kontens = Konten::where('status', '!=','verifikasi')->paginate(20);

        return view('admin.konten.index', compact('kontens'));
    }

    public function show($id)
    {
        $konten = Konten::with('user')->find($id);
  
        return view('admin.konten.show', compact('konten'));
    }

    public function nonaktif($id)
    {
        Konten::where('id', $id)->update(array('status' => 'selesai'));

        return redirect()->route('admin.konten.index')
                        ->with('warning','Konten penggalangan dana dinonaktifkan');
    }

    public function delete($id)
    {
        Konten::where('id', $id)->delete();

        return redirect()->route('admin.konten.index')
                        ->with('warning','Konten penggalangan dana dihapus');
    }
}
