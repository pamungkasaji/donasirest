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
                    <strong><h5>Konten</h5></strong>
                  </div>
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Aktif </h5>
                      <h4><span class="badge badge-primary">{{ $konten_aktif }} </span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Selesai </h5>
                      <h4><span class="badge badge-primary">{{ $konten_selesai }} </span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Terpenuhi </h5>
                      <h4><span class="badge badge-primary">{{ $konten_terpenuhi }} </span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Belum Terpenuhi </h5>
                      <h4><span class="badge badge-primary">{{ $konten_belum_terpenuhi }} </span></h4>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="col-sm-4">
                <div class="card" style="width: 20rem;">
                  <div class="card-header">
                    <strong><h5>Penggalang Dana</h5></strong>
                  </div>
                  <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Aktif </h5>
                      <h4><span class="badge badge-primary">{{ $konten_aktif }} </span></h4>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                      <h5>Selesai </h5>
                      <h4><span class="badge badge-primary">{{ $konten_selesai }} </span></h4>
                    </li>
                  </ul>
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