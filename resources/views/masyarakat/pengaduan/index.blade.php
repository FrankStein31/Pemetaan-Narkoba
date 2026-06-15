@extends('layouts.main.index')
@section('container')
    <style>
        ::-webkit-scrollbar {
            display: none;
        }

        @media screen and (min-width: 1320px) {
            #search {
                width: 250px;
            }
        }

        @media screen and (max-width: 575px) {
            .pagination-mobile {
                display: flex;
                justify-content: end;
            }
        }
    </style>
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <div class="flash-message" data-edit-patient="@if(session()->has('deletePengaduan')) {{ session('deletePengaduan') }} @endif" data-delete-pengaduan="@if(session()->has('deletePengaduan')) {{ session('deletePengaduan') }} @endif"></div>
<div class="row">
    <div class="col-md-12 col-lg-12 order-2 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
                <div class="justify-content-start">
                    <button type="button" class="btn btn-xs btn-dark fw-bold p-2 buttonAddPatientQueue"
                        data-bs-toggle="modal" data-bs-target="#formModalAdminAddWarga">
                        <i class='bx bx-receipt fs-6'></i>&nbsp;TAMBAH DATA
                    </button>
                </div>
                <div class="justify-content-end">
                    <!-- Search -->
                    {{-- <form action="/admin/pasien/search">
                        <div class="input-group">
                            <input type="search" class="form-control" name="q" id="search"
                                style="border: 1px solid #d9dee3;" value="{{ request('q') }}"
                                placeholder="Cari data pengaduan..." autocomplete="off" />
                        </div>
                    </form> --}}
                    <!-- /Search -->
                </div>
            </div>
            <div class="card-body">
                <ul class="p-0 m-0">
                    <div class="table-responsive text-nowrap" style="border-radius: 3px;">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-white">No</th>
                                    <th class="text-white">Nama</th>
                                    <th class="text-white">No HP</th>
                                    <th class="text-white">Jenis Aduan</th>
                                    <th class="text-white">Alamat</th>
                                    <th class="text-white">Tanggal Kejadian</th>
                                    <th class="text-white">Deskripsi</th>
                                    <th class="text-white">Bukti</th>
                                    <th class="text-white text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @foreach ($pengaduans as $index => $pengaduan)
    <tr>
        <td>{{ $pengaduans->firstItem() + $index }}</td>
        <td>{{ $pengaduan->nama }}</td>
        <td>{{ $pengaduan->no_hp }}</td>
        <td>{{ $pengaduan->kategori }}</td>
        <td>{{ $pengaduan->lokasi }}</td>
        <td>{{ \Carbon\Carbon::parse($pengaduan->waktu)->isoFormat('D MMMM YYYY | H:mm') }}</td>
        <td>{{ $pengaduan->deskripsi }}</td>
        <td>
            @if ($pengaduan->bukti)
                <a href="{{ asset('storage/' . $pengaduan->bukti) }}" target="_blank" class="badge bg-label-primary fw-bold">Lihat Bukti</a>
            @else
                <span class="badge bg-label-danger fw-bold">Tidak Ada Bukti</span>
            @endif
        </td>
        <td class="text-center">
            {{-- <button type="button"
                    class="btn btn-icon btn-primary btn-sm buttonEditPengaduan"
                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                    data-bs-placement="auto" title="Edit Data Pengaduan"
                    data-code="{{ encrypt($pengaduan->id) }}" data-name="{{ $pengaduan->nama }}"
                    data-category="{{ $pengaduan->kategori }}" data-location="{{ $pengaduan->lokasi }}"
                    data-time="{{ $pengaduan->waktu }}" data-description="{{ $pengaduan->deskripsi }}"
                    data-evidence="{{ $pengaduan->bukti }}">
                <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
            </button> --}}
            {{-- <button type="button"
                    class="btn btn-icon btn-danger btn-sm buttonDeletePengaduan"
                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                    data-bs-placement="auto" title="Delete Pengaduan"
                    data-code="{{ encrypt($pengaduan->id) }}" data-name="{{ $pengaduan->nama }}">
                <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>

            </button> --}}
            <button type="button" class="btn btn-icon btn-danger btn-sm buttonDeletePengaduan" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Delete Pengaduan" data-code="{{ encrypt($pengaduan->id) }}" data-name="{{ $pengaduan->nama }}">
                <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
              </button>
        </td>

    </tr>
@endforeach

                            </tbody>
                        </table>
                    </div>
                </ul>
                @if(!$pengaduans->isEmpty())
                <div class="mt-3 pagination-mobile">{{ $pengaduans->withQueryString()->onEachSide(1)->links() }}</div>
                @endif

            </div>
        </div>
    </div>
</div>

{{-- modal delete --}}
<div class="modal fade" id="deletePengaduan" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <form action="{{ route('pengaduan.delete') }}" method="post" id="formDeletePengaduan">
        <input type="hidden" name="codePengaduan" id="codeDeletePengaduan">
        @csrf
        <div class="modal-content">
          <div class="modal-header d-flex justify-content-between">
            <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5' style="margin-bottom: 3px;"></i></h5>
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
          </div>
          <div class="modal-body" style="margin-top: -10px;">
            <div class="col-sm fs-6 namaPengaduanDelete"></div>
          </div>
          <div class="modal-footer" style="margin-top: -5px;">
            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tidak</button>
            <button type="submit" class="btn btn-primary"><i class='bx bx-trash fs-6' style="margin-bottom: 3px;"></i>&nbsp;Ya, Hapus!</button>
          </div>
        </div>
      </form>
    </div>
  </div>
@section('script')

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(".buttonDeletePengaduan").on("click", function () {
    const code = $(this).data("code");
    const name = $(this).data("name");
    $("#codeDeletePengaduan").val(code);
    $(".namaPengaduanDelete").html(
        "Delete laporan pengaduan atas nama <strong>" + name + "</strong> ?"
    );
    $("#deletePengaduan").modal("show");
});


</script>


@endsection
@endsection