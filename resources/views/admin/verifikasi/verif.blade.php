@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Verifikasi Penggalang Dana</h5>
                            <p class="card-text">Penggalang dana bisa mengajukan donasi setelah verifikasi diterima</p>
                            <a href="{{ route('admin.verifikasi.user.index') }}" class="btn btn-primary">Masuk</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Verifikasi Konten</h5>
                            <p class="card-text">Konten penggalangan dana akan ditampilkan pada aplikasi setelah jika verifikasi diterima </p>
                            <a href="{{ route('admin.verifikasi.konten.index') }}" class="btn btn-primary">Masuk</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Verifikasi Perpanjangan</h5>
                            <p class="card-text">Perpanjangan donasi bisa diajukan oleh penggalang dana apabila waktu donasi sudah habis dan target belum terpenuhi</p>
                            <a href="{{ route('admin.verifikasi.perpanjangan.index') }}" class="btn btn-primary">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection