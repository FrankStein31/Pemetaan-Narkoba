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

                    </div>
                    <div class="justify-content-end">
                        <!-- Search -->
                        <form action="/warga-positif/search">
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" id="search"
                                    style="border: 1px solid #d9dee3;" value="{{ request('q') }}"
                                    placeholder="Cari data pasien..." autocomplete="off" />
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
                                        <th class="text-white">Kecamatan</th>
                                        <th class="text-white">Desa</th>
                                        <th class="text-white">Status</th>
                                        <th class="text-white">Golongan</th>
                                        <th class="text-white">Jenis Golongan</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach ($wargas as $index => $warga)
                                        <tr>
                                            <td>{{ $wargas->firstItem() + $index }}</td>
                                            <td>{{ $warga->nik }}</td>
                                            <td>{{ $warga->nama }}</td>
                                            <td>{{ $warga->alamat }}</td>
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
                                            <td>{{ $warga->golongan }}</td>
                                            <td>{{ $warga->jenis_golongan }}</td>
                                        </tr>
                                    @endforeach
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

@section('script')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="{{ asset('assets/js/wargas.js') }}"></script>
@endsection
@endsection
