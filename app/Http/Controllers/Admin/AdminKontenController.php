<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Konten;
use App\Donatur;
use App\User;
use Illuminate\Http\Request;
use PDF;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Builder;

class AdminKontenController extends Controller
{
    public function index()
    {
        $kontens = Konten::where('status','aktif')->orWhere('status','selesai')->paginate(20);

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

    public function print($id){
        $konten = Konten::with('user')->find($id);
        $donatur = Donatur::where('id_konten', $id)->get();

        foreach($donatur as &$value) {
            $d = substr($value['created_at'],8,2);
            $m = substr($value['created_at'],5,2);
            $y = substr($value['created_at'],0,4);

            $value['created_at'] = $d.'-'.$m.'-'.$y;
        }

        $data['konten'] = $konten;
        $data['donatur'] = $donatur;

        $pdf = PDF::loadView('admin.konten.print', $data);
        return $pdf->download(str_slug($konten->judul).'.pdf');
	}
}
