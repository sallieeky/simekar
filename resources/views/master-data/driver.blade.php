@extends("layouts.base")
@section("title", "Kelola Driver")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Master Data</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Kelola Driver</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Kelola Driver</h3>
        <div class="portlet-tools">
          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah-modal">
            <i class="fa fa-plus"></i>
            Tambah Driver
          </button>
        </div>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-driver">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor Handphone</th>
                    <th>Status</th>
                    <th>Tampilkan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($driver as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt->nama }}</td>
                    <td>{{ $dt->no_hp }}</td>
                    <td>
                      @if ($dt->isReady == 1)
                      <span class="badge badge-success status-badge">Tersedia</span>
                      @else
                      <span class="badge badge-danger status-badge">Tidak Tersedia</span>
                      @endif
                    </td>
                    <td>
                      <div class="form-check-inline">
                        <label class="form-check-label">
                          @if ($dt->isShow)
                          <button type="button" class="btn btn-sm btn-label-primary btn-tampilkan" data-id="{{ $dt->id }}" data-value={{ $dt->isShow }}>
                            <i class="fa fa-eye"></i>
                          </button>
                          @else
                          <button type="button" class="btn btn-sm btn-label-secondary btn-tampilkan" data-id="{{ $dt->id }}" data-value={{ $dt->isShow }}>
                            <i class="fa fa-eye-slash"></i>
                          </button>
                          @endif
                        </label>
                      </div>
                    </td>
                    <td>
                      <button type="button" class="btn btn-sm btn-primary btn-edit" data-id="{{ $dt->id }}">
                        <i class="fa fa-edit"></i>
                      </button>
                      <button type="button" class="btn btn-sm btn-danger btn-hapus" data-id="{{ $dt->id }}">
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

{{-- Make modal tambah kendaraan --}}
<div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-labelledby="modal-tambah" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/driver/tambah" method="POST">
        @csrf
        <div class="modal-body">
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('nama') is-invalid @enderror" type="text" id="nama" placeholder="Nama" name="nama">
              <label for="nama">Nama</label>
              @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('no_hp') is-invalid @enderror" type="text" id="no_hp" placeholder="Nomor Handphone" name="no_hp">
              <label for="no_hp">Nomor Handphone</label>
              @error('no_hp')
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

{{-- make edit modal with ajax --}}
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/driver/edit" method="POST">
        @csrf
        <div class="modal-body modal-edit-body">
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

{{-- make delete modal --}}
<div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="modal-hapus" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Driver</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus driver ini?</p>
      </div>
      <div class="modal-footer">
        <form action="/master-data/driver/delete" method="POST">
          @csrf
          @method("DELETE")
          <input type="hidden" name="id" id="hapus_id">
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
    $("#table-driver").DataTable({});

    // make ajax for btn-tampilkan
    $("#table-driver").on('click', 'tbody tr td .btn-tampilkan',  function () {
      let id = $(this).data("id");
      let value = $(this).data("value");
      let element = $(this);

      swal
        .fire({
          title: "Apakah anda yakin?",
          text: `Kamu akan ${ value == 1 ? "menyembunyikan" : "menampilkan" } driver ini!`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: `${ value == 1 ? "Sembunyikan" : "Tampilkan" }`,
          cancelButtonText: "Batal",
        })
        .then(function (result) {
          if (result.isConfirmed) {
            $.ajax({
              url: "/master-data/driver/tampilkan/" + id,
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                isShow: value,
              },
              success: function (data) {
                if(data == false) {
                  swal.fire({
                    title: "Gagal!",
                    text: "Driver sedang digunakan",
                    icon: "error",
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                  });
                } else {
                  if (value == 1) {
                    element.data("value", 0);
                    element.html('<i class="fas fa-eye-slash"></i>');
                    element.removeClass("btn-label-primary");
                    element.addClass("btn-label-secondary");

                    element.parent().parent().parent().parent().find(".status-badge").html("Tidak Tersedia");
                    element.parent().parent().parent().parent().find(".status-badge").removeClass("badge-success");
                    element.parent().parent().parent().parent().find(".status-badge").addClass("badge-danger");
                  } else {
                    element.data("value", 1);
                    element.html('<i class="fas fa-eye"></i>');
                    element.removeClass("btn-label-secondary");
                    element.addClass("btn-label-primary");

                    element.parent().parent().parent().parent().find(".status-badge").html("Tersedia");
                    element.parent().parent().parent().parent().find(".status-badge").removeClass("badge-danger");
                    element.parent().parent().parent().parent().find(".status-badge").addClass("badge-success");
                  }
                }
              },
            });
          }
        });
    });

    // make ajax for edit
    $("#table-driver").on('click', 'tbody tr td .btn-edit', function () {
      let id = $(this).data("id");
      $.ajax({
        url: "/master-data/driver/get/" + id,
        type: "GET",
        success: function (data) {
          console.log(data);
          $(".modal-edit-body").html(data);
          $("#edit-modal").modal("show");
        },
      });
    });

    // make ajax for delete
    $("#table-driver").on('click', 'tbody tr td .btn-hapus',function () {
      let id = $(this).data("id");
      $("#hapus_id").val(id);
      $("#hapus-modal").modal("show");
    });
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