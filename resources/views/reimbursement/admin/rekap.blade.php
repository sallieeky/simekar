@extends("layouts.base")
@section("title", "Data Rekapitulasi Pengajuan Reimbursement")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Reimbursement</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Data Rekapitulasi Pengajuan Reimbursement</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Filter Data</h3>
      </div>
      <div class="portlet-body">
        <form action="/admin/reimbursement/pengajuan/rekapitulasi/export" method="GET" id="form_export">
        <div class="row">
          <div class="col-md-5">
            <div class="form-group">
              <label for="tanggal_dari">Tanggal Dari</label>
              <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control" value="{{ date('Y-m-d', strtotime('-1 month')) }}">
            </div>
          </div>
          <div class="col-md-5">
            <div class="form-group">
              <label for="tanggal_sampai">Tanggal Sampai</label>
              <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="tanggal_sampai"></label><br>
              <button class="btn btn-primary btn-block w-100" type="button" id="btn_export">
                <i class="fas fa-file-excel"></i>
                Export
              </button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Data Rekapitulasi Pengajuan Reimbursement</h3>
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
                    <th>Nomor Polisi</th>
                    <th>KM Tempuh</th>
                    <th>Nominal</th>
                    <th>Keterangan</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt->user->nama }}</td>
                    <td>{{ $dt->user->no_hp }}</td>
                    <td>{{ $dt->created_at->format('d-m-Y') }}</td>
                    <td>{{ $dt->kendaraan->no_polisi }}</td>
                    <td>{{ $dt->km_tempuh }}</td>
                    <td>
                      Rp. {{ number_format((int) $dt->nominal,2,',','.') }}  
                    </td>
                    <td>{{ $dt->keterangan ? $dt->keterangan : "Tidak ada" }}</td>
                    <td>
                      @if($dt->status == "Pengajuan disetujui")
                      <span class="badge badge-success">Disetujui</span>
                      @elseif ($dt->status == "Pengajuan ditolak")
                      <span class="badge badge-danger">Ditolak</span>
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

  $("#btn_export").click(function () {
    let tanggal_dari = $("#tanggal_dari").val();
    let tanggal_sampai = $("#tanggal_sampai").val();

    if (tanggal_dari == "" || tanggal_sampai == "") {
      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "Tanggal Dari dan Sampai harus diisi!",
      });
    } else {
      $.ajax({
        url: "/admin/reimbursement/pengajuan/rekapitulasi/export?tanggal_dari=" + tanggal_dari + "&tanggal_sampai=" + tanggal_sampai,
        type: "GET",
        data: {
          tanggal_dari: tanggal_dari,
          tanggal_sampai: tanggal_sampai,
        },
        success: function (response) {
          if (response == false) {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Data tidak ditemukan!",
            });
          } else {
            $("#form_export").submit();
          }
        },
      });
    }
  });

</script>

@endsection