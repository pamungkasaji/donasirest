@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
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

                    <p> {{ $user->username }} </p>
                    <p> {{ $user->namalengkap }} </p>
                    <img src="{{url('/images/ktp/')}}/{{$user->fotoktp}}" alt="Foto KTP penggalang dana">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection


