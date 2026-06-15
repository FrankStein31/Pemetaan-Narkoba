<!DOCTYPE html>
<html lang="id" class="light-style customizer-hide" dir="ltr" data-theme="theme-default">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>{{ $title }}</title>
  <meta name="description" content="" />
  <link rel="icon" type="image/x-icon" href="/medilab/assets/img/Logo_BNN.png" />  
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/fonts/boxicons.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/core.css') }}" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/theme.css') }}" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/vendors/assets/vendor/css/pages/page-auth.css') }}" />
  <script src="{{ asset('assets/vendors/assets/vendor/js/helpers.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.css') }}">
  <script src="{{ asset('assets/vendors/libs/sweetalert2/sweetalert.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('assets/css/toast.css') }}">
  <script src="{{ asset('assets/vendors/assets/js/config.js') }}"></script>
</head>

<body>
  <div class="container-xxl">
    <div class="authentication-wrapper authentication-basic container-p-y">
      
      <div class="authentication-inner">
        <div class="card">
          <div class="card-body">
          <!-- <div style="display: flex; justify-content: center;  height: 200px;">
    <img src="/medilab/assets/img/bnn.png" alt="Logo" width="350">
</div> -->
            <div class="app-brand justify-content-center align-items: center;">
              <!-- <a href="/" class="app-brand-link gap-2"> -->
              <img src="/medilab/assets/img/bnn.png" alt="Logo" width="350"  >
            </div>
            <h4 class="mb-2">Silahkan Buat Akun</h4>
            <p ></p>
            
            <form action="{{ route('registrasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan Nama Lengkap" required />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan Email" required />
                </div>
                <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username" required />
                </div>
                <div class="mb-3">
                  <label for="gender" class="form-label">Jenis Kelamin</label>
                  <select class="form-control" id="gender" name="gender" required>
                    <option value="">Pilih Gender</option>
                    <option value="Male">Laki-laki</option>
                    <option value="Female">Perempuan</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label for="alamat" class="form-label">Alamat</label>
                  <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                  <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required />
                </div>
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required />
                </div>
                <div class="mb-4 divBtn" style="cursor: not-allowed;">
                    <button class="btn btn-primary d-grid w-100" type="submit">Buat Akun</button>
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
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>