@extends("layouts.base")
@section("title", "Rekap Data Asset dan Service Kendaraan")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Master Data</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Asset dan Service</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Rekap Asset dan Service</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Rekap Data Aset Kendaraan</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-aset">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>No. Aset</th>
                    <th>No. Polis</th>
                    <th>No. Rangka</th>
                    <th>No. Mesin</th>
                    <th>Masa Pajak</th>
                    <th>Masa STNK</th>
                    <th>Masa Asuransi</th>
                    <th>Tgl Service Rutin</th>
                    <th>Tahun Pembuatan</th>
                    <th>Tahun Pengadaan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($aset as $dt)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $dt->kendaraan->no_polisi }}</td>
                      <td>{{ $dt->no_aset }}</td>
                      <td>{{ $dt->no_polis }}</td>
                      <td>{{ $dt->no_rangka }}</td>
                      <td>{{ $dt->no_mesin }}</td>
                      <td>{{ date('d-m-Y', strtotime($dt->masa_pajak)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($dt->masa_stnk)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($dt->masa_asuransi)) }}</td>
                      <td>{{ date('d-m-Y', strtotime($dt->tgl_service_rutin)) }}</td>
                      <td>{{ $dt->tahun_pembuatan }}</td>
                      <td>{{ $dt->tahun_pengadaan }}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary btn-edit-aset mb-1 w-100" data-id="{{ $dt->id }}">
                          <i class="fa fa-edit"></i>
                        </button>
                        <br>
                        <button type="button" class="btn btn-sm btn-danger btn-hapus-aset w-100" data-id="{{ $dt->id }}">
                          <i class="fa fa-trash"></i>
                        </button>
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

  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Rekap Data Service Kendaraan</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-service">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Kendaraan</th>
                    <th>Kode</th>
                    <th>Uraian</th>
                    <th>Tgl Service</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($service as $dt)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $dt->kendaraan->no_polisi }}</td>
                      <td>{{ $dt->kode }}</td>
                      <td>{{ $dt->uraian }}</td>
                      <td>{{ date('d-m-Y', strtotime($dt->tgl_service)) }}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-primary btn-edit-service" data-id="{{ $dt->id }}">
                          <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-danger btn-hapus-service" data-id="{{ $dt->id }}">
                          <i class="fa fa-trash"></i>
                        </button>
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

<div class="modal fade" id="edit-modal-aset" tabindex="-1" role="dialog" aria-labelledby="modal-edit-aset" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Aset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/asset-service/rekap/aset/edit" method="POST">
        @csrf
        <div class="modal-body modal-edit-body-aset">
          {{--  --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="edit-modal-service" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/asset-service/rekap/service/edit" method="POST">
        @csrf
        <div class="modal-body modal-edit-body-service">
          {{--  --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="hapus-modal-aset" tabindex="-1" role="dialog" aria-labelledby="modal-hapus" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Aset</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus aset ini?</p>
      </div>
      <div class="modal-footer">
        <form action="/master-data/asset-service/rekap/aset/delete" method="POST">
          @csrf
          @method("DELETE")
          <input type="hidden" name="id" id="hapus_id_aset">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="hapus-modal-service" tabindex="-1" role="dialog" aria-labelledby="modal-hapus" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Service</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus service ini?</p>
      </div>
      <div class="modal-footer">
        <form action="/master-data/asset-service/rekap/service/delete" method="POST">
          @csrf
          @method("DELETE")
          <input type="hidden" name="id" id="hapus_id_service">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#table-aset").DataTable({});
    $("#table-service").DataTable({});

    // make ajax for edit
    $("#table-aset").on('click', 'tbody tr td .btn-edit-aset', function () {
      let id = $(this).data("id");
      $.ajax({
        url: "/master-data/asset-service/rekap/aset/get/" + id,
        type: "GET",
        success: function (data) {
          $(".modal-edit-body-aset").html(data);
          $("#edit-modal-aset").modal("show");
        },
      });
    });

    // make ajax for edit service
    $("#table-service").on('click', 'tbody tr td .btn-edit-service', function () {
      let id = $(this).data("id");
      $.ajax({
        url: "/master-data/asset-service/rekap/service/get/" + id,
        type: "GET",
        success: function (data) {
          $(".modal-edit-body-service").html(data);
          $("#edit-modal-service").modal("show");
        },
      });
    });

    // make ajax for delete
    $("#table-aset").on('click', 'tbody tr td .btn-hapus-aset',function () {
      let id = $(this).data("id");
      $("#hapus_id_aset").val(id);
      $("#hapus-modal-aset").modal("show");
    });

    // make ajax for delete service
    $("#table-service").on('click', 'tbody tr td .btn-hapus-service',function () {
      let id = $(this).data("id");
      $("#hapus_id_service").val(id);
      $("#hapus-modal-service").modal("show");
    });

  });
</script>

@if(session('success'))
<script>
  Swal.fire({
    icon: "success",
    title: "Berhasil",
    text: "{{ session('success') }}",
  });
</script>
@endif

{{-- error validate apapun --}}
@if($errors->any())
<script>
  Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "{{ $errors->first() }}",
  });
</script>
@endif

{{-- if session fail --}}
@if(session('fail'))
<script>
  Swal.fire({
    icon: "error",
    title: "Gagal",
    text: "{{ session('fail') }}",
  });
</script>
@endif

@endsection