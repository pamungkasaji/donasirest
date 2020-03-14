@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Verifikasi Konten Penggalangan Dana</div>

                <div class="card-body">

                    <div class="row">
                        <h2 class="my-3">{{ $konten->judul }}</h2>

                        <div class="col-md-6">
                            <img src="{{url('/images/konten/')}}/{{$konten->gambar}}" alt="Gambar konten penggalangan dana">
                        </div>

                        <div class="col-md-4">
                            <h4 class="my-3">Detail Penggalangan Dana</h4>
                            <ul>
                                <li>Target : {{ $konten->target }}</li>
                                <li>Terkumpul : {{ $konten->terkumpul }}</li>
                                <li>Lama Donasi : {{ $konten->lama_donasi }}</li>
                                <li>Status : {{ $konten->status }}</li>
                            </ul>

                            <form action="{{ route('admin.verifikasi.konten.approve', $konten->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <button class="btn btn-primary" type="submit">Terima</button>
                        </form>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#confirmModal">
                            Tolak
                        </button>
                        </div>


                        <p> {{ $konten->deskripsi }} </p>
                        <p> {{ $konten->user->namalengkap }} </p>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tolak Penggalangan Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menolak konten penggalangan dana yang diajukan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.verifikasi.konten.disapprove', $konten->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-warning" type="submit">Ya</button>
                </form>
            </div>
        </div>
    </div>
</div>