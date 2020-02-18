<?php

namespace App\Http\Controllers;

use App\Konten;
use App\Donatur;
use App\Http\Resources\DonaturResource;
use Illuminate\Http\Request;

class DonaturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Konten $konten) {
        //
        $donatur = $konten->donatur()->get();

        return response()->json([
            'message' => 'Daftar donatur masuk',
            'success' => true,
            'data' => $donatur
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Konten $konten, Request $request) {
        
        //cara 1
        $this->validate($request, [
            //'nama' => 'required',
            'is_anonim' => 'required',
            'is_diterima' => 'required',
            'jumlah' => 'required'
            //'bukti' => 'required',
            //'id_konten' => 'required'
        ]);

        $donatur = new Donatur();

        $file_name = $request->nama.'_donatur_.jpg';
        $file_path = '../storage/images/donatur';
        $path = $request->file('bukti')->move($file_path, $file_name);
        $urlgambar = url('/storage/images/donatur/'.$file_name);

        // $donatur->id_user = $request->id_user;
        // $donatur->judul = $request->judul;
        // $donatur->deskripsi = $request->deskripsi;
        // $donatur->target = $request->target;

        $donatur = $konten->donatur()->create($request->all());

        $donatur->bukti = $urlgambar;

        if ($donatur->save()) {
            $response = [
                'message' => "Tunggu verifikasi penggalang dana",
                'success' => true,
                'donatur' => $donatur
            ];
            return response()->json($response,201);
        }

        $response = [
            'message' => 'Terjadi kesalahan penambahan donatur',
            'success' => false
        ];

        return response()->json($response, 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Donatur  $donatur
     * @return \Illuminate\Http\Response
     */
    public function show(Konten $konten, Donatur $donatur)
    {
        //
        //$donatur = $konten->donatur()->find($id_donatur);

        $donatur = $konten->donatur()->find($id);

        return response()->json([
            'message' => 'Informasi donatur',
            'success' => true,
            'data' => $donatur
        ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Donatur  $donatur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Konten $konten, Donatur $donatur)
    {
        //kurang autorisasi

        $donatur->update($request->validate([
            'is_diterima' => 'required',
        ]));

        return response()->json([
            'message' => 'Donasi diterima',
            'success' => true,
            'donatur' => $donatur
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Donatur  $donatur
     * @return \Illuminate\Http\Response
     */
    public function destroy(Konten $konten, Donatur $donatur)
    {
        //
        //$this->authorize('delete', $donatur);

        $donatur->delete();

        return response()->json([
            'message' => "Your answer has been removed",
            'success' => true
        ],200);
    }
}
