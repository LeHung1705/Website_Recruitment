@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/add-new-job.css') }}" />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap"
        rel="stylesheet"
    />
    <style>
        .form-control:focus {
            box-shadow: none;
            border-color: #D9D9D9;
        }
        .input-group-text {
            background: transparent;
            border: none;
            padding-right: 0;
        }
        .form-label {
            font-weight: bold;
            font-family: 'Roboto', sans-serif;
            min-width: 150px;
        }
    </style>
@endpush

@section('content')
<div class="main-content">
    <div class="add-new-job-container">
        <img src="{{ asset('images/banner.png') }}" alt="banner" class="banner img-fluid w-100 mb-4" />
        <form action="{{ route('admin.add_job') }}" method="POST" class="job-detail-form">
            @csrf
            <h1 class="add-new-job-title mb-4 w-100 text-start">Chi tiết việc làm</h1>
            
            @if(session('success'))
                <div class="alert alert-success w-100">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger w-100">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="tieu_de" class="form-label me-3 pt-2">Tiêu đề</label>
                <div class="input-group flex-grow-1">
                    <input type="text" class="form-control" id="tieu_de" name="tieu_de" required value="{{ old('tieu_de') }}" />
                    <span class="input-group-text">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="mo_ta" class="form-label me-3 pt-2">Mô tả</label>
                <div class="input-group flex-grow-1">
                    <textarea class="form-control" id="mo_ta" name="mo_ta" rows="3" required>{{ old('mo_ta') }}</textarea>
                    <span class="input-group-text align-items-start pt-2">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="loai_cong_viec" class="form-label me-3 pt-2">Hình thức</label>
                <div class="input-group flex-grow-1">
                    <input type="text" class="form-control" id="loai_cong_viec" name="loai_cong_viec" required value="{{ old('loai_cong_viec') }}" />
                    <span class="input-group-text">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="dia_diem" class="form-label me-3 pt-2">Địa điểm</label>
                <div class="input-group flex-grow-1">
                    <input type="text" class="form-control" id="dia_diem" name="dia_diem" required value="{{ old('dia_diem') }}" />
                    <span class="input-group-text">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="luong" class="form-label me-3 pt-2">Lương</label>
                <div class="input-group flex-grow-1">
                    <input type="number" class="form-control" id="luong" name="luong" required value="{{ old('luong') }}" step="0.01" min="0" />
                    <span class="input-group-text">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="form-group mb-3 d-flex align-items-start">
                <label for="nganh_nghe" class="form-label me-3 pt-2">Ngành nghề</label>
                <div class="input-group flex-grow-1">
                    <input type="text" class="form-control" id="nganh_nghe" name="nganh_nghe" required value="{{ old('nganh_nghe') }}" />
                    <span class="input-group-text">
                        <img src="{{ asset('images/pencil.png') }}" alt="pencil" width="13px" />
                    </span>
                </div>
            </div>

            <div class="border-top border-2 w-100 my-4"></div>

            <div class="form-text mb-4 text-start w-100" style="line-height: 1.5;">
                Khi chọn <strong>Xác nhận</strong>, bạn đồng ý rằng tin tuyển dụng này sẽ phản ánh yêu cầu của bạn 
                và đồng ý rằng tin tuyển dụng này sẽ được đăng và các đơn ứng tuyển sẽ được xử lý theo
                <a href="#" class="text-decoration-none">Điều khoản</a>, 
                <a href="#" class="text-decoration-none">Cookie</a>, và 
                <a href="#" class="text-decoration-none">Chính sách quyền riêng tư</a> của TraiDepTuyenDung
            </div>

            <button type="submit" class="btn btn-primary px-5 py-3 fw-bold" style="background-color: #2457A6; min-width: 300px;">
                Thêm mới việc làm
            </button>
        </form>
    </div>
</div>
@endsection
