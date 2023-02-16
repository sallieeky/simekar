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
                        <a href="/master-data/asset-service/edit/{{ $dt->id }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                        <a href="/master-data/asset-service/delete/{{ $dt->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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
                        <a href="/master-data/asset-service/edit/{{ $dt->id }}" class="btn btn-warning btn-sm"><i class="fas fa-pencil-alt"></i></a>
                        <a href="/master-data/asset-service/delete/{{ $dt->id }}" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
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

<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-edit-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/user/edit" method="POST">
        @csrf
        <input type="hidden" name="id" id="edit_id">
        <div class="modal-body modal-edit-body">
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('nama') is-invalid @enderror" type="text" id="edit_nama" placeholder="Nama" name="nama">
              <label for="nama">Nama</label>
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" id="edit_email" placeholder="Email" name="email">
              <label for="email">Email</label>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('no_hp') is-invalid @enderror" type="text" id="edit_no_hp" placeholder="Nomor Handphone" name="no_hp">
              <label for="no_hp">Nomor Handphone</label>
              @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="edit_password" placeholder="Password" name="password">
              <label for="password">Password</label>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" type="password" id="edit_password_confirmation" placeholder="Konfirmasi Password" name="password_confirmation">
              <label for="password_confirmation">Konfirmasi Password</label>
              @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#table-aset").DataTable({
      scrollX: true,
    });
    $("#table-service").DataTable({
      scrollX: true,

    });

    // make ajax for edit user
    $(".btn-edit").click(function () {
      let id = $(this).data("id");
      $.ajax({
        url: "/master-data/user/get/" + id,
        type: "GET",
        success: function (data) {
          $("#edit_id").val(data.id);
          $("#edit_nama").val(data.nama);
          $("#edit_email").val(data.email);
          $("#edit_no_hp").val(data.no_hp);
          $("#edit-modal").modal("show");
        },
      });
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