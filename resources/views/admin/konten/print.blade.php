<!doctype html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>{{ $konten->judul }}!</title>

  <style type="text/css">
    * {
      font-family: Verdana, Arial, sans-serif;
    }

    table {
      font-size: x-small;
    }

    tfoot tr td {
      font-weight: bold;
      font-size: x-small;
    }

    .gray {
      background-color: lightgray
    }
  </style>

</head>

<body>
  <h4>{{ $konten->judul }}</h4>

  <table width="100%">
    <tr>
      <td width="60%"><strong>Informasi Donasi</strong></td>
      <td width="40%"><strong>Penggalang Dana</strong></td>
    </tr>

  </table>

  <table style="width:100%">
    <tr>
      <td width="15%">Status</td>
      <td>:</td>
      <td width="45%">{{ $konten->status }}</td>
      <td>Nama</td>
      <td>:</td>
      <td width="40%">{{ $konten->user->namalengkap }}</td>
    </tr>
    <tr>
      <td>Target</td>
      <td>:</td>
      <td>Rp. {{ number_format($konten->target, 0, ',', '.') }}</td>
      <td>Username</td>
      <td>:</td>
      <td>{{ $konten->user->username }}</td>
    </tr>
    <tr>
      <td>Terkumpul</td>
      <td>:</td>
      <td>Rp. {{ number_format($konten->terkumpul, 0, ',', '.') }}</td>
      <td>No HP</td>
      <td>:</td>
      <td>{{ $konten->user->nohp }}</td>
    </tr>
    <tr>
      <td>Prosentase</td>
      <td>:</td>
      <td>{{ round((float)$konten->terkumpul/$konten->target * 100 )}}%</td>
    </tr>
    <tr>
      <td>Tanggal dibuat</td>
      <td>:</td>
      <td>{{ $konten->created_at->format('d M Y') }}</td>
    </tr>

  </table>

  <br/>
  <table width="100%">
    <tr>
      <td width="45%"></td>
      <td><strong>Daftar Pengeluaran :</strong></td>
    </tr>

  </table>


  <table align="center" width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th width="10%">No</th>
        <th width="15%">Tanggal</th>
        <th width="55%">Deskripsi Penggunaan Dana</th>
        <th width="20%">Jumlah (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @php
      $no = 1;
      $total = 0
      @endphp
      @foreach($pengeluaran as $p)
      <tr>
        <th scope="row">{{ $no++ }}</th>
        <td align="right"> {{ $p->created_at }} </td>
        <td>{{ $p->deskripsi }}</td>
        <td align="right">{{ number_format($p->pengeluaran, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2"></td>
        <td align="right">Total</td>
        <td align="right" class="gray">Rp. {{ number_format($pengeluaran->sum('pengeluaran'), 0, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>

  <br/>
  <table width="100%">
    <tr>
      <td width="45%"></td>
      <td><strong>Daftar Donatur :</strong></td>
    </tr>

  </table>


  <table align="center" width="100%">
    <thead style="background-color: lightgray;">
      <tr>
        <th width="10%">No</th>
        <th width="15%">Tanggal</th>
        <th width="55%">Nama</th>
        <th width="20%">Jumlah (Rp)</th>
      </tr>
    </thead>
    <tbody>
      @php
      $no = 1;
      @endphp
      @foreach($donatur as $d)
      <tr>
        <th scope="row">{{ $no++ }}</th>
        <td align="right">{{ $d->created_at }}</td>
        <td> {{ $d->nama }} </td>
        <td align="right">{{ number_format($d->jumlah, 0, ',', '.') }}</td>
      </tr>
      @endforeach
    </tbody>

    <tfoot>
      <tr>
        <td colspan="2"></td>
        <td align="right">Total</td>
        <td align="right" class="gray">Rp. {{ number_format($konten->terkumpul, 0, ',', '.') }}</td>
      </tr>
      <tr>
        <td colspan="2"></td>
        <td align="right">Target</td>
        <td align="right">Rp. {{ number_format($konten->target, 0, ',', '.') }}</td>
      </tr>
    </tfoot>
  </table>

</body>

</html>