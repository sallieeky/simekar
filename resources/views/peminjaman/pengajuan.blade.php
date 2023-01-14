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
            {{-- buat form nama, tanggal_peminjaman, tujuan, keperluan, waktu_peminjaman, waktu_selesai --}}
            <form action="/peminjaman/pengajuan" method="POST">
              @csrf
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
                <div class="col-md-12">
                  <div class="d-flex align-items-baseline gap-3">
                    <button class="btn btn-label-primary mb-4" type="button" id="button-addon2">Pilih Lokasi <i class="fas fa-map-marker-alt"></i></button>
                    <p>Belum ada lokasi</p>
                  </div>
                </div>
                <div class="col-md-12">
                  {{-- keperluan with textarea --}}
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
                      <input class="form-control form-control-lg @error('tanggal_peminjaman') is-invalid @enderror" type="date" id="tanggal_peminjaman" placeholder="Tanggal Peminjaman" name="tanggal_peminjaman" value="{{ date('Y-m-d') }}" readonly>
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
                      <input class="form-control form-control-lg @error('waktu_peminjaman') is-invalid @enderror" type="time" id="waktu_peminjaman" placeholder="Waktu Peminjaman" name="waktu_peminjaman">
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
                      <input class="form-control form-control-lg @error('waktu_selesai') is-invalid @enderror" type="time" id="waktu_selesai" placeholder="Waktu Selesai" name="waktu_selesai">
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
        <button class="btn btn-primary" type="submit">Ajukan</button>
      </div>
    </div>
  </div>
</div>

{{-- Make modal tambah --}}
{{-- <div class="modal fade" id="tambah-modal" tabindex="-1" role="dialog" aria-labelledby="modal-tambah" aria-hidden="true">
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
</div> --}}

{{-- make edit modal with ajax --}}
{{-- <div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="modal-edit" aria-hidden="true">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div> --}}

{{-- make delete modal --}}
{{-- <div class="modal fade" id="hapus-modal" tabindex="-1" role="dialog" aria-labelledby="modal-hapus" aria-hidden="true">
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
</div> --}}

@endsection

@section("script")
{{-- <script>
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
              url: "/master-data/driver/tampilkan/" + id,
              type: "POST",
              data: {
                _token: "{{ csrf_token() }}",
                isShow: value,
              },
              success: function (data) {
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
</script> --}}

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