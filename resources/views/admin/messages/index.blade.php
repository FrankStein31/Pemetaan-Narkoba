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
    <div class="row">
        <div class="col-md-12 col-lg-12 order-2 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between" style="margin-bottom: -0.7rem;">
                    <div class="justify-content-start">
                    </div>
                    <div class="justify-content-end">

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
                                        <th class="text-white">Email</th>
                                        <th class="text-white">Subjek</th>
                                        <th class="text-white">Pesan</th>
                                        {{-- <th class="text-white">Status</th>
                                        <th class="text-white">Feedback</th>
                                        @if(auth()->check() && auth()->user()->is_admin == 1)
                                        <th class="text-white text-center">Aksi</th>
                                    @endif --}}
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @foreach($messages as $index => $message)
                                    <tr>
                                        <td>{{ $messages->firstItem() + $index }}</td>
                                        <td>{{ $message->nama }}</td>
                                        <td>{{ $message->email }}</td>
                                        <td>{{ $message->subject }}</td>
                                        <td>{{ $message->message }}</td>
                                        {{-- <td>{{ $message->status }}</td>
                                        <td>{{ $message->admin_feedback }}</td> --}}
                                        @if(auth()->check() && auth()->user()->is_admin == 1)
                                        {{-- <td>
                                            <button type="button"
                                                    class="btn btn-icon btn-primary btn-sm buttonEditWarga"
                                                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="auto" title="Edit Data Warga"
                                                    >
                                                    <span class="tf-icons bx bx-edit" style="font-size: 15px;"></span>
                                                </button>
                                                <button type="button"
                                                    class="btn btn-icon btn-danger btn-sm buttonDeleteWarga"
                                                    data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                    data-bs-placement="auto" title="Hapus Warga"
                                                    >
                                                    <span class="tf-icons bx bx-trash" style="font-size: 14px;"></span>
                                                </button>
                                        </td> --}}
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </ul>
                    @if (!$messages->isEmpty())
                        <div class="mt-3 pagination-mobile">{{ $messages->withQueryString()->onEachSide(1)->links() }}</div>
                    @endif


                </div>
            </div>
        </div>
    </div>

@endsection