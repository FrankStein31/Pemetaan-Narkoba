<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>{{ $title }}</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="/medilab/assets/img/Logo_BNN.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/core.css') }}"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/theme.css') }}"
        class="template-customizer-theme-css" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/pages/page-auth.css') }}" />
    <script src="{{ asset('assets/vendors/assets/vendor/js/helpers.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.css') }}">
    <script src="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/toast.css') }}">
    <script src="{{ asset('assets/vendors/assets/js/config.js') }}"></script>
</head>

<body>


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
                        <div class="app-brand justify-content-center align-items: center;">
                            <img src="/medilab/assets/img/bnn.png" alt="Logo" width="350">
                        </div>
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
                                <button class="btn btn-secondary" type="button" onclick="window.location.href='/'">Kembali</button>
                                <button class="btn btn-danger" type="submit">Kirim Pengaduan</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/vendors/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendors/assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>
