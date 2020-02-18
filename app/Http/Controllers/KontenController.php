<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Konten;
use App\Http\Resources\KontenResource; 
// use JWTAuth;

class KontenController extends Controller
{

    // public function __construct()
    // {
    //     $this->user = JWTAuth::parseToken()->authenticate();
    // }

    public function index()
    {
        //coba salah satu
        //$products = auth()->user()->products;
        
        $konten = Konten::with('user')->get();
 
        return response()->json($konten,200);

        // $pages = Page::all();;

        // return Response::json(array(
        //     'status' => 'success',
        //     'pages' => $pages->toArray()),
        //     200
        // );

        //return KontenResource::collection(Konten::with('user','perkembangan')->paginate(5));
        //return new KontenResource(Konten::with('user','perkembangan')->paginate(5));
        //return KontenResource::collection(Konten::paginate(5));
        
        
    }

    public function store(Request $request)
    {
        //cara pendek, dengan resource
        // $konten = Konten::create($request->all());
        // return new KontenResource($konten);

        //cara 2
        $konten = new Konten();

        //$judul_slug = str_slug($request->judul,"-");
        $file_name = str_slug($request->judul,"-").'_'.$request->id_user.'.jpg';
        $file_path = '../storage/images/konten';
        $path = $request->file('gambar')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/konten/'.$file_name);

        $konten->id_user = $request->id_user;
        $konten->judul = $request->judul;
        $konten->deskripsi = $request->deskripsi;
        $konten->target = $request->target;
        
        $konten->gambar = $urlgambar;
        $konten->lama_donasi = $request->lama_donasi;
        $konten->nomorrekening = $request->nomorrekening;

        $konten->save();
 
        return response()->json([
            'success' => true,
            'message' => 'Tunggu verifikasi kami',
            'data' => $konten
        ], 201);
    }

    public function show($id)
    {
        //coba salah satu

        return new KontenResource(Konten::with('user','perkembangan')->find($id));
        //return new KontenResource($konten);
    }

    public function update(Konten $konten, Request $request)
    {
        //
        $konten->update($request->all());

        return new KontenResource($konten);
    }

    public function destroy(Konten $konten)
    {
        //
        $konten->delete();

        return response()->json();
    }
}
