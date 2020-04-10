@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Verifikasi Konten</div>

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
                                <th scope="col">Target</th>
                                <th scope="col">Sisa Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no1 = 1;
                            @endphp
                            @foreach($konten as $k)
                            <tr>
                                <th>{{ $no1++ }}</th>
                                <td>{{ $k->judul }}</td>
                                <td>Rp. <?php echo number_format($k->target, 0, ',', '.'); ?></td>
                                <td>{{ $k->lama_donasi }}</td>
                                <td>{{ $k->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.konten.show', $k->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <h5>Ditolak</h5>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Judul</th>
                                <th scope="col">Target</th>
                                <th scope="col">Sisa Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no2 = 1;
                            @endphp
                            @foreach($konten_ditolak as $kd)
                            <tr>
                                <th>{{ $no1++ }}</th>
                                <td>{{ $kd->judul }}</td>
                                <td>Rp. <?php echo number_format($kd->target, 0, ',', '.'); ?></td>
                                <td>{{ $kd->lama_donasi }}</td>
                                <td>{{ $kd->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.konten.show', $kd->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection