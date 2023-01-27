@extends("layouts.base")
@section("title", "Pengajuan Peminjaman")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Peminjaman</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Pengajuan</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Formulir Peminjaman</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <form action="/user/peminjaman/pengajuan" method="POST" id="form-pengajuan">
              @csrf
              <input type="hidden" name="kendaraan_id" id="kendaraan_id">
              <input type="hidden" name="driver_id" id="driver_id">
              <div class="row">
                <div class="col-md-6">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('nama') is-invalid @enderror" type="text" id="nama" placeholder="Nama" name="nama" value="{{ Auth::user()->nama }}" readonly>
                      <label for="nama">Nama</label>
                      @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('no_hp') is-invalid @enderror" type="text" id="no_hp" placeholder="No HP" name="no_hp" value="{{ Auth::user()->no_hp }}" readonly>
                      <label for="no_hp">No HP</label>
                      @error('no_hp')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('nama_tujuan') is-invalid @enderror" type="text" id="nama_tujuan" placeholder="Nama Tujuan" name="nama_tujuan" value="{{ old('nama_tujuan') }}">
                      <label for="nama_tujuan">Nama Tujuan</label>
                      @error('nama_tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('alamat_tujuan') is-invalid @enderror" type="text" id="alamat_tujuan" placeholder="Alamat Tujuan" name="alamat_tujuan" value="{{ old('alamat_tujuan') }}">
                      <label for="alamat_tujuan">Alamat Tujuan</label>
                      @error('alamat_tujuan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <textarea class="form-control form-control-lg @error('keperluan') is-invalid @enderror" id="keperluan" placeholder="Keperluan" name="keperluan" rows="5"></textarea>
                      <label for="keperluan">Keperluan</label>
                      @error('keperluan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('tanggal_peminjaman') is-invalid @enderror" type="date" id="tanggal_peminjaman" placeholder="Tanggal Peminjaman" name="tanggal_peminjaman" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" readonly>
                      <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                      @error('tanggal_peminjaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('waktu_peminjaman') is-invalid @enderror" type="time" id="waktu_peminjaman" placeholder="Waktu Peminjaman" name="waktu_peminjaman" value="{{ date('H:i') }}" min="{{ date('H:i') }}" max="16:59">
                      <label for="waktu_peminjaman">Waktu Peminjaman</label>
                      @error('waktu_peminjaman')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="validation-container mb-4">
                    <div class="form-floating">
                      <input class="form-control form-control-lg @error('waktu_selesai') is-invalid @enderror" type="datetime-local" id="waktu_selesai" placeholder="Estimasi Waktu Selesai" name="waktu_selesai" value="{{ date('Y-m-d\TH:i') }}" min="{{ date('Y-m-d\TH:i') }}">
                      <label for="waktu_selesai">Estimasi Waktu Selesai</label>
                      @error('waktu_selesai')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="portlet-footer d-flex justify-content-end">
        <button class="btn btn-primary" type="button" id="btn-ajukan">Ajukan</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#btn-ajukan").on('click',  function () {
      $(this).attr("disabled", true);
      $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

      let nama = $("#nama").val();
      let no_hp = $("#no_hp").val();
      let keperluan = $("#keperluan").val();
      let tanggal_peminjaman = $("#tanggal_peminjaman").val();
      let waktu_peminjaman = $("#waktu_peminjaman").val();
      let waktu_selesai = $("#waktu_selesai").val();
      let form = $("#form-pengajuan");

      $.ajax({
        url: "/user/peminjaman/pengajuan/cek",
        type: "POST",
        data: {
          _token: "{{ csrf_token() }}",
          nama: nama,
          no_hp: no_hp,
          keperluan: keperluan,
          tanggal_peminjaman: tanggal_peminjaman,
          waktu_peminjaman: waktu_peminjaman,
          waktu_selesai: waktu_selesai,
        },
        success: function (data) {
          if(data.status == "success") {
            $("#kendaraan_id").val(data.kendaraan.id);
            $("#driver_id").val(data.driver.id);
            form.submit();
          } else if(data.status == "exist") {
            $("#btn-ajukan").attr("disabled", false);
            $("#btn-ajukan").html("Ajukan");

            Swal.fire({
              title: data.message,
              text: "Dikarenakan peminjaman sedang berlangsung",
              icon: "error",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Ok",
            });
          } else if(data.status == "no_driver") {
            Swal.fire({
              title: data.message,
              text: "Apakah anda ingin melakukan peminjaman tanpa driver?",
              icon: "error",
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Iya",
              cancelButtonText: "Tidak",
              showCancelButton: true,
            }).then(function (result) {
              if (result.isConfirmed) {
                $("#kendaraan_id").val(data.kendaraan.id);
                $("#driver_id").val(0);
                form.submit();
              } else {
                form.submit();
              } 
            });
          } else {
            $("#btn-ajukan").attr("disabled", false);
            $("#btn-ajukan").html("Ajukan");

            Swal.fire({
              title: data.message,
              text: "Apakah anda ingin menunggu antrian?",
              icon: "error",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Iya",
              cancelButtonText: "Tidak",
            }).then(function (result) {
              if (result.isConfirmed) {
                form.submit();
              }
            });

          }
        },
      });
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
    confirmButtonText: "Lihat Detail",
  }).then(function (result) {
    if (result.isConfirmed) {
      window.location.href = "/";
    }
  });
</script>
@endif

{{-- error validate apapun --}}
@if($errors->any())
<script>
  swal.fire({
    title: "Gagal!",
    text: "{{ $errors->first() }}",
    icon: "error",
    confirmButtonColor: "#3085d6",
    confirmButtonText: "Ok",
  });
</script>
@endif

@endsection