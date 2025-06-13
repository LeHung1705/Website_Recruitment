@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manage-recruitment.css')}}" />
    <style>
        .action-column {
            text-align: center;
            white-space: nowrap;
        }
        .btn-action {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 0 2px;
        }
        .btn-view {
            background-color: #2457A6;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-view:hover {
            background-color: #1a3f7a;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        tr {
            cursor: default;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        .delete-form {
            display: inline;
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
                <th style="width: 20%;">Tiêu đề</th>
                <th style="width: 15%;">Ngành nghề</th>
                <th style="width: 20%;">Địa điểm</th>
                <th style="width: 15%;">Ngày đăng</th>
                <th style="width: 25%;">Thao tác</th>
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
                    <td class="action-column">
                        <div class="action-buttons">
                            <a href="{{ route('admin.applications', $job->id) }}" class="btn-action btn-view">
                                <i class="bi bi-people"></i> Xem đơn
                            </a>
                            <a href="{{ route('admin.edit_job_view', $job->id) }}" class="btn-action btn-edit">
                                <i class="bi bi-pencil"></i> Sửa
                            </a>
                            <form action="{{ route('admin.delete_job', $job->id) }}" method="POST" class="delete-form" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tin tuyển dụng này?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete">
                                    <i class="bi bi-trash"></i> Xóa
                                </button>
                            </form>
                        </div>
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