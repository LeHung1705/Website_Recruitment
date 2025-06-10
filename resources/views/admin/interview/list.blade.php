@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">
    <div class="card">
        <div class="card-header">
            <h4>Danh sách phỏng vấn</h4>
        </div>
        <div class="card-body">
            @if($interviews->isEmpty())
                <p class="text-center">Chưa có cuộc phỏng vấn nào.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ứng viên</th>
                                <th>Vị trí ứng tuyển</th>
                                <th>Thời gian</th>
                                <th>Hình thức</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($interviews as $interview)
                            <tr>
                                <td>
                                    {{ $interview->donungtuyen->ungvien->name }}
                                    <div class="text-muted small">
                                        {{ $interview->donungtuyen->ungvien->email }}
                                    </div>
                                </td>
                                <td>{{ $interview->donungtuyen->tintuyendung->tieu_de }}</td>
                                <td>{{ \Carbon\Carbon::parse($interview->thoi_gian)->format('H:i - d/m/Y') }}</td>
                                <td>
                                    <span class="badge {{ $interview->hinh_thuc === 'online' ? 'bg-info' : 'bg-primary' }}">
                                        {{ ucfirst($interview->hinh_thuc) }}
                                    </span>
                                </td>
                                <td>
                                    @switch($interview->trang_thai)
                                        @case('cho_xac_nhan')
                                            <span class="badge bg-warning">Chờ xác nhận</span>
                                            @break
                                        @case('da_xac_nhan')
                                            <span class="badge bg-success">Đã xác nhận</span>
                                            @break
                                        @case('da_hoan_thanh')
                                            <span class="badge bg-secondary">Đã hoàn thành</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($interview->trang_thai === 'da_xac_nhan')
                                        <a href="{{ route('admin.interview.result.form', $interview->id) }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-pencil"></i> Nhập kết quả
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $interviews->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
