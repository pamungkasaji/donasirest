@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Konten Management</div>

                <div class="card-body">
                    @foreach($konten as $konten)

                        {{ $konten->judul }} - {{ $konten-> target }}
                    @endforeach
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
