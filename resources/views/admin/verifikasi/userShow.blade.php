@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Verifikasi</div>

                <div class="card-body">

                    <p> {{ $user->username }} </p>
                    <p> {{ $user->namalengkap }} </p>
                    <img src="{{url('/images/ktp/')}}/{{$user->fotoktp}}" alt="Foto KTP penggalang dana">
                    
                    <form action="{{ route('admin.verifikasi.user.approve', $user->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-primary" type="submit">Terima</button>
                    </form>
                    <button class="btn btn-warning" data-toggle="modal" data-target="#confirmModal">
                        Tolak
                    </button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tolak Verifikasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menolak verifikasi penggalang dana?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.verifikasi.user.disapprove', $user->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-warning" type="submit">Ya</button>
                </form>
            </div>
        </div>
    </div>
</div>