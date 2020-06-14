@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Verifikasi Perpanjangan Donasi</h5>
                </div>

                <div class="card-body" style="margin: 10px">
                    <h3 class="my-1">{{ $kontenPerpanjangan->judul }}</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{url('/images/konten/')}}/{{$kontenPerpanjangan->gambar}}" class="img-fluid" alt="Gambar konten penggalangan dana">
                        </div>

                        <div class="col-md-4">
                            <br>
                            <h5 class="my-3">Informasi Donasi</h5>
                            <table>
                                <tr>
                                    <td>Status</td>
                                    <td>:</td>
                                    <td>{{ $kontenPerpanjangan->status }}</td>
                                </tr>
                                <tr>
                                    <td>Target</td>
                                    <td>:</td>
                                    <td>Rp. <?php echo number_format($kontenPerpanjangan->target, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Terkumpul</td>
                                    <td>:</td>
                                    <td>Rp. <?php echo number_format($kontenPerpanjangan->terkumpul, 0, ',', '.'); ?></td>
                                </tr>
                                <tr>
                                    <td>Prosentase</td>
                                    <td>:</td>
                                    <td>{{ round((float)$kontenPerpanjangan->terkumpul/$kontenPerpanjangan->target * 100 )}}%</td>
                                </tr>
                                <tr>
                                    <td>Lama Donasi</td>
                                    <td>:</td>
                                    <td>{{ $kontenPerpanjangan->lama_donasi }} hari lagi</td>
                                </tr>
                            </table>

                        </div>
                    </div>
                    <h5 class="my-3">Informasi Perpanjangan</h5>
                    <table>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->perpanjangan->status }}</td>
                        </tr>
                        <tr>
                            <td>Jumlah Hari</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->perpanjangan->jumlah_hari }}</td>
                        </tr>
                        <tr>
                            <td>Alasan</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->perpanjangan->alasan }}</td>
                        </tr>
                    </table>

                    <table>
                        <tr>
                            <td>
                                <form action="{{ route('admin.verifikasi.perpanjangan.approve', $kontenPerpanjangan->perpanjangan->id)}}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="btn btn-primary" type="submit" style="margin-top: 14px">Terima</button>
                                </form>
                            </td>
                            <td><button class="btn btn-warning" style="margin-left: 14px" <?php if ($kontenPerpanjangan->perpanjangan->status == 'ditolak') { ?> disabled="disabled" <?php } ?> data-toggle="modal" data-target="#confirmModal">
                                    Tolak
                                </button></td>
                        </tr>
                    </table>
                    <br>
                    <h5 class="my-3">Deskripsi</h5>
                    <p  style=font-size:15px> {{ $kontenPerpanjangan->deskripsi }} </p>
                    <br>
                    <h5 class="my-3">Penggalang Dana</h5>
                    <table>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->user->namalengkap }}</td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->user->username }}</td>
                        </tr>
                        <tr>
                            <td>No HP</td>
                            <td>:</td>
                            <td>{{ $kontenPerpanjangan->user->nohp }}</td>
                        </tr>
                    </table>
                    <br>
                    <a href=" {{ route('admin.user.show', $kontenPerpanjangan->user->id) }}"><button type="button" class="btn btn-primary">Lihat informasi penggalang dana</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Tolak Perpanjangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menolak perpanjangan yang diajukan?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('admin.verifikasi.perpanjangan.disapprove', $kontenPerpanjangan->perpanjangan->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <button class="btn btn-warning" type="submit">Tolak</button>
                </form>
            </div>
        </div>
    </div>
</div>