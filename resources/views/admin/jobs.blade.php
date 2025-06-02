@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manage-recruitment.css')}}" />
@endpush

@section('content')
<div class="main-content">
    <div class="main-title">
        <h2>Quản lý tin tuyển dụng</h2>
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 10%;">STT</th>
                <th style="width: 30%;">Tiêu đề</th>
                <th style="width: 15%;">Ngành nghề</th>
                <th style="width: 30%;">Địa điểm</th>
                <th style="width: 15%;">Ngày đăng</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jobs as $index => $job)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $job->tieu_de }}</td>
                    <td>{{ $job->nganh_nghe }}</td>
                    <td>{{ $job->dia_diem }}</td>
                    <td>{{ \Carbon\Carbon::parse($job->ngay_dang)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Không có tin tuyển dụng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection