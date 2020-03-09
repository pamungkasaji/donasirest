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

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
