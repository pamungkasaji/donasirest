<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Http\Resources\UserResource; 
class UserController extends Controller
{
    public function index()
    {
        //coba salah satu
        //return UserResource::collection(User::with('konten','kategori','perkembangan')->paginate(5));
        //return new UserResource(User::with('user','kategori','perkembangan')->paginate(5));
        return UserResource::collection(User::paginate(5));
        
    }
    public function store(Request $request)
    {
        //cara pendek, dengan resource
        $konten = User::create($request->all());
        return new UserResource($konten);
        
    }
    public function show($id)
    {
        //coba salah satu
        //return new UserResource(User::with('user','kategori','perkembangan')->find($id));
        return new UserResource($konten);
    }
    public function update(User $konten, Request $request)
    {
        //
        $konten->update($request->all());
        return new UserResource($konten);
    }
    public function destroy(User $konten)
    {
        //
        $konten->delete();
        return response()->json();
    }
}