@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Verifikasi</div>

                <div class="card-body">

                <?php /*

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}

                        </div>
                    @endif

                    You are logged in!

                */ ?>

                    <p> {{ $konten->judul }} </p>
                    <p> {{ $konten->user->namalengkap }} </p>
<<<<<<< HEAD
                    <a href=" {{ route('admin.konten.show', $konten->id) }}"><button type="button" class="btn btn-primary">Detail</button>
=======

                    
>>>>>>> a197c675c5d31a021f9d5c8009a47934c8fdb728
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
