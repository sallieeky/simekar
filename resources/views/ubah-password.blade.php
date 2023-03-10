@extends("layouts.base")
@section("title", "Ubah Password")
@section("breadcrumb")
<a href="/profile" class="breadcrumb-item">
  <span class="breadcrumb-text">Profile</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Ubah Password</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header">
        <h3 class="portlet-title">Ubah Password</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <form action="/profile/ubah-password" method="POST" id="form-ubah-password">
              @csrf
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg @error('password_lama') is-invalid @enderror" type="password" id="password_lama" placeholder="Password Lama" name="password_lama">
                  <label for="password_lama">Password Lama</label>
                  @error('password_lama')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg @error('password_baru') is-invalid @enderror" type="password" id="password_baru" placeholder="Password Baru" name="password_baru">
                  <label for="password_baru">Password Baru</label>
                  @error('password_baru')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="validation-container mb-4">
                <div class="form-floating">
                  <input class="form-control form-control-lg @error('konfirmasi_password_baru') is-invalid @enderror" type="password" id="konfirmasi_password_baru" placeholder="Konfirmasi Password Baru" name="konfirmasi_password_baru">
                  <label for="konfirmasi_password_baru">Konfirmasi Password Baru</label>
                  @error('konfirmasi_password_baru')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="portlet-footer portlet-footer-bordered d-flex justify-content-between">
        <a href="/profile" class="btn btn-link">Kembali ke profile</a>
        <button class="btn btn-primary" type="button" id="btn-ubah-password">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection

@section("script")

<script>
  $("#btn-ubah-password").click(function() {
    Swal.fire({
      title: 'Konfirmasi',
      text: "Apakah anda yakin ingin mengubah password?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, ubah password!',
      cancelButtonText: 'Tidak'

    }).then((result) => {
      if (result.isConfirmed) {
        $("#form-ubah-password").submit()
      }
    })
  })
</script>

@if(session('error'))
{{-- menggunakan sweatalert --}}
<script>
  Swal.fire({
    icon: 'error',
    title: 'Gagal mengubah password',
    text: 'Password lama salah',
  })
</script>
@endif

@if(session('success'))
{{-- menggunakan sweatalert --}}
<script>
  Swal.fire({
    icon: 'success',
    title: 'Berhasil mengubah password',
    text: 'Password berhasil diubah',
  })
</script>
@endif

@endsection