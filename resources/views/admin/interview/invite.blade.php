@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Mời phỏng vấn ứng viên</h2>
        <a href="{{ route('admin.applications', $donUngTuyen->tin_tuyen_dung_id) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>Thông tin ứng viên:</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Họ và tên:</strong></td>
                            <td>{{ $donUngTuyen->ungvien->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $donUngTuyen->ungvien->email }}</td>
                        </tr>
                        <tr>
                            <td><strong>Số điện thoại:</strong></td>
                            <td>{{ $donUngTuyen->ungvien->phone ?? 'Chưa cập nhật' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Vị trí ứng tuyển:</strong></td>
                            <td>{{ $donUngTuyen->tintuyendung->tieu_de }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <form id="inviteForm" method="POST" action="{{ route('interview.sendInvite', $donUngTuyen->id) }}">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Thời gian phỏng vấn <span class="text-danger">*</span></label>
                            <input type="datetime-local" 
                                   class="form-control @error('thoi_gian') is-invalid @enderror" 
                                   name="thoi_gian" 
                                   required>
                            @error('thoi_gian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Hình thức phỏng vấn <span class="text-danger">*</span></label>
                            <select class="form-select @error('hinh_thuc') is-invalid @enderror" 
                                    name="hinh_thuc" 
                                    required>
                                <option value="">Chọn hình thức</option>
                                <option value="online">Online</option>
                                <option value="offline">Offline</option>
                            </select>
                            @error('hinh_thuc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send"></i> Gửi lời mời
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#inviteForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                alert('Đã gửi lời mời phỏng vấn thành công');
                window.location.href = "{{ route('admin.applications', $donUngTuyen->tin_tuyen_dung_id) }}";
            },
            error: function(xhr) {
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    alert('Lỗi: ' + xhr.responseJSON.message);
                } else {
                    alert('Đã có lỗi xảy ra, vui lòng thử lại');
                }
            }
        });
    });
});
</script>
@endpush 