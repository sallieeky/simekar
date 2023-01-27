@extends("layouts.base")
@section("title", "Profile")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Profile</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header">
        <h3 class="portlet-title">Ubah Data Profile</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-2 d-flex align-items-center justify-content-center">
            <img src="/image/user.png" alt="Foto User" class="img-fluid" id="form-ubah-data">
          </div>
          <div class="col-md-10">
            <form action="/profile/ubah-data" method="POST">
              @csrf
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg" type="text" id="name" placeholder="Nama" value="{{ $user->nama }}" readonly>
                  <label for="name">Nama</label>
                </div>
              </div>
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg" type="text" id="email" placeholder="Email" value="{{ $user->email }}" readonly>
                  <label for="email">Email</label>
                </div>
              </div>
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg @error('no_hp') is-invalid @enderror" type="text" id="no_hp" placeholder="Nomor Handphone" name="no_hp" value="{{ $user->no_hp }}">
                  <label for="phone">Nomor Handphone</label>
                  @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="portlet-footer portlet-footer-bordered d-flex justify-content-between">
        <a href="/profile/ubah-password" class="btn btn-link">Ubah password</a>
        <button class="btn btn-primary" type="button" id="btn-ubah-data">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection

@section("script")

<script>
  $(document).ready(function() {
    $("#btn-ubah-data").click(function() {
      Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang anda ubah akan tersimpan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, simpan!'
      }).then((result) => {
        if (result.isConfirmed) {
          $("form").submit();
        }
      })
    })
  })
</script>

@if(session("success"))
{{-- menggunakan sweatalert --}}
<script>
  Swal.fire({
    title: 'Berhasil',
    text: '{{ session("success") }}',
    icon: 'success',
    confirmButtonText: 'OK'
  })
</script>
@endif

@endsection