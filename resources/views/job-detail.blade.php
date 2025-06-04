@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/job-detail.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <!-- search-box -->
    <div class="search-box">
        <img src="{{ asset('assets/images/glass.png') }}" alt="glass" height="90%" />
        <input type="text" placeholder="Tìm kiếm..." />
    </div>

    <!-- banner -->
    <img src="{{ asset('assets/images/banner.jpg') }}" alt="banner" width="100%" />

    <div class="job-detail-container">
        <span style="font-weight: bold; opacity: 50%; font-size: 20px;">{{ strtoupper($job->nganh_nghe) }}</span>
        <div class="job-detail">
            <span class="company-name">{{ $job->user->company_name ?? 'CÔNG TY CHƯA CẬP NHẬT' }}</span>
            <div class="job-detail-item-1">
                <div class="job-name">
                    <span>Vị trí : </span>{{ $job->tieu_de }}
                </div>
                <div class="job-overview">
                    <span>📍 Địa điểm: {{ $job->dia_diem }}</span>
                    <span>💼 Hình thức: {{ $job->loai_cong_viec }}</span>
                    <span>💰 Mức lương: {{ number_format($job->luong, 0, ',', '.') }} VND / tháng</span>
                    <span>📅 Hạn nộp hồ sơ: {{ \Carbon\Carbon::parse($job->ngay_dang)->addMonths(1)->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="job-detail-item">
                <span>Mô tả công việc:</span>
                <div class="description">
                    {!! nl2br(e($job->mo_ta)) !!}
                </div>
            </div>

            <div class="job-detail-item">
                <span>Yêu cầu công việc:</span>
                @php
                    $yeuCaus = explode("\n", $job->yeu_cau);
                @endphp
                <ul>
                    @foreach($yeuCaus as $yeuCau)
                        @if(trim($yeuCau))
                            <li>{{ trim($yeuCau) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>

            @if(isset($job->phuc_loi))
            <div class="job-detail-item">
                <span>Phúc lợi:</span>
                <ul>
                    @php
                        $phucLois = explode("\n", $job->phuc_loi);
                    @endphp
                    @foreach($phucLois as $phucLoi)
                        @if(trim($phucLoi))
                            <li>{{ trim($phucLoi) }}</li>
                        @endif
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="job-detail-item">
                <span>Cách ứng tuyển:</span>
                <ul>
                    <li>Nhấn nút "Ứng tuyển ngay" bên dưới để nộp hồ sơ trực tuyến.</li>
                </ul>
            </div>
        </div>
    </div>
    
    @auth
        <form action="{{ route('apply.job', $job->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-apply-now">Ứng tuyển ngay</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="btn-apply-now">Đăng nhập để ứng tuyển</a>
    @endauth
</div>
@endsection
