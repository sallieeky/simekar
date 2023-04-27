@extends("layouts.base")
@section("title", "Data Pengajuan Reimbursement")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Reimbursement</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Data Pengajuan Reimbursement</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Data Pengajuan Reimbursement</h3>
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
                    <th>Aksi</th>
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
                      <form action="/admin/reimbursement/pengajuan/respon" method="POST" class="form-respon">
                        @csrf
                        <input type="hidden" name="id" value="{{ $dt->id }}">
                        <input type="hidden" name="keterangan" class="input-keterangan">
                        <input type="hidden" name="status" class="input-status">
                        <button type="button" class="btn btn-sm btn-success btn-respon" data-value='setuju' data-id="{{ $dt->id }}">
                          <i class="fa fa-check"></i> Setuju
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-respon" data-value="tolak" data-id="{{ $dt->id }}">
                          <i class="fa fa-times"></i> Tolak
                        </button>
                      </form>
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

  $(".btn-respon").click(function () {
    var id = $(this).data("id");
    var status_val = $(this).data("value");
    var keterangan = $(this).parent().find(".input-keterangan");
    var status = $(this).parent().find(".input-status");
    var form = $(this).parent()

    swal
      .fire({
        title: "Keterangan",
        input: "textarea",
        inputAttributes: { autocapitalize: "off" },
        showCancelButton: true,
        confirmButtonText: "Kirim",
        cancelButtonText: "Batal",
      })
      .then(function (result) {
        if (result.isConfirmed) {
          keterangan.val($(".swal2-textarea").val());
          status.val(status_val)
          form.submit()
        }
      });

  });

</script>

@if(session('success'))
<script>
  Swal.fire({
    title: "{{ session('success') }}",
    icon: "success",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Oke",
  })
</script>
@endif

@endsection