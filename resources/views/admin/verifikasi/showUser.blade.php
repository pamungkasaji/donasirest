@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Verifikasi Penggalang Dana</h5>
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

                            <table>
                                <tr>
                                    <td>
                                        <form action="{{ route('admin.verifikasi.user.approve', $user->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button class="btn btn-primary" type="submit" style="margin-top: 14px">Terima</button>
                                        </form>
                                    </td>
                                    <td><button class="btn btn-warning" style="margin-left: 14px" <?php if ($user->status == 'ditolak') { ?> disabled="disabled" <?php } ?> data-toggle="modal" data-target="#confirmModal">
                                            Tolak
                                        </button></td>
                                </tr>
                            </table>
                        </div>
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
                    @method('PUT')
                    <button class="btn btn-warning" type="submit">Ya</button>
                </form>
            </div>
        </div>
    </div>
</div>