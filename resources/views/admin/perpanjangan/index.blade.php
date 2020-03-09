@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Konten Management</div>

                <div class="card-body">

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
                            @foreach($konten as $konten)
                            <tr>
                                <th>{{ $konten->id }}</th>
                                <td>{{ $konten->judul }}</td>
                                <td>{{ $konten->target }}</td>
                                <td>{{ $konten->lama_donasi }}</td>
                                <td>{{ $konten->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.konten.show', $konten->id) }}"><button type="button" class="btn btn-primary">Detail</button>
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