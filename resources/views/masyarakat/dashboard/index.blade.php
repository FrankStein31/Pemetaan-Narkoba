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
        <div class="col-md-12 col-lg-12 order-0 mb-4">
            <div class="card h-1000">
                <div class="card-body">
                    {{-- @if ($sosialisasi)
                        <div style="display: flex; flex-direction: column; align-items: center;">
                            <h5
                                style="color: #ff5733; font-weight: bold; text-transform: uppercase;
                                       text-shadow: 2px 2px 5px rgba(0,0,0,0.2);
                                       border-bottom: 3px solid #ff5733;
                                       display: block; padding-bottom: 5px; text-align: center;  font-size: 40px;">
                                {{ $sosialisasi->judul }}
                            </h5>
                            <img src="{{ asset('storage/' . $sosialisasi->gambar) }}" alt="Sosialisasi"
                                class="img-fluid w-50">

                        </div>
                    @endif --}}
                    @if ($sosialisasi->count() > 0)
                        <div id="sosialisasiCarousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                @foreach ($sosialisasi as $index => $item)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div style="display: flex; flex-direction: column; align-items: center;">
                                            <h5 style="color: #ff5733; font-weight: bold; text-transform: uppercase;
                                                    text-shadow: 2px 2px 5px rgba(0,0,0,0.2);
                                                    border-bottom: 3px solid #ff5733;
                                                    display: block; padding-bottom: 5px;
                                                    text-align: center; font-size: 40px;">
                                                {{ $item->judul }}
                                            </h5>
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Sosialisasi"
                                                class="img-fluid w-50">
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

                </div>
            </div>
        </div>
    </div>


    <script src="{{ $chart->cdn() }}"></script>

    {!! $chart->script() !!}
@endsection
