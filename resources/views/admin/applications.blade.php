@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/manage-candidate.css') }}" />
@endpush

@section('content')
<div class="main-content">
    <h2>Danh sách ứng viên</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>STT</th>
                <th>Họ và Tên</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Vị trí ứng tuyển</th>
                <th>Ngày ứng tuyển</th>
                <th>Trạng thái</th>
                <th>Hồ sơ</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $index => $application)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $application->ungvien->hosocanhan->ho_ten ?? 'Chưa cập nhật' }}</td>
                <td>{{ $application->ungvien->email }}</td>
                <td>{{ $application->ungvien->hosocanhan->so_dien_thoai ?? 'Chưa cập nhật' }}</td>
                <td>{{ $application->tintuyendung->tieu_de }}</td>
                <td>{{ $application->created_at->format('d/m/Y') }}</td>
                <td>
                    <span class="status-badge status-{{ $application->trang_thai }}">
                        @switch($application->trang_thai)
                            @case('phu_hop')
                                Phù hợp
                                @break
                            @case('khong_phu_hop')
                                Không phù hợp
                                @break
                            @default
                                Đang chờ xử lý
                        @endswitch
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.view.profile', $application->ungvien->id) }}" class="btn-view-profile">
                        <i class="bi bi-file-earmark-plus"></i>
                    </a>
                </td>
                <td class="action-buttons">
                    <form action="{{ route('admin.applications.update-status', $application->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" name="status" value="phu_hop" class="btn btn-sm btn-success">
                            <i class="bi bi-check-circle"></i>
                        </button>
                        <button type="submit" name="status" value="khong_phu_hop" class="btn btn-sm btn-danger">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
