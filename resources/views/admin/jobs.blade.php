@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manage-recruitment.css')}}" />
    <style>
        .action-column {
            text-align: center;
        }
        .btn-view-applications {
            padding: 5px 10px;
            background-color: #2457A6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-view-applications:hover {
            background-color: #1a3f7a;
            color: white;
        }
        tr {
            cursor: pointer;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
@endpush

@section('content')
<div class="main-content">
    <div class="main-title">
        <h2>Quản lý tin tuyển dụng</h2>
    </div>
    
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">STT</th>
                <th style="width: 25%;">Tiêu đề</th>
                <th style="width: 15%;">Ngành nghề</th>
                <th style="width: 25%;">Địa điểm</th>
                <th style="width: 15%;">Ngày đăng</th>
                <th style="width: 15%;">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jobs as $index => $job)
                <tr onclick="window.location.href='{{ route('admin.applications', $job->id) }}'">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $job->tieu_de }}</td>
                    <td>{{ $job->nganh_nghe }}</td>
                    <td>{{ $job->dia_diem }}</td>
                    <td>{{ \Carbon\Carbon::parse($job->ngay_dang)->format('d/m/Y') }}</td>
                    <td class="action-column">
                        <a href="{{ route('admin.applications', $job->id) }}" class="btn-view-applications">
                            <i class="bi bi-people"></i> Xem đơn
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Không có tin tuyển dụng nào.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection