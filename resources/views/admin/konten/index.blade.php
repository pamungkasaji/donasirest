@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Konten Management</div>

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
                            $no = 1;
                            @endphp
                            @foreach($kontens as $konten)
                            <tr>
                                <th>{{ $no++ }}</th>
                                <td>{{ $konten->judul }}</td>
                                <td>Rp. <?php echo number_format($konten->target, 0, ',', '.'); ?></td>
                                <td>{{ $konten->lama_donasi }}</td>
                                <td>{{ $konten->status }}</td>
                                <td>
                                    <a href=" {{ route('admin.konten.show', $konten->id) }}"><button type="button" class="btn btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                    {{ $kontens->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection