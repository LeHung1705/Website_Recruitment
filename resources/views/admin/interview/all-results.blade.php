@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">
    <div class="card">
        <div class="card-header">
            <h4>Kết quả phỏng vấn</h4>
        </div>
        <div class="card-body">
            @if($results->isEmpty())
                <p class="text-center">Chưa có kết quả phỏng vấn nào.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ứng viên</th>
                                <th>Vị trí ứng tuyển</th>
                                <th>Thời gian PV</th>
                                <th>Điểm số</th>
                                <th>Kết quả</th>
                                <th>Nhận xét</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($results as $interview)
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
                                    <span class="badge bg-info">
                                        {{ $interview->ketquaphongvan->diem_so }}/10
                                    </span>
                                </td>
                                <td>
                                    @if($interview->ketquaphongvan->ket_qua === 'dau')
                                        <span class="badge bg-success">Đạt</span>
                                    @else
                                        <span class="badge bg-danger">Không đạt</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="left"
                                            title="{{ $interview->ketquaphongvan->nhan_xet }}">
                                        <i class="bi bi-eye"></i> Xem
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 d-flex justify-content-center">
                    {{ $results->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>
@endpush 