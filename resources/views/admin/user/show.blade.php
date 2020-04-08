@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Detail Penggalang Dana</h5>
                </div>

                <div class="card-body" style="margin: 10px">
                    <div class="row">
                        <div class="col-md-7">
                            <img src="{{url('/images/ktp/')}}/{{$user->fotoktp}}" class="img-fluid" alt="Gambar konten penggalangan dana">
                        </div>
                        <div class="col-md-4">
                            <br>
                            <h5 class="my-3">Informasi Penggalang Dana</h5>
                            <table>
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>{{ $user->namalengkap }}</td>
                                </tr>
                                <tr>
                                    <td>Username</td>
                                    <td>:</td>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <td>No HP</td>
                                    <td>:</td>
                                    <td>{{ $user->nohp }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ $user->alamat }}</td>
                                </tr>
                                <tr>
                                    <td>No KTP</td>
                                    <td>:</td>
                                    <td>{{ $user->nomorktp }}</td>
                                </tr>
                            </table>
                            <br>
                            <table>
                                <tr>
                                    <td><button class="btn btn-danger" style="margin-left: 14px" data-toggle="modal" data-target="#deleteModal">
                                            Hapus
                                        </button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <br>
                    <br>
                    <h5 class="my-3">Donasi yang dibuat penggalang dana :</h5>
                    <br>
                    <div class="container">
                        <div class="row ">
                            <!-- my php code which uses x-path to get results from xml query. -->
                            @foreach($konten as $konten)
                            <div class="col-sm-4 ">
                                <div class="card-deck">
                                    <div class="card  bg-light" style="width: 22rem; ">
                                        <img class="card-img-top" style="object-fit: cover; width: 100%; height: 15vw" src="{{url('/images/konten/')}}/{{$konten->gambar}}" alt="Card image cap">

                                        <div class="card-body">
                                            <h5 class="card-title">{{ $konten->judul}}</h5>
                                            <p class="card-text">{{ $konten->status}}</p>
                                            <p class="card-text">Terkumpul Rp. {{ number_format($konten->terkumpul) }}</p>
                                            <p class="card-text">{{ round((float)$konten->terkumpul/$konten->target * 100 )}}% dari target</p>
                                            <a href="{{ route('admin.konten.show', $konten->id) }}" class="btn btn-primary">Detail</a>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <!--container div  -->

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Penggalangan Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus penggalang dana?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.user.delete', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-primary" type="submit" style="margin: 10px">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>