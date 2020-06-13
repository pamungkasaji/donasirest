@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Perpanjangan</div>

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
                                <th scope="col">Judul</th>
                                <th scope="col">Penggalang Dana</th>
                                <th scope="col">Jumlah Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perpanjangan as $key => $p)
                            <tr>
                                <th>{{ $perpanjangan->firstItem() + $key }}</th>
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->user->namalengkap }}</td>
                                <td>{{ $p->perpanjangan->jumlah_hari }}</td>
                                <td>{{ $p->perpanjangan->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.perpanjangan.show', $p->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $perpanjangan->links() }}
                    <br>

                    <h5>Ditolak</h5>
                    <p>Tabel ditolak untuk pemberitahuan pada pengguna bahwa verifikasi perpanjangan ditolak</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Penggalang Dana</th>
                                <th scope="col">Jumlah Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perpanjangan_ditolak as $keyd => $pd)
                            <tr>
                                <th>{{ $perpanjangan_ditolak->firstItem() + $keyd }}</th>
                                <td>{{ $pd->judul }}</td>
                                <td>{{ $pd->user->namalengkap }}</td>
                                <td>{{ $pd->perpanjangan->jumlah_hari }}</td>
                                <td>{{ $pd->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.perpanjangan.show', $pd->id) }}"><button type="button" class="btn btn-primary">Detail</button></a>
                                    <button class="btn btn-danger" style="margin-left: 10px" data-toggle="modal" data-target="#deleteModal{{ $pd->id }}">
                                        Hapus
                                    </button>

                                    <div class="modal fade" id="deleteModal{{ $pd->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus permintaan perpanjangan</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Pemberitahuan perpanjangan ditolak akan dihapus dari user</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                    <form action="{{ route('admin.verifikasi.perpanjangan.delete', $pd->id)}}" method="post">
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
                    {{ $perpanjangan_ditolak->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection