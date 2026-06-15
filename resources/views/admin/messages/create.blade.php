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
    @if(session()->has('tambahkritik'))
        data-flash-message-kritik="{{ session('tambahkritik') }}"
    @endif>
</div>
<div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">

            <div class="authentication-inner" >
                <div class="card" >
                    <div class="card-body">
                        <h4 class="mb-2">Tambah Kritik & Saran</h4>
                        <p></p>
                        <form action="{{ route('messages.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                            <div class="col-md-6 form-group">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" id="nama"
                                        placeholder="Nama Anda" required>
                            </div>
                            <div class="col-md-6 form-group mt-3 mt-md-0">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Email Anda" required>
                            </div>
                        </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject" id="subject"
                                    placeholder="Subjek" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" name="message" rows="5" placeholder="Pesan" required></textarea>
                            </div>

                            <div class="mb-4 divBtn d-flex justify-content-between">
                                <button class="btn btn-danger" type="submit">Kirim</button>
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