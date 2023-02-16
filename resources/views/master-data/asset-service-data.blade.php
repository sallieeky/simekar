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
  <div class="col-md-12">
    <div class="portlet">
      <div class="portlet-header portlet-header-bordered">
        <div class="portlet-icon">
          {{-- icon document --}}
          <i class="fa fa-file-text"></i>
        </div>
        <h3 class="portlet-title">Tambah Data</h3>
        <div class="portlet-addon">
          <!-- BEGIN Nav -->
          <div class="nav nav-pills portlet-nav" id="portlet6-tab">
            <a class="nav-item nav-link active" id="portlet6-home-tab" data-bs-toggle="tab" href="#tab-aset">Aset</a>
            <a class="nav-item nav-link" id="portlet6-profile-tab" data-bs-toggle="tab" href="#tab-service">Service</a>
          </div>
          <!-- END Nav -->
        </div>
      </div>
      <div class="portlet-body">
        <!-- BEGIN Tab -->
        <div class="tab-content">
          <div class="tab-pane fade active show" id="tab-aset">
            <form action="/master-data/asset-service/data/aset" method="post" id="form-tambah-aset">
              @csrf
              <div class="row">
                <div class="col-md-12 mb-3">
                  <label for="kendaraan_id">Kendaraan</label>
                  <select class="form-select @error('kendaraan_id') is-invalid @enderror" name="kendaraan_id" id="kendaraan_id">
                    <option value="">Pilih Kendaraan</option>
                    @foreach ($kendaraan as $dt)
                      <option value="{{ $dt->id }}" @if (old('kendaraan_id') == $dt->id) selected @endif>{{ $dt->no_polisi }} - {{ $dt->merk }} ({{ $dt->tipe }})</option>
                    @endforeach
                  </select>
                  @error('kendaraan_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="no_aset">Nomor Aset</label>
                  <input type="text" class="form-control @error('no_aset') is-invalid @enderror" name="no_aset" id="no_aset" placeholder="Nomor Aset" value="{{ old('no_aset') }}">
                  @error('no_aset')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="no_polis">Nomor Polis</label>
                  <input type="text" class="form-control @error('no_polis') is-invalid @enderror" name="no_polis" id="no_polis" placeholder="Nomor Polis" value="{{ old('no_polis') }}">
                  @error('no_polis')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="no_rangka">Nomor Rangka</label>
                  <input type="text" class="form-control @error('no_rangka') is-invalid @enderror" name="no_rangka" id="no_rangka" placeholder="Nomor Rangka" value="{{ old('no_rangka') }}">
                  @error('no_rangka')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="no_mesin">Nomor Mesin</label>
                  <input type="text" class="form-control @error('no_mesin') is-invalid @enderror" name="no_mesin" id="no_mesin" placeholder="Nomor Mesin" value="{{ old('no_mesin') }}">
                  @error('no_mesin')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="masa_pajak">Masa Pajak</label>
                  <input type="date" class="form-control @error('masa_pajak') is-invalid @enderror" name="masa_pajak" id="masa_pajak" placeholder="Masa Pajak" value="{{ old('masa_pajak') }}">
                  @error('masa_pajak')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="masa_stnk">Masa STNK</label>
                  <input type="date" class="form-control @error('masa_stnk') is-invalid @enderror" name="masa_stnk" id="masa_stnk" placeholder="Masa STNK" value="{{ old('masa_stnk') }}">
                  @error('masa_stnk')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="masa_asuransi">Masa Asuransi</label>
                  <input type="date" class="form-control @error('masa_asuransi') is-invalid @enderror" name="masa_asuransi" id="masa_asuransi" placeholder="Masa Asuransi" value="{{ old('masa_asuransi') }}">
                  @error('masa_asuransi')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-3 mb-3">
                  <label for="tgl_service_rutin">Tanggal Service Rutin</label>
                  <input type="date" class="form-control @error('tgl_service_rutin') is-invalid @enderror" name="tgl_service_rutin" id="tgl_service_rutin" placeholder="Tanggal Service Rutin" value="{{ old('tgl_service_rutin') }}">
                  @error('tgl_service_rutin')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                {{-- year tahun_pembuatan, tahun_pengadaan --}}
                <div class="col-md-6 mb-3">
                  <label for="tahun_pembuatan">Tahun Pembuatan</label>
                  {{-- input number min 1700 max this year --}}
                  <input type="number" class="form-control @error('tahun_pembuatan') is-invalid @enderror" name="tahun_pembuatan" id="tahun_pembuatan" placeholder="Tahun Pembuatan" value="{{ old('tahun_pembuatan') }}" min="1700" max="{{ date('Y') }}">
                  @error('tahun_pembuatan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-6 mb-3">
                  <label for="tahun_pengadaan">Tahun Pengadaan</label>
                  <input type="number" class="form-control @error('tahun_pengadaan') is-invalid @enderror" name="tahun_pengadaan" id="tahun_pengadaan" placeholder="Tahun Pengadaan" value="{{ old('tahun_pengadaan') }}" min="1700" max="{{ date('Y') }}">
                  @error('tahun_pengadaan')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <button class="btn btn-primary" type="submit" id="btn-tambah-aset">Tambah</button>
                </div>
              </div>
            </form>
          </div>
          <div class="tab-pane fade" id="tab-service">
            <form action="/master-data/asset-service/data/service" method="post" id="form-tambah-service">
              @csrf
              <div class="row">
                <div class="col-md-4 mb-3">
                  <label for="kendaraan_id_service">Kendaraan</label>
                  <select class="form-select @error('kendaraan_id_service') is-invalid @enderror" name="kendaraan_id_service" id="kendaraan_id_service">
                    <option value="">Pilih Kendaraan</option>
                    @foreach ($kendaraanService as $dt)
                      <option value="{{ $dt->id }}" @if (old('kendaraan_id_service') == $dt->id) selected @endif>{{ $dt->no_polisi }} - {{ $dt->merk }} ({{ $dt->tipe }})</option>
                    @endforeach
                  </select>
                  @error('kendaraan_id_service')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-4 mb-3">
                  <label for="kode">Kode Service</label>
                  <select class="form-select @error('kode') is-invalid @enderror" name="kode" id="kode">
                    <option value="">Pilih Kode Service</option>
                    @foreach ($kodeService as $dt)
                      <option value="{{ $dt['code'] }} - {{ $dt['keterangan'] }}" @if (old('kode') == $dt['code'] . '-' . $dt['keterangan']) selected @endif>{{ $dt['code'] }} - {{ $dt['keterangan'] }}</option>
                    @endforeach
                  </select>
                  @error('kode')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-4 mb-3">
                  <label for="tgl_service">Tanggal Service</label>
                  <input type="date" class="form-control @error('tgl_service') is-invalid @enderror" name="tgl_service" id="tgl_service" placeholder="Tanggal Service" value="{{ old('tgl_service') }}">
                  @error('tgl_service')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-12 mb-3">
                  <label for="uraian">Uraian</label>
                  <textarea class="form-control @error('uraian') is-invalid @enderror" name="uraian" id="uraian" rows="3">{{ old('uraian') }}</textarea>
                  @error('uraian')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>
                <div class="col-md-12">
                  <button class="btn btn-primary" type="submit" id="btn-tambah-service">Tambah</button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <!-- END Tab -->
      </div>
    </div>
  </div>
</div>

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

    $("#btn-tambah-aset").click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Tambah Aset",
        text: "Apakah anda yakin ingin menambahkan aset ini?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#form-tambah-aset").submit();
        }
      });
    });

    $("#btn-tambah-service").click(function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Tambah Service",
        text: "Apakah anda yakin ingin menambahkan service ini?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Ya",
        cancelButtonText: "Tidak",
      }).then((result) => {
        if (result.isConfirmed) {
          $("#form-tambah-service").submit();
        }
      });
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