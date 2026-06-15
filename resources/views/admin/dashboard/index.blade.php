@extends('layouts.main.index')
@section('container')
<style>
  .apexcharts-legend-series {
    display: none;
  }

  .apexcharts-title-text {
    font-size: 1rem;
    font-weight: 700 !important;
  }
  .carousel-control-next-icon {
        filter: invert(50%) brightness(0); /* Mengubah warna menjadi hitam */
    }
    .carousel-control-prev-icon {
        filter: invert(50%) brightness(0); /* Mengubah warna menjadi hitam */
    }
</style>
<div class="row">
  <div class="col-6 col-lg-3 mb-4">
    <div class="card h-100">
      <div class="card-body px-3 py-4-5">
        <div class="row p-2 p-lg-0">
          <div class="col-md-4">
            <div class="stats-icon" style="background-color: #008080;">
              <i class="bx bx-group text-white fs-3"></i>
            </div>
          </div>
          <div class="col-md-8">
            <h6 class="text-muted mt-3 mt-lg-0 fw-bold mb-2">Warga Negatif Narkoba</h6>
            <h6 class="mb-0 fw-bold">{{ $totalwarganegatif }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6 col-lg-3 mb-4">
    <div class="card h-100">
      <div class="card-body px-3 py-4-5">
        <div class="row p-2 p-lg-0">
          <div class="col-md-4">
            <div class="stats-icon" style="background-color: #ff7f50;">
              <i class="bx bx-group text-white fs-3"></i>
            </div>
          </div>
          <div class="col-md-8">
            <h6 class="text-muted mt-3 mt-lg-0 mb-2 fw-bold">Laporan Pengaduan Online</h6>
            <h6 class="mb-0 fw-bold">{{ $totalpengaduan }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-6 col-lg-3 mb-4">
    <div class="card h-100">
      <div class="card-body px-3 py-4-5">
        <div class="row p-2 p-lg-0">
          <div class="col-md-4">
            <div class="stats-icon" style="background-color: #800080 ;">
              <i class="bx bx-group text-white fs-3"></i>
            </div>
          </div>
          <div class="col-md-8">
            <h6 class="text-muted mt-3 mt-lg-0 mb-2 fw-bold">Data Pengaduan Offline</h6>
            <h6 class="mb-0 fw-bold">{{ $totaladuan }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="col-6 col-lg-3 mb-4">
    <div class="card h-100">
      <div class="card-body px-3 py-4-5">
        <div class="row p-2 p-lg-0">
          <div class="col-md-4">
            <div class="stats-icon" style="background-color: #6a5acd;">
              <i class="bx bx-group text-white fs-3"></i>
            </div>
          </div>
          <div class="col-md-8">
            <h6 class="text-muted mt-3 mt-lg-0 mb-2 fw-bold">Total Warga</h6>
            <h6 class="mb-0 fw-bold">{{ $totalwarga }}</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-6 col-lg-5 order-0 mb-4">
    <div class="card h-100">
      <div class="card-header">
        <div>
          <h5 class="card-title m-0 me-2 fw-bold mb-2" style="font-family: poppins; font-size:1rem;">Data Antrian</h5>
          <small class="text-muted" style="font-family: poppins; font-size:12px; color:rgb(86, 106, 127) !important;">Berikut daftar nomor antrian pengadu hari ini</small>
        </div>
      </div>
      <div class="card-body">
        @if(!$patients->isEmpty())
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="d-flex flex-column align-items-center gap-1">
          <h2 class="mb-2 fw-bold" style="color:#566a7f;">
  {{ optional($numberQueueNow->queueNumber)->number ?? 'Tidak ada antrian' }}
</h2>
            <span>Nomor Antrian Sekarang</span>
          </div>
          <div id="usersChart" data-laki-laki="{{ $totalLakiLaki }}" data-perempuan="{{ $totalPerempuan }}"></div>
        </div>
        <ul class="p-0 m-0">
          @foreach($patients as $patient)
          <li class="d-flex mb-4 pb-1">
            <div class="avatar flex-shrink-0 me-3">
              @if($patient->gender == 'Perempuan')
              <img src="{{ asset('assets/img/profil-images-default/girl.jpeg') }}" alt="Profile Image" class="rounded">
              @else
              <img src="{{ asset('assets/img/profil-images-default/man.jpeg') }}" alt="Profile Image" class="rounded">
              @endif
            </div>
            <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
              <div class="me-2">
                <h6 class="mb-1 text-capitalize">{{ $patient->name }}</h6>
                <small class="text-muted d-block">{{ Str::limit($patient->created_at->locale('id')->diffForHumans(), 30, '...') }}</small>
              </div>
              <div class="user-progress d-flex align-items-center gap-1">
              <span class="badge badge-center bg-info rounded-pill">
  {{ optional($patient->queueNumber)->number ?? 'No Queue' }}
</span>

              </div>
            </div>
          </li>
          @endforeach
        </ul>
        @else
        <p class="text-center"><i class="bx bx-info-circle fs-6" style="margin-bottom: 2px;"></i>&nbsp;Belum ada antrian</p>
        @endif
      </div>
    </div>
  </div>

  <div class="col-md-6 col-lg-7 order-2 mb-4">
    <div class="card h-100">
      <div class="card-body">
        <h5 class="card-title">Grafik Pasien Positif Narkoba</h5>
        <canvas id="grafikPasien"></canvas>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-lg-12 order-0 mb-4">
    <div class="card h-1000">
      <div class="card-body">
        @if ($sosialisasi->count() > 0)
                        <div id="sosialisasiCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($sosialisasi as $index => $item)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                            <h5 style="color: #ff5733; font-weight: bold; text-transform: uppercase;
                                                    text-shadow: 2px 2px 5px rgb(0, 0, 0);
                                                    border-bottom: 3px solid #ff5733;
                                                    display: block; padding-bottom: 5px;
                                                    text-align: center; font-size: 40px;">
                                                {{ $item->judul }}
                                            </h5>
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Sosialisasi"
                                                class="img-fluid w-10">
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tombol Prev -->
                            <button class="carousel-control-prev" type="button" data-bs-target="#sosialisasiCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <!-- Tombol Next -->
                            <button class="carousel-control-next" type="button" data-bs-target="#sosialisasiCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        </div>
                    @endif

        {{-- @if ($sosialisasi)
    <div class="text-center">
        <h5>{{ $sosialisasi->judul }}</h5>
        <img src="{{ asset('storage/' . $sosialisasi->gambar) }}" alt="Sosialisasi" class="img-fluid">
    </div>
@endif --}}
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    fetch('/api/grafik-positif')
        .then(res => res.json())
        .then(data => {
            const labels = data.map(item => item.bulan);
            const jumlah = data.map(item => item.total);

            const ctx = document.getElementById('grafikPasien').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Pasien Positif Narkoba',
                        data: jumlah,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        tension: 0.3,
                        fill: true,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
});
</script>

@endsection
