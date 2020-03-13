@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Verifikasi Perpanjangan Penggalangan Dana</div>

                <div class="card-body">

                <?php /*

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}

                        </div>
                    @endif

                    You are logged in!

                */ ?>


                    <p> {{ $perpanjangan->judul }} </p>
                    <p> {{ $perpanjangan->perpanjangan->alasan }} </p>
                    <p> {{ $perpanjangan->user->namalengkap }} </p>

                    <a href=" {{ route('admin.konten.show', $perpanjangan->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
