@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Konten Penggalangan Dana</h5>
                </div>

                <div class="card-body" style="margin: 10px">
                    <h2 class="my-1">{{ $konten->judul }}</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{url('/images/konten/')}}/{{$konten->gambar}}" class="img-fluid" alt="Gambar konten penggalangan dana">
                        </div>
                        <div class="col-md-4">
                            <br>
                            <h5 class="my-3">Informasi Donasi</h5>
                            <table>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>{{ $konten->status }}</td>
                                </tr>
                                <tr>
                                    <td>Target</td>
                                    <td>:</td>
                                    <td>Rp. <?php echo number_format($konten->target, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Terkumpul</td>
                                    <td>:</td>
                                    <td>Rp. <?php echo number_format($konten->terkumpul, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Prosentase</td>
                                    <td>:</td>
                                    <td>{{ round((float)$konten->terkumpul/$konten->target * 100 )}}%</td>
                                </tr>
                                <tr>
                                    <td>Lama Donasi</td>
                                    <td>:</td>
                                    <td>{{ $konten->lama_donasi }} hari lagi</td>
                                </tr>
                            </table>
                            <br>
                            <table>
                                <tr>
                                    <td>
                                        <button class="btn btn-warning" <?php if($konten->status != 'aktif') {?> disabled="disabled" <?php } ?> data-toggle="modal" data-target="#nonaktifModal">
                                            Nonaktifkan
                                        </button></td>
                                    </td>
                                    <td><button class="btn btn-danger" style="margin-left: 14px" data-toggle="modal" data-target="#deleteModal">
                                            Hapus
                                        </button></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <h5 class="my-3">Deskripsi</h5>
                    <p style=font-size:16px> {{ $konten->deskripsi }} </p>
                    <br>
                    <h5 class="my-3">Penggalang Dana</h5>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $konten->user->namalengkap }}</td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td>{{ $konten->user->username }}</td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td>:</td>
                            <td>{{ $konten->user->nohp }}</td>
                        </tr>
                    </table>
                    <br>
                    <a href=" {{ route('admin.user.show', $konten->user->id) }}"><button type="button" class="btn btn-primary">Lihat informasi penggalang dana</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal Nonaktif -->
<div class="modal fade" id="nonaktifModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nonaktifkan Penggalangan Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menonaktifkan penggalangan dana?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.konten.nonaktif', $konten->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-primary" type="submit" style="margin: 10px">Nonaktifkan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Delete-->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Hapus Penggalangan Dana</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus konten penggalangan dana?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.konten.delete', $konten->id)}}" method="post">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-primary" type="submit" style="margin: 10px">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>