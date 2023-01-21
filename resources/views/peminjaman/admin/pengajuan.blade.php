@extends("layouts.base")
@section("title", "Data Pengajuan Peminjaman")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Peminjaman</span>
</a>
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Data Pengajuan Peminjaman</span>
</a>
@endsection
@section("content")

<div class="row">
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header d-flex justify-content-between">
        <h3 class="portlet-title">Data Pengajuan Peminjaman Hari Ini ( {{ Carbon\Carbon::parse(date('d-m-Y'))->translatedFormat('l, d M Y') }} )</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover" id="table-driver">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Nomor Polisi</th>
                    <th>Merk</th>
                    <th>Tipe</th>
                    <th>Nama Driver</th>
                    <th>Waktu Pinjam</th>
                    <th>Waktu Kembali</th>  
                    <th>Tujuan</th>  
                    <th>Keperluan</th>  
                    <th>Status</th>  
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $dt)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $dt->user->nama }}</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->no_polisi }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->merk }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->kendaraan) {{ $dt->kendaraan->tipe }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>@isset($dt->driver) {{ $dt->driver->nama }} @else <span class="text-black-50">Belum tersedia</span> @endisset</td>
                    <td>
                      {{ Carbon\Carbon::parse($dt->waktu_peminjaman)->translatedFormat('H:i') }}
                    </td>
                    <td>
                      {{ Carbon\Carbon::parse($dt->waktu_selesai)->translatedFormat('H:i') }}
                    </td>
                    <td>{{ $dt->tujuan_peminjaman->nama }}</td>
                    <td>{{ $dt->keperluan }}</td>
                    <td>
                      @if ($dt->status == 'menunggu')
                        <span class="badge bg-secondary">Antrian</span>
                      @elseif ($dt->status == 'dipakai')
                        <span class="badge bg-primary">Dipakai</span>
                      @elseif ($dt->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                      @endif
                    </td>
                    <td>
                      @if ($dt->status == 'dipakai')
                      <form action="/peminjaman/selesai/{{ $dt->id }}" method="POST" class="form-selesai">
                        @csrf
                        <button type="button" class="btn btn-success btn-selesai">Selesai</button>
                      </form>
                      @elseif ($dt->status = "menunggu")
                      <form action="/peminjaman/batal/{{ $dt->id }}" method="POST" class="form-batal">
                        @csrf
                        <button type="button" class="btn btn-danger btn-batal">Batal</button>
                      </form>
                      @endif
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

@endsection

@section("script")
<script>
  $(document).ready(function () {
    $("#table-driver").DataTable({});

    $(".btn-batal").click(function () {
      Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda akan membatalkan peminjaman ini",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).parent().submit();
        }
      });
    });

    $(".btn-selesai").click(function () {
      Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda akan menyelesaikan peminjaman ini",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.isConfirmed) {
          $(this).parent().submit();
        }
      });
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