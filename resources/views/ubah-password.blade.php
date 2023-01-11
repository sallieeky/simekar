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
            <form action="/profile/ubah-password" method="POST">
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
      <div class="portlet-footer portlet-footer-bordered text-end">
        <button class="btn btn-primary" type="submit" id="ubah-data">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>


@endsection

@section("script")

@if(session('error'))
<script>
  toastr.error(`Password lama salah`, `Gagal mengubah`)
</script>
@endif
@if(session('success'))
<script>
  toastr.success(`Berhasil mengubah password`)
</script>
@endif

@endsection