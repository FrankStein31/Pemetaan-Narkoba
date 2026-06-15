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
    <div class="flash-message" data-flash-message-wargas="{{ session('tambahwargaBerhasil', '') }}"
        data-delete-wargas="{{ session('deleteWarga', '') }}" data-edit-wargas="{{ session('editWargaSuccess', '') }}">
    </div>

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
                        <form action="/admin/warga/search">
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" id="search"
                                    style="border: 1px solid #d9dee3;" value="{{ request('q') }}"
                                    placeholder="Cari data warga..." autocomplete="off" />
                            </div>
                        </form>
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
                                        <th class="text-white">NIK</th>
                                        <th class="text-white">Nama</th>
                                        <th class="text-white">Alamat</th>
                                        <th class="text-white">Jenis Kelamin</th>
                                        <th class="text-white">Kecamatan</th>
                                        <th class="text-white">Desa</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($wargas as $index => $warga)
                                        <tr>
                                            <td>{{ $wargas->firstItem() + $index }}</td>
                                            <td>{{ $warga->nik }}</td>
                                            <td>{{ $warga->nama }}</td>
                                            <td>{{ $warga->alamat }}</td>
                                            <td>
                                                @if ($warga->jk == 'Laki-Laki')
                                                <span class="badge bg-label-primary fw-bold">Laki-Laki</span>@else<span
                                                        class="badge fw-bold"
                                                        style="color: #ff6384 !important; background-color: #ffe5eb !important;">Perempuan</span>
                                                @endif
                                            </td>
                                            <td>{{ optional($warga->kecamatan)->nama_kecamatan }}</td>
                                            <td>{{ optional($warga->desa)->nama_desa }}</td>
                                            <td>
                                                @if ($warga->status_narkoba == 'Negatif Narkoba')
                                                    <span class="badge fw-bold"
                                                        style="color: #28a745 !important; background-color: #d4edda !important;">
                                                        {{ $warga->status_narkoba }}
                                                    </span>
                                                @elseif ($warga->status_narkoba == 'Positif Narkoba')
                                                    <span class="badge fw-bold"
                                                        style="color: #ff6384 !important; background-color: #ffe5eb !important;">
                                                        {{ $warga->status_narkoba }}
                                                    </span>
                                                @else
                                                    <span class="badge fw-bold"
                                                        style="color: #6c757d !important; background-color: #e2e3e5 !important;">
                                                        {{ $warga->status_narkoba }}
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="text-center">
                                                <button type="button"
                                                    class="btn btn-icon btn-primary btn-sm buttonEditWarga"
                                                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="auto" title="Edit Data Warga"
                                                    data-code="{{ encrypt($warga->id) }}" data-nik="{{ $warga->nik }}"
                                                    data-nama="{{ $warga->nama }}" data-alamat="{{ $warga->alamat }}"
                                                    data-jk="{{ $warga->jk }}"
                                                    data-kecamatan="{{ $warga->kecamatan_id }}"
                                                    data-desa="{{ $warga->desa_id }}"
                                                    data-status_narkoba="{{ $warga->status_narkoba }}">
                                                    <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-icon btn-danger btn-sm buttonDeleteWarga"
                                                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="auto" title="Hapus Warga"
                                                    data-code="{{ encrypt($warga->id) }}" data-name="{{ $warga->nama }}">
                                                    <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if($wargas->isEmpty())
                <tr>
                  <td colspan="100" class="text-center">Data pasien tidak ditemukan dengan keyword pencarian: <b>"{{request('q')}}"</b></td>
                </tr>
                @endif
                                </tbody>
                            </table>
                        </div>
                    </ul>
                    @if (!$wargas->isEmpty())
                        <div class="mt-3 pagination-mobile">{{ $wargas->withQueryString()->onEachSide(1)->links() }}</div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Delete warga -->
    <div class="modal fade" id="deleteWarga" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('warga.delete') }}" method="post" id="formDeleteWarga">
                <input type="hidden" name="codeWarga" id="codeDeleteWarga">
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Konfirmasi&nbsp;<i class='bx bx-check-shield fs-5'
                                style="margin-bottom: 3px;"></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-dismiss="modal"><i
                                class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip"
                                data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
                    </div>
                    <div class="modal-body" style="margin-top: -10px;">
                        <div class="col-sm fs-6 namaWargaDelete"></div>
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

    <!-- formModalAdminEditWarga -->
    <div class="modal fade" id="modalEditWarga" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="/admin/warga/edit" method="post" class="modalAdminEditWarga" id="formEditWarga">
                @csrf
                <input type="hidden" name="code" id="codeEditWarga">

                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Edit Data Warga&nbsp;<i class='bx bx-user fs-5'></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalEditPatient" data-bs-dismiss="modal">
                            <i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-2">
                                <label for="nik" class="form-label required-label">NIK</label>
                                <input type="text" id="nik" name="nik" class="form-control" required readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="nama" class="form-label required-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2">
                                <label for="alamat" class="form-label required-label">Alamat</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row g-2">
                            <div class="col">
                                <label for="jk" class="form-label required-label">Jenis Kelamin</label>
                                <select class="form-select" name="jk" id="jk" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="Laki-Laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="status_narkoba" class="form-label required-label">Status Narkoba</label>
                                <select class="form-select" name="status_narkoba" id="status_narkoba" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Belum Diketahui">Belum Diketahui</option>
                                    <option value="Negatif Narkoba">Negatif Narkoba</option>
                                    <option value="Positif Narkoba">Positif Narkoba</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-2 mt-2">
                            <div class="col">
                                <label for="kecamatan" class="form-label required-label">Kecamatan</label>
                                <select class="form-select" name="kecamatan" id="kecamatan" required>
                                    <option value="" disabled selected>Pilih Kecamatan</option>
                                    @foreach ($kecamatans as $kecamatan)
                                        <option value="{{ $kecamatan->id }}">{{ $kecamatan->nama_kecamatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label for="desa" class="form-label required-label">Desa</label>
                                <select class="form-select" name="desa" id="desa" required>
                                    <option value="" disabled selected>Pilih Desa</option>
                                    @foreach ($desas as $desa)
                                        <option value="{{ $desa->id }}">{{ $desa->nama_desa }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger cancelModalEditWarga" data-bs-dismiss="modal">
                            <i class='bx bx-share fs-6'></i>&nbsp;Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-save fs-6'></i>&nbsp;Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal tambah warga-->
    <div class="modal fade" id="formModalAdminAddWarga" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ url('/admin/warga') }}" method="post" class="modalAdminAddWarga">
                @csrf
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between">
                        <h5 class="modal-title text-primary fw-bold">Tambah Warga&nbsp;<i class='bx bx-receipt fs-5'
                                style="margin-bottom: 1px;"></i></h5>
                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow cancelModalTakePatientQueue"
                            data-bs-dismiss="modal"><i class="bx bx-x-circle text-danger fs-4" data-bs-toggle="tooltip"
                                data-popup="tooltip-custom" data-bs-placement="auto" title="Tutup"></i></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="nik" class="form-label required-label">NIK</label>
                                <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                                    class="form-control @error('nik') is-invalid @enderror" placeholder="Masukkan NIK"
                                    autocomplete="off" required>
                                @error('nik')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-2 mb-lg-3">
                                <label for="nama" class="form-label required-label">Nama Lengkap</label>
                                <input type="text" id="nama" name="nama" value="{{ old('nama') }}"
                                    class="form-control @error('nama') is-invalid @enderror"
                                    placeholder="Masukkan nama warga" autocomplete="off" required>
                                @error('nama')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">
                                        {{ $message }}
                                    </div>
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
                                <label for="jk" class="form-label required-label">Jenis Kelamin</label>
                                <select class="form-select @error('jk') is-invalid @enderror" name="jk"
                                    id="jk" style="cursor: pointer;" required>
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option id="laki-laki" @if (old('jk') == 'Laki-Laki') selected @endif
                                        value="Laki-Laki">Laki-Laki</option>
                                    <option id="perempuan" @if (old('jk') == 'Perempuan') selected @endif
                                        value="Perempuan">Perempuan</option>
                                </select>
                                @error('jk')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row g-4">
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
                                <label for="alamat" class="form-label required-label">Alamat</label>
                                <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat"
                                    autocomplete="off" placeholder="Masukkan alamat warga. (max 255 karakter)" rows="4" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback" style="margin-bottom: -3px;">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger cancelModalTambahWarga"
                            data-bs-dismiss="modal"><i class='bx bx-share fs-6'
                                style="margin-bottom: 3px;"></i>&nbsp;Batal</button>
                        <button type="submit" class="btn btn-primary"><i class='bx bx-receipt fs-6'
                                style="margin-bottom: 3px;"></i>&nbsp;Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @if ($errors->any())
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var modal = new bootstrap.Modal(document.getElementById('formModalAdminAddWarga'));
                modal.show();
            });
        </script>
    @endif
@section('script')
    <script>
        $(document).ready(function() {
            // Cek apakah ada error validasi dan flag editing_warga
            @if ($errors->any() && session('editing_warga'))
                $('#modalEditWarga').modal('show');
            @endif
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        //     $(document).ready(function () {
        //     // Ambil nilai status dari atribut data-status pada elemen select
        //     let status = $("#statusNarkoba").attr("data-status");

        //     // Set nilai select sesuai dengan status yang diambil
        //     if (status === "Belum Diketahui") {
        //         $("#statusNarkoba").val("Belum Diketahui");
        //     } else if (status === "Negatif Narkoba") {
        //         $("#statusNarkoba").val("Negatif Narkoba");
        //     } else if (status === "Positif Narkoba") {
        //         $("#statusNarkoba").val("Positif Narkoba");
        //     }
        // });
        $(document).on('click', '.btnEditWarga', function () {
    $('#codeEditWarga').val($(this).data('code'));
    $('#nik').val($(this).data('nik'));
    $('#nama').val($(this).data('nama'));
    $('#alamat').val($(this).data('alamat'));
    $('#jk').val($(this).data('jk'));
    $('#status_narkoba').val($(this).data('status'));
    $('#kecamatan').val($(this).data('kecamatan')).trigger('change');

    // Trigger load desa berdasarkan kecamatan
    let desaId = $(this).data('desa');
    setTimeout(() => {
        $('#desa').val(desaId);
    }, 300); // delay biar option-nya sempat loaded

    $('#modalEditWarga').modal('show');
});

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
    </script>
    <script src="{{ asset('assets/js/wargas.js') }}"></script>
@endsection
@endsection
