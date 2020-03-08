<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Konten;
use Illuminate\Http\Request;

class AdminKontenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $konten = Konten::all();

        //return view('admin.konten.index')->with('kontens', $kontens);
        return view('admin.konten.index', compact('konten'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Konten  $konten
     * @return \Illuminate\Http\Response
     */
    public function show(Konten $konten)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Konten  $konten
     * @return \Illuminate\Http\Response
     */
    public function edit(Konten $konten)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Konten  $konten
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Konten $konten)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Konten  $konten
     * @return \Illuminate\Http\Response
     */
    public function destroy(Konten $konten)
    {
        //
    }
}
