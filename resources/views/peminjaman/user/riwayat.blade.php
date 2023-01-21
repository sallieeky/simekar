@extends("layouts.base")
@section("title", "Riwayat Peminjaman")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Peminjaman</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Riwayat</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Riwayat Peminjaman</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-driver">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Polisi</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Nama Driver</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>  
                    <th>Tujuan</th>  
                    <th>Keperluan</th>  
                    <th>Nota</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->no_polisi }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->merk }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->tipe }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->driver) {{ $dt->driver->nama }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>{{ $dt->waktuPeminjamanFormated }}</td>
                    <td>{{ $dt->waktuSelesaiFormated }}</td>
                    <td>{{ $dt->tujuan_peminjaman->nama }}</td>
                    <td>{{ $dt->keperluan }}</td>
                    <td>
                      @isset($dt->kendaraan)
                      <a href="{{ $dt->nota }}" target="_blank">
                        <i class="fas fa-file-pdf" style="font-size: 1.5em"></i>
                      </a>
                      @else
                      <span class="text-black-50">Belum tersedia</span>
                      @endisset
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
<script>
  $(document).ready(function () {
    $("#table-driver").DataTable({});

    // make ajax for btn-tampilkan
  //   $("#table-driver").on('click', 'tbody tr td .btn-tampilkan',  function () {
  //     let id = $(this).data("id");
  //     let value = $(this).data("value");
  //     let element = $(this);

  //     swal
  //       .fire({
  //         title: "Apakah anda yakin?",
  //         text: `Kamu akan ${ value == 1 ? "menyembunyikan" : "menampilkan" } driver ini!`,
  //         icon: "warning",
  //         showCancelButton: true,
  //         confirmButtonColor: "#3085d6",
  //         cancelButtonColor: "#d33",
  //         confirmButtonText: `${ value == 1 ? "Sembunyikan" : "Tampilkan" }`,
  //         cancelButtonText: "Batal",
  //       })
  //       .then(function (result) {
  //         if (result.isConfirmed) {
  //           if (value == 1) {
  //             element.data("value", 0);
  //             element.html('<i class="fas fa-eye-slash"></i>');
  //             element.removeClass("btn-label-primary");
  //             element.addClass("btn-label-secondary");
  //           } else {
  //             element.data("value", 1);
  //             element.html('<i class="fas fa-eye"></i>');
  //             element.removeClass("btn-label-secondary");
  //             element.addClass("btn-label-primary");
  //           }
  //           $.ajax({
  //             url: "/master-data/driver/tampilkan/" + id,
  //             type: "POST",
  //             data: {
  //               _token: "{{ csrf_token() }}",
  //               isShow: value,
  //             },
  //             success: function (data) {
  //             },
  //           });
  //         }
  //       });
  //   });

  //   // make ajax for edit
  //   $("#table-driver").on('click', 'tbody tr td .btn-edit', function () {
  //     let id = $(this).data("id");
  //     $.ajax({
  //       url: "/master-data/driver/get/" + id,
  //       type: "GET",
  //       success: function (data) {
  //         console.log(data);
  //         $(".modal-edit-body").html(data);
  //         $("#edit-modal").modal("show");
  //       },
  //     });
  //   });

  //   // make ajax for delete
  //   $("#table-driver").on('click', 'tbody tr td .btn-hapus',function () {
  //     let id = $(this).data("id");
  //     $("#hapus_id").val(id);
  //     $("#hapus-modal").modal("show");
  //   });
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