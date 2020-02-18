<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Perkembangan;
use App\Konten;
use App\Http\Resources\PerkembanganResource; 
use App\Http\Resources\KontenResource; 

class PerkembanganController extends Controller
{
    //
    public function index(Konten $konten)
    {
        //coba salah satu

        return PerkembanganResource::collection($konten->perkembangan);

        //belum dicoba
        //return PerkembanganResource::collection(Perkembangan::with('konten')->paginate(5));
        //return new PerkembanganResource(Perkembangan::with('user','kategori','perkembangan')->paginate(5));
        //return PerkembanganResource::collection(Perkembangan::paginate(5));
        
    }

    public function store(Request $request, Konten $konten)
    {
        //cara pendek, dengan resource
        $perkembangan = new Perkembangan($request->all());
        $konten->perkembangan()->save($perkembangan);

        return new PerkembanganResource($perkembangan);
        
    }

    public function show($id)
    {
        //coba salah satu

        return new PerkembanganResource(Perkembangan::with('user','perkembangan')->find($id));
        //return new PerkembanganResource($perkembangan);
    }

    public function update(Perkembangan $perkembangan, Request $request)
    {
        //
        $perkembangan->update($request->all());

        return new PerkembanganResource($perkembangan);
    }

    public function destroy(Perkembangan $perkembangan)
    {
        //
        $perkembangan->delete();

        return response()->json();
    }
}
