@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/job-detail.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- banner -->
    <img src="{{ asset('assets/images/banner.jpg') }}" alt="banner" width="100%" class="banner" />

    <div class="job-detail-container">
        <span style="font-family: 'Playfair Display', serif; font-weight: bold; opacity: 50%; font-size: 20px;">{{ strtoupper($job->nganh_nghe) }}</span>
        <div class="job-detail">
            <h2 class="company-name" style="margin-bottom: 5px;">{{ $job->nguoidung->name ?? 'CÔNG TY CHƯA CẬP NHẬT' }}</h2>
            <hr style="border: 1px solid #e0e0e0; margin: 20px 0;">
            <div class="job-detail-item-1">
                <div class="job-name">
                    <h3>Vị trí : <span>{{ $job->tieu_de }}</span></h3>
                </div>
                <div class="job-overview">
                    <span>📍 Địa điểm: {{ $job->dia_diem }}</span>
                    <span>💼 Hình thức: {{ $job->loai_cong_viec }}</span>
                    <span>💰 Mức lương: {{ number_format($job->luong, 0, ',', '.') }} VND / tháng</span>
                    <span>📅 Hạn nộp hồ sơ: {{ \Carbon\Carbon::parse($job->ngay_dang)->addMonths(1)->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="job-detail-item">
                <h3>Mô tả công việc:</h3>
                <div class="description">
                    {!! nl2br(e($job->mo_ta)) !!}
                </div>
            </div>

            <div class="job-detail-item">
                <h3>Yêu cầu công việc:</h3>
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
                <h3>Cách ứng tuyển:</h3>
                <ul>
                    <li>Nhấn nút "Ứng tuyển ngay" bên dưới để nộp hồ sơ trực tuyến.</li>
                </ul>
            </div>
        </div>
    </div>
    
    @auth
        @if(Auth::user()->utype == 'USR')
            @php
                $hasApplied = \App\Models\Donungtuyen::where('ung_vien_id', Auth::id())
                    ->where('tin_tuyen_dung_id', $job->id)
                    ->exists();
            @endphp
            
            @if($hasApplied)
                <button class="btn-applied" disabled>Bạn đã ứng tuyển công việc này</button>
            @else
                <form action="{{ route('apply.job', $job->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-apply-now">Ứng tuyển ngay</button>
                </form>
            @endif
        @elseif(Auth::user()->utype == 'ADM' && $job->nguoi_dang_id == Auth::user()->id)
            <a href="{{ route('admin.applications', $job->id) }}" class="btn-apply-now">Xem danh sách ứng viên</a>
        @endif
    @else
        <a href="{{ route('login') }}" class="btn-apply-now">Đăng nhập để ứng tuyển</a>
    @endauth
</div>
@endsection
