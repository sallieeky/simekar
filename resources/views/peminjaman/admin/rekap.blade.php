@extends("layouts.base")
@section("title", "Data Rekapitulasi Peminjaman")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Peminjaman</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Data Rekapitulasi Peminjaman</span>
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
        <form action="/admin/peminjaman/pengajuan/rekapitulasi/export" method="GET" id="form_export">
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
        <h3 class="portlet-title">Data Rekapitulasi Peminjaman</h3>
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
                    <th>Nomor Polisi</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Nama Driver</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>  
                    <th>Tujuan</th>  
                    <th>Keperluan</th>  
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt->user->nama }}</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->no_polisi }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->merk }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->tipe }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->driver) {{ $dt->driver->nama }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>{{ $dt->waktuPeminjamanFormated }}</td>
                    <td>{{ $dt->waktuSelesaiFormated }}</td>
                    <td>{{ $dt->tujuan_peminjaman->nama }}</td>
                    <td>{{ $dt->keperluan }}</td>
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
        url: "/admin/peminjaman/pengajuan/rekapitulasi/export?tanggal_dari=" + tanggal_dari + "&tanggal_sampai=" + tanggal_sampai,
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

@if(session('success'))
<script>
  toastr.success("{{ session('success') }}")
</script>
@endif

{{-- error validate apapun --}}
@if($errors->any())
<script>
  toastr.error("{{ $errors->first() }}")
</script>
@endif

@endsection