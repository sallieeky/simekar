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

{{-- Make modal tambah user --}}
{{-- <div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-user" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="/master-data/user/tambah" method="POST">
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
              <input class="form-control form-control-lg @error('email') is-invalid @enderror" type="email" id="email" placeholder="Email" name="email">
              <label for="email">Email</label>
              @error('email')
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
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('password') is-invalid @enderror" type="password" id="password" placeholder="Password" name="password">
              <label for="password">Password</label>
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="validation-container mb-4">
            <div class="form-floating">
              <input class="form-control form-control-lg @error('password_confirmation') is-invalid @enderror" type="password" id="password_confirmation" placeholder="Konfirmasi Password" name="password_confirmation">
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
</div> --}}

{{-- make edit user modal with ajax --}}
{{-- <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-edit-user" aria-hidden="true">
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
</div> --}}

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
    $("#table-kendaraan").DataTable();

    // make ajax for btn-tampilkan
    $(".btn-tampilkan").click(function () {
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

    // make ajax for edit user
    // $(".btn-edit").click(function () {
    //   let id = $(this).data("id");
    //   $.ajax({
    //     url: "/master-data/user/get/" + id,
    //     type: "GET",
    //     success: function (data) {
    //       $("#edit_id").val(data.id);
    //       $("#edit_nama").val(data.nama);
    //       $("#edit_email").val(data.email);
    //       $("#edit_no_hp").val(data.no_hp);
    //       $("#edit-modal").modal("show");
    //     },
    //   });
    // });

    // make ajax for delete user
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