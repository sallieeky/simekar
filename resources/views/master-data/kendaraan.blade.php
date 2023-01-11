@extends("layouts.base")
@section("title", "Kelola Kendaraan")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Master Data</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Kelola Kendaraan</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Kelola Kendaraan</h3>
        <div class="portlet-tools">
          <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambah-modal">
            <i class="fa fa-plus"></i>
            Tambah Kendaraan
          </button>
        </div>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-bordered table-hover" id="table-kendaraan">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nomor Polisi</th>
                  <th>Merk</th>
                  <th>Tipe</th>
                  <th>Tampilkan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($kendaraan as $dt)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $dt->no_polisi }}</td>
                  <td>{{ $dt->merk }}</td>
                  <td>{{ $dt->tipe }}</td>
                  <td>
                    <div class="form-check-inline">
                      <label class="form-check-label">
                        {{-- tampilkan dan sembunyikan menggunakan tombol mata --}}
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

{{-- Make modal tambah kendaraan --}}
<div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-kendaraan" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kendaraan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/kendaraan/tambah" method="POST">
        @csrf
        <div class="modal-body">
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('no_polisi') is-invalid @enderror" type="text" id="no_polisi" placeholder="Nomor Polisi" name="no_polisi">
              <label for="no_polisi">Nomor Polisi</label>
              @error('no_polisi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('merk') is-invalid @enderror" type="text" id="merk" placeholder="Merk" name="merk">
              <label for="merk">Merk</label>
              @error('merk')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('tipe') is-invalid @enderror" type="text" id="tipe" placeholder="Tipe" name="tipe">
              <label for="tipe">Tipe</label>
              @error('tipe')
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

{{-- make edit user modal with ajax --}}
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/kendaraan/edit" method="POST">
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

{{-- make delete user modal --}}
{{-- <div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="modal-hapus-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Apakah anda yakin ingin menghapus user ini?</p>
      </div>
      <div class="modal-footer">
        <form action="/master-data/user/delete" method="POST">
          @csrf
          @method("DELETE")
          <input type="hidden" name="id" id="hapus_id">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
        </form>
      </div>
    </div>
  </div>
</div> --}}

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#table-kendaraan").DataTable({});

    // make ajax for btn-tampilkan
    $("#table-kendaraan").on('click', 'tbody tr td .btn-tampilkan',  function () {
      console.log("clicked");
      let id = $(this).data("id");
      let value = $(this).data("value");
      let element = $(this);

      swal
        .fire({
          title: "Apakah anda yakin?",
          text: `Kamu akan ${ value == 1 ? "menyembunyikan" : "menampilkan" } kendaraan ini!`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: `${ value == 1 ? "Sembunyikan" : "Tampilkan" }`,
          cancelButtonText: "Batal",
        })
        .then(function (result) {
          if (result.isConfirmed) {
            if (value == 1) {
              element.data("value", 0);
              element.html('<i class="fas fa-eye-slash"></i>');
              element.removeClass("btn-label-primary");
              element.addClass("btn-label-secondary");
            } else {
              element.data("value", 1);
              element.html('<i class="fas fa-eye"></i>');
              element.removeClass("btn-label-secondary");
              element.addClass("btn-label-primary");
            }
            $.ajax({
              url: "/master-data/kendaraan/tampilkan/" + id,
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                isShow: value,
              },
              success: function (data) {
                console.log(data);
              },
            });
          }
        });
    });

    // make ajax for edit
    $("#table-kendaraan").on('click', 'tbody tr td .btn-edit', function () {
      let id = $(this).data("id");
      $.ajax({
        url: "/master-data/kendaraan/get/" + id,
        type: "GET",
        success: function (data) {
          console.log(data);
          $(".modal-edit-body").html(data);
          $("#edit-modal").modal("show");
        },
      });
    });

    // make ajax for delete
    // $(".btn-hapus").click(function () {
    //   let id = $(this).data("id");
    //   $("#hapus_id").val(id);
    //   $("#hapus-modal").modal("show");
    // });
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