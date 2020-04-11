@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Verifikasi Penggalang Dana</div>

                <div class="card-body">

                    @if(session()->get('success'))
                    <div class="alert alert-success">
                        <strong>{{ session()->get('success') }}</strong>
                    </div><br />
                    @elseif(session()->get('warning'))
                    <div class="alert alert-warning">
                        <strong>{{ session()->get('warning') }}</strong>
                    </div><br />
                    @elseif(session()->get('danger'))
                    <div class="alert alert-danger">
                        <strong>{{ session()->get('danger') }}</strong>
                    </div><br />
                    @endif

                    <h5>Menunggu Verifikasi</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Username</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no1 = 1;
                            @endphp
                            @foreach($user as $u)
                            <tr>
                                <th>{{ $no1++ }}</th>
                                <td>{{ $u->namalengkap }}</td>
                                <td>{{ $u->username }}</td>
                                <td>{{ $u->nohp }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.user.show', $u->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $user->links() }}

                    <h5>Ditolak</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Lengkap</th>
                                <th scope="col">Username</th>
                                <th scope="col">No HP</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no2 = 1;
                            @endphp
                            @foreach($user_ditolak as $ud)
                            <tr>
                                <th>{{ $no2++ }}</th>
                                <td>{{ $ud->namalengkap }}</td>
                                <td>{{ $ud->username }}</td>
                                <td>{{ $ud->nohp }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.user.show', $ud->id) }}"><button type="button" class="btn btn-primary">Detail</button></a>

                                    <button class="btn btn-danger" style="margin-left: 10px" data-toggle="modal" data-target="#deleteModal{{ $ud->id }}">
                                        Hapus
                                    </button>

                                    <div class="modal fade" id="deleteModal{{ $ud->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus Konten Donasi</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Pemberitahuan pengajuan konten ditolak akan dihapus dari user</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('admin.verifikasi.user.delete', $ud->id)}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-primary" type="submit" style="margin: 10px">Hapus</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                    {{ $user_ditolak->links() }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection