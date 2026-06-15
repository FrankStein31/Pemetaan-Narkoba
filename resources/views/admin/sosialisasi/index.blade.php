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
    <div class="flash-message" data-flash-message-sosialisasi="{{ session('tambahSosialisasiSukses', '') }}"
    data-delete-sosialisasi="{{ session('deleteSosialisasi', '') }}" data-edit-sosialisasi="{{ session('editSosialisasi', '') }}">
</div>
        <div class="col-md-12 col-lg-12 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
                    <div class="justify-content-start">
                        <button type="button" class="btn btn-xs btn-dark fw-bold p-2 buttonAddPatientQueue"
                            data-bs-toggle="modal" data-bs-target="#formModalSosialisasi">
                            <i class='bx bx-receipt fs-6'></i>&nbsp;TAMBAH SOSIALISASI
                        </button>
                    </div>
                    <div class="justify-content-end">
                        <!-- Search -->
                        {{-- <form action="/admin/pasien/search">
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" id="search"
                                    style="border: 1px solid #d9dee3;" value="{{ request('q') }}"
                                    placeholder="Cari data sosialisasi..." autocomplete="off" />
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
                                        <th class="text-white" >Judul</th>
                                        <th class="text-white" >Deskripsi</th>
                                        <th class="text-white">Kecamatan</th>
                                        <th class="text-white">Desa</th>
                                        <th class="text-white">Gambar</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($sosialisasi as $index => $item)
                                        <tr>
                                            <td>{{ $sosialisasi->firstItem() + $index }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ $item->deskripsi ?? '-' }}</td>

                                            <td>{{ optional($item->kecamatan)->nama_kecamatan }}</td>
                                            <td>{{ optional($item->desa)->nama_desa }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar Sosialisasi"
                                                    width="100">
                                            </td>
                                            <td>

                                                @if ($item->status == 'aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">Nonaktif</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <form action="{{ route('sosialisasi.toggle', $item->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" data-bs-toggle="tooltip"
                                                            title="{{ $item->status }}"
                                                            class="btn btn-sm {{ $item->status == 'aktif' ? 'btn-secondary' : 'btn-success' }}">
                                                            {{ $item->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                                        </button>
                                                    </form>
                                                    <button type="button"
                                                        class="btn btn-icon btn-primary btn-sm buttonEditSosialisasi"
                                                        data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="auto" title="Edit Data Sesialisasi"
                                                        data-code="{{ encrypt($item->id) }}"
                                                        data-judul="{{ $item->judul }}"
                                                        data-deskripsi="{{ $item->deskripsi }}"

                                                    data-kecamatan="{{ $item->kecamatan_id }}"
                                                    data-desa="{{ $item->desa_id }}"
                                                        data-gambar="{{ asset('storage/' . $item->gambar) }}"
                                                        data-time="{{ $item->waktu }}"
                                                        data-description="{{ $item->deskripsi }}">
                                                        <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                                                    </button>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm buttonDeleteSosialisasi"
                                                        data-bs-toggle="tooltip" title="Hapus Sosialisasi"
                                                        data-code="{{ encrypt($item->id) }}"
                                                        data-judul="{{ $item->judul }}">
                                                        <span class="tf-icons bx bx-trash"></span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </ul>
                    {{-- @if (!$wargas->isEmpty())
        <div class="mt-3 pagination-mobile">{{ $wargas->withQueryString()->onEachSide(1)->links() }}</div>
        @endif --}}

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete sosialisasi -->
    <div class="modal fade" id="deleteSosialisasi" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('sosialisasi.delete') }}" method="post" id="formDeleteSosialisasi">
                <input type="hidden" name="codeSosialisasi" id="codeDeleteSosialisasi">
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5'
                                style="margin-bottom: 3px;"></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i
                                class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                data-bs-placement="auto" title="Tutup"></i></button>
                    </div>
                    <div class="modal-body" style="margin-top: -10px;">
                        <div class="col-sm fs-6 judulSosialisasiDelete"></div>
                    </div>
                    <div class="modal-footer" style="margin-top: -5px;">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class='bx bx-share fs-6' style="margin-bottom: 3px;"></i>&nbsp;Tidak</button>
                        <button type="submit" class="btn btn-primary"><i class='bx bx-trash fs-6'
                                style="margin-bottom: 3px;"></i>&nbsp;Ya, Hapus!</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- formModalAdminEditSosialisasi -->
    <div class="modal fade" id="formModalAdminEditSosialisasi" data-bs-backdrop="static" tabindex="-1"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('sosialisasi.edit') }}" method="post" class="modalAdminEditSosialisasi"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name='code' value="{{ old('code') }}" id="codeEditSosialisasi">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Edit Data Sosialisasi&nbsp;<i class='bx bx-user fs-5'
                                style="margin-bottom: 1px;"></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditPatient"
                            data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip"
                                data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="judul" class="form-label required-label">Judul Sosialisasi</label>
                                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    placeholder="Masukkan judul sosialisasi" autocomplete="off" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="deskripsi" class="form-label required-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                    autocomplete="off" placeholder="Masukkan deskripsi sosialisasi. (max 255 karakter)" rows="4" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-2 mt-2">
                            <div class="col">
                                <label for="kecamatan" class="form-label required-label">Kecamatan</label>
                                <select class="form-select @error('kecamatan') is-invalid @enderror" name="kecamatan"
                                    id="kecamatan" style="cursor: pointer;" required>
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}"
                                            {{ old('kecamatan', $item->kecamatan_id) == $kecamatan->id ? 'selected' : '' }}>
                                            {{ $kecamatan->nama_kecamatan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kecamatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="desa" class="form-label required-label">Desa</label>
                                <select class="form-select @error('desa') is-invalid @enderror" name="desa"
                                    id="desa" style="cursor: pointer;" required>
                                    <option value="" disabled selected>Pilih Desa</option>
                                </select>
                                @error('desa')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">

                                <!-- Tampilkan gambar lama jika ada -->
                                <div class="mb-2">
                                    <img id="preview_gambar" src="" alt="Preview Gambar" width="160">
                                    <small class="text-muted d-block">Gambar saat ini</small>

                                </div>
                                <!-- Input untuk upload gambar baru -->
                                <label for="input_gambar" class="form-label">Upload Gambar Baru (Opsional)</label>
                                <input type="file" id="input_gambar" name="gambar"
                                    class="form-control @error('gambar') is-invalid @enderror">
                                @error('gambar')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger cancelModalEditPatient"
                            data-bs-dismiss="modal"><i class='bx bx-share fs-6'
                                style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
                        <button type="submit" class="btn btn-primary"><i class='bx bx-save fs-6'
                                style="margin-bottom: 3px;"></i>&nbsp;Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal tambah sosialisasi-->
    <div class="modal fade" id="formModalSosialisasi" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('sosialisasi.store') }}" method="post" class="modalAdminAddSosialisasi"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Tambah Sosialisasi&nbsp;<i
                                class='bx bx-image-add fs-5'></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalSosialisasi"
                            data-bs-dismiss="modal">
                            <i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" title="Tutup"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="judul" class="form-label required-label">Judul Sosialisasi</label>
                                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                                    class="form-control @error('judul') is-invalid @enderror"
                                    placeholder="Masukkan judul sosialisasi" autocomplete="off" required>
                                @error('judul')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="deskripsi" class="form-label required-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi"
                                    autocomplete="off" placeholder="Masukkan deskripsi sosialisasi. (max 255 karakter)" rows="4" required>{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="kecamatan_id" class="form-label required-label">Kecamatan</label>
                                <select class="form-select @error('kecamatan_id') is-invalid @enderror"
                                    name="kecamatan_id" id="kecamatan_id" style="cursor: pointer;" required>
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                                @error('kecamatan_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">

                                <label for="desa_id" class="form-label required-label">Desa</label>
                                <select class="form-select @error('desa_id') is-invalid @enderror" name="desa_id"
                                    id="desa_id" style="cursor: pointer;" required>
                                    <option value="" disabled selected>Pilih Desa</option>
                                </select>
                                @error('desa_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="gambar" class="form-label required-label">Upload Gambar</label>
                                <input type="file" id="gambar" name="gambar"
                                    class="form-control @error('gambar') is-invalid @enderror" required>
                                @error('gambar')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="status" class="form-label required-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status"
                                    id="status" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="aktif" @if (old('status') == 'aktif') selected @endif>Aktif</option>
                                    <option value="nonaktif" @if (old('status') == 'nonaktif') selected @endif>Nonaktif
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">{{ $message }}</div>
                                @enderror
                            </div>
                        </div> --}}
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger cancelModalSosialisasi"
                            data-bs-dismiss="modal">
                            <i class='bx bx-share fs-6'></i>&nbsp;Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-upload fs-6'></i>&nbsp;Upload
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById('formModalSosialisasi'));
                modal.show();
            });
        </script>
    @endif
