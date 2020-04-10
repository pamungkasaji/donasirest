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
                                <th scope="col">Jumlah Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no1 = 1;
                            @endphp
                            @foreach($perpanjangan as $p)
                            <tr>
                                <th>{{ $no1++ }}</th>
                                <td>{{ $p->judul }}</td>
                                <td>{{ $p->perpanjangan->jumlah_hari }}</td>
                                <td>{{ $p->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.perpanjangan.show', $p->id) }}"><button type="button" class="btn btn-primary">Detail</button>
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
                                <th scope="col">Jumlah Hari</th>
                                <th scope="col">Status</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no2 = 1;
                            @endphp
                            @foreach($perpanjangan_ditolak as $pd)
                            <tr>
                                <th>{{ $no2++ }}</th>
                                <td>{{ $pd->judul }}</td>
                                <td>{{ $pd->perpanjangan->jumlah_hari }}</td>
                                <td>{{ $pd->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.verifikasi.perpanjangan.show', $pd->id) }}"><button type="button" class="btn btn-primary">Detail</button>
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