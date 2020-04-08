<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Konten;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('is_verif', true)->paginate(20);

        return view('admin.user.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);

        $konten = $user->konten()->where('status', '!=', 'verifikasi')->get();
  
        return view('admin.user.show', compact('user','konten'));
    }

    public function delete($id)
    {
        User::where('id', $id)->delete();

        return redirect()->route('admin.user.index')
                        ->with('warning','Akun penggalang dana dihapus');
    }
}
