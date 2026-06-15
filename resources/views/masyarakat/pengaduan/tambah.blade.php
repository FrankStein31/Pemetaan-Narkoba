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


    <div class="flash-message"
    @if(session()->has('tambahPengaduan'))
        data-flash-message-pengaduan="{{ session('tambahPengaduan') }}"
    @endif>
</div>
<div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">

            <div class="authentication-inner" >
                <div class="card" >
                    <div class="card-body">
                        <h4 class="mb-2">Silahkan Buat Pengaduan</h4>
                        <p></p>
                        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap </label>
                                <input type="text" class="form-control" id="nama" name="nama"
                                    placeholder="Masukkan Nama Lengkap (Opsional)">
                            </div>

                            <div class="mb-3">
                                <label for="no_hp" class="form-label">Nomor HP </label>
                                <input type="tel" class="form-control" id="no_hp" name="no_hp"
                                    placeholder="Masukkan Nomor HP (Opsional)">
                            </div>

                            <div class="mb-3">
                                <label for="kategori" class="form-label">Kategori Pengaduan</label>
                                <select class="form-control" id="kategori" name="kategori" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="Peredaran Narkotika">Peredaran Narkotika</option>
                                    <option value="Penyalahgunaan Narkotika">Penyalahgunaan Narkotika</option>
                                    <option value="Permasalahan Lain">Permasalahan Lain</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="lokasi" class="form-label">Lokasi Kejadian</label>
                                <input type="text" class="form-control" id="lokasi" name="lokasi"
                                    placeholder="Masukkan Lokasi Kejadian" required>
                            </div>

                            <div class="mb-3">
                                <label for="waktu" class="form-label">Waktu Kejadian</label>
                                <input type="datetime-local" class="form-control" id="waktu" name="waktu"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi Kejadian</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                                    placeholder="Jelaskan secara rinci tentang kejadian..." required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="bukti" class="form-label">Unggah Bukti </label>
                                <input type="file" class="form-control" id="bukti" name="bukti"
                                    accept="image/*,video/*">
                            </div>

                            <div class="mb-4 divBtn d-flex justify-content-between">
                                <button class="btn btn-danger" type="submit">Kirim Pengaduan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

@section('script')

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



@endsection
@endsection