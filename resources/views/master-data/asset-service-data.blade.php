@extends("layouts.base")

@section("css") 
  <link rel="stylesheet" type="text/css" href="/calendar/calendar.css">
@endsection

@section("title", "Kelola Data Asset dan Service Kendaraan")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Master Data</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Asset dan Service</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Data Asset dan Service</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12 mb-3">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="d-flex justify-content-between">
              <div class="menu d-none">
                <button class="btn btn-primary" id="dropdownMenu-calendarType" type="button" data-bs-toggle="dropdown"><i id="calendarTypeIcon"></i><span id="calendarTypeName">Dropdown</span><i class="fa fa-angle-down"></i></button>
                <ul class="dropdown-menu dropdown-menu-animated" role="menu">
                  <li role="presentation"><a class="dropdown-item" role="menuitem" data-action="toggle-daily"><i class="fa fa-bars"></i> Daily</a></li>
                  <li role="presentation"><a class="dropdown-item" role="menuitem" data-action="toggle-weekly"><i class="fa fa-th-large"></i> Weekly</a></li>
                  <li role="presentation"><a class="dropdown-item" role="menuitem" data-action="toggle-monthly"><i class="fa fa-th"></i> Month</a></li>
                </ul>
              </div>
              <h3 class="text-center" id="renderRange"></h3>
              <div id="menu-navi" class="move-btn">
                <button class="btn btn-primary" type="button" data-action="move-prev"><i class="fa fa-angle-left" data-action="move-prev"></i></button>
                <button class="btn btn-primary" type="button" data-action="move-next"><i class="fa fa-angle-right" data-action="move-next"></i></button>
              </div>
            </div>
            <hr>
          </div>
          <div class="col-md-12">
            <div id="lnb" class="mb-3">
              <div class="d-flex justify-content-center" id="lnb-calendars">
                <div class="w-100 d-flex justify-content-center gap-5" id="calendarList"></div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div id="right">
              <div id="calendar"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Make modal tambah user --}}
<div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-labelledby="modal-tambah-user" aria-hidden="true">
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
</div>

{{-- make edit user modal with ajax --}}
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

{{-- make delete user modal --}}
<div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="modal-hapus-user" aria-hidden="true">
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
</div>

@endsection

@section("script")

<script src="/calendar/tui-code-snippet.min.js"></script>
<script src="/calendar/tui-time-picker.min.js"></script>
<script src="/calendar/tui-date-picker.min.js"></script>
<script src="/calendar/moment.min.js"></script>
<script src="/calendar/chance.min.js"></script>
<script src="/calendar/tui-calendar.js"></script>
<script src="/calendar/calendars.js"></script>
<script src="/calendar/schedules.js"></script>
<script src="/calendar/app.js"></script>

<script>
  $(document).ready(function () {
    $("#table-user").DataTable();

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

    // make ajax for delete user
    $(".btn-hapus").click(function () {
      let id = $(this).data("id");
      $("#hapus_id").val(id);
      $("#hapus-modal").modal("show");
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