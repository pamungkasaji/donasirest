<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Perpanjangan;
use App\Konten;
use App\User;
use Illuminate\Http\Request;

class AdminPerpanjanganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $perpanjangan = Perpanjangan::all();

        //return view('admin.perpanjangan.index')->with('perpanjangans', $perpanjangans);
        return view('admin.perpanjangan.index', compact('perpanjangan'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Perpanjangan  $perpanjangan
     * @return \Illuminate\Http\Response
     */
    public function show(Perpanjangan $perpanjangan)
    {
        $perpanjangan = Perpanjangan::with('konten')->find($perpanjangan->id);
  
        return view('admin.perpanjangan.show', compact('perpanjangan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Perpanjangan  $perpanjangan
     * @return \Illuminate\Http\Response
     */
    public function edit(Perpanjangan $perpanjangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Perpanjangan  $perpanjangan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perpanjangan $perpanjangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Perpanjangan  $perpanjangan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Perpanjangan $perpanjangan)
    {
        //
    }
}
