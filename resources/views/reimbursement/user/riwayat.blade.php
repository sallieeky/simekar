@extends("layouts.base")
@section("title", "Riwayat Reimbursement")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Reimbursement</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Riwayat</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Riwayat Pengajuan Reimbursement</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-driver">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Nomor Handphone</th>
                    <th>Tanggal Pengajuan</th>
                    <th>Kategori</th>
                    <th>Nomor Polisi</th>
                    <th>KM Tempuh</th>
                    <th>Nominal</th>
                    <th>Status</th>
                    <th>Nota</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($reimbursement as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt->user->nama }}</td>
                    <td>{{ $dt->user->no_hp }}</td>
                    <td>{{ $dt->created_at->format('d-m-Y') }}</td>
                    <td>{{ $dt->kategori }}</td>
                    <td>{{ $dt->kendaraan->no_polisi }}</td>
                    <td>{{ $dt->km_tempuh ?? "Null" }}</td>
                    <td>
                      Rp. {{ number_format((int) $dt->nominal,2,',','.') }}
                    </td>
                    <td>
                      @if ($dt->status == 'Dalam proses pengajuan')
                        <span class="badge bg-secondary">{{ $dt->status }}</span>
                      @elseif ($dt->status == 'Pengajuan disetujui')
                        <span class="badge bg-success">{{ $dt->status }}</span>
                      @elseif ($dt->status == 'Pengajuan ditolak')
                        <span class="badge bg-danger">{{ $dt->status }}</span>
                      @endif
                    </td>
                    <td>
                      @if($dt->status == 'Pengajuan disetujui')
                      <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-pdf" style="font-size: 1.5em"></i></button>
                        <div class="dropdown-menu" style="">
                          <form action="/user/reimbursement/riwayat/nota/lihat" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit" name="id" value="{{ $dt->id }}">Lihat</button>
                          </form>
                          <form action="/user/reimbursement/riwayat/nota/unduh" method="post">
                            @csrf
                            <button class="dropdown-item" type="submit" name="id" value="{{ $dt->id }}">Unduh</button>
                          </form>
                        </div>
                      </div>
                      @elseif($dt->status == 'Pengajuan ditolak')
                      <div class="badge badge-danger">
                        Pengajuan ditolak
                      </div>
                      @else
                      <div class="badge badge-secondary">
                        Menunggu
                      </div>
                      @endif
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
  </div>
</div>

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#table-driver").DataTable({});
  });
</script>


@endsection