@section('script')
<script>
    $(document).ready(function() {
        // Cek apakah ada error validasi dan flag editing_warga
        @if ($errors->any() && session('editing_sosialisasi'))
            $('#modalAdminEditSosialisasi').modal('show');
        @endif
    });
</script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/sosialisasi.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#kecamatan_id').on('change', function() {
                var kecamatan_id = $(this).val(); // Ambil ID kecamatan yang dipilih

                if (kecamatan_id) {
                    $.ajax({
                        url: '/get-desa/' + kecamatan_id, // Panggil API Laravel
                        type: 'GET',
                        success: function(data) {
                            var desaDropdown = $('#desa_id');
                            desaDropdown.empty(); // Kosongkan dropdown desa
                            desaDropdown.append(
                                '<option value="" disabled selected>Pilih Desa</option>');

                            $.each(data, function(key, desa) {
                                desaDropdown.append('<option value="' + desa.id + '">' +
                                    desa.nama_desa + '</option>');
                            });
                        }
                    });
                }
            });
        });
        $(document).ready(function() {
            var oldDesa = "{{ old('desa', $warga->desa_id ?? '') }}"; // Ambil desa lama
            var selectedKecamatan = $('#kecamatan').val(); // Ambil kecamatan yang terpilih saat edit

            function loadDesa(kecamatan_id, selectedDesa = null) {
                if (kecamatan_id) {
                    $.ajax({
                        url: '/get-desa/' + kecamatan_id, // API Laravel untuk mengambil desa
                        type: 'GET',
                        success: function(data) {
                            var desaDropdown = $('#desa');
                            desaDropdown.empty(); // Hapus opsi lama
                            desaDropdown.append('<option value="" disabled>Pilih Desa</option>');

                            $.each(data, function(key, desa) {
                                let selected = desa.id == selectedDesa ? "selected" : "";
                                desaDropdown.append('<option value="' + desa.id + '" ' +
                                    selected + '>' +
                                    desa.nama_desa + '</option>');
                            });
                        }
                    });
                }
            }

            // Jika ada kecamatan yang sudah terpilih (mode edit), maka load desa otomatis
            if (selectedKecamatan) {
                loadDesa(selectedKecamatan, oldDesa);
            }

            // Ketika kecamatan diubah, desa yang sesuai akan muncul
            $('#kecamatan').on('change', function() {
                var kecamatan_id = $(this).val();
                loadDesa(kecamatan_id);
            });
        });
        document.getElementById('input_gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_gambar').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
@endsection
