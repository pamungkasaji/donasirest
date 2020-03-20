<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return view('admin.user.index', compact('user'));
    }

    public function show($id)
    {
        $user = User::find($id);
  
        return view('admin.user.show', compact('user'));
    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('admin.user.index')
                        ->with('warning','Akun penggalang dana dihapus');
    }
}
