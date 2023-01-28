@extends("layouts.base")
@section("title", "Pengajuan Reimbursement")
@section("breadcrumb")
<a href="#" class="breadcrumb-item">
  <span class="breadcrumb-text">Reimbursement</span>
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
        <h3 class="portlet-title">Formulir Pengajuan Reimbursement ( {{ Carbon\Carbon::parse(date('d-m-Y'))->translatedFormat('l, d M Y') }} )</h3>
      </div>
      <div class="portlet-body">
        <div class="row">
          <div class="col-md-12">
            <form action="/user/reimbursement/pengajuan" method="POST" id="form-pengajuan">
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
                <div class="col-md-4">
                  <label for="no_hp">Kendaraan</label>
                  <select class="form-select form-select-lg @error('kendaraan_id') is-invalid @enderror" name="kendaraan_id">
                    <option value="">Pilih Kendaraan</option>
                    @foreach ($kendaraan as $item)
                      <option value="{{ $item->id }}">{{ $item->no_polisi }} - {{ $item->merk }} ({{ $item->tipe }})</option>
                    @endforeach
                  </select>
                  @error('kendaraan_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="col-md-4">
                  <label for="km_tempuh">KM pada kendaraan</label>
                  <input class="form-control form-control-lg @error('km_tempuh') is-invalid @enderror" type="number" id="km_tempuh" placeholder="KM tempuh" name="km_tempuh" value="{{ old('km_tempuh') }}">
                  @error('km_tempuh')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                {{-- input nominal with prefix Rp. --}}
                <div class="col-md-4">
                  <label for="nominal">Nominal pengajuan</label>
                  <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="number" id="nominal" name="nominal" class="form-control form-control-lg" aria-label="Nominal rupiah" placeholder="Nominal (Rp)">
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
      Swal.fire({
        title: "Apakah anda yakin?",
        text: "Anda akan mengajukan pengajuan reimbursement",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Ajukan",
        cancelButtonText: "Batal",
      }).then(function (result) {
        if (result.isConfirmed) {
          $("#form-pengajuan").submit();
        }
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

{{-- session fail --}}
@if (session('fail'))
<script>
  Swal.fire({
    title: "Gagal!",
    text: "{{ session('fail') }}",
    icon: "error",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Ok",
  });
</script>
@endif


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