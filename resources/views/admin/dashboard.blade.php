@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>Dashboard</h5>
        </div>

        <div class="card-body" style="margin: 10px">
          <section class="content">
            <!-- Info boxes -->
            <div class="row">
              <div class="col-sm-4">
                <div class="card" style="width: 20rem;">
                  <div class="card-header">
                    <strong>Konten</strong>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Donasi Aktif {{ $konten_aktif }} </li>

                    <li class="list-group-item">Vestibulum at eros</li>
                  </ul>
                </div>
              </div>

              <div class="col-sm-4"> 
                <div class="card" style="width: 20rem;">
                  <div class="card-header">
                    <strong>Konten</strong>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Donasi Aktif {{ $konten_aktif }} </li>

                    <li class="list-group-item">Donasi Ditolak {{ $konten_ditolak }} </li>
                    <li class="list-group-item">Vestibulum at eros</li>
                  </ul>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="card" style="width: 20rem;">
                  <div class="card-body">
                    <h5 class="card-title">Donasi</h5>
                    <p class="card-text">Donasi Aktif {{ $konten_aktif }}</p>

                  </div>
                </div>
              </div>

              <!-- /.col -->
            </div>

          </section>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection