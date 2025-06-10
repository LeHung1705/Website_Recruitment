@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Nhập kết quả phỏng vấn</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Thông tin ứng viên:</h5>
                        <p><strong>Họ tên:</strong> {{ $interview->donungtuyen->ungvien->ho_ten }}</p>
                        <p><strong>Thời gian phỏng vấn:</strong> {{ \Carbon\Carbon::parse($interview->thoi_gian)->format('d/m/Y H:i') }}</p>
                        <p><strong>Hình thức:</strong> {{ $interview->hinh_thuc }}</p>
                    </div>

                    <form id="resultForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Điểm số (0-10)</label>
                            <input type="number" class="form-control" id="diem_so" name="diem_so" 
                                min="0" max="10" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhận xét</label>
                            <textarea class="form-control" id="nhan_xet" name="nhan_xet" 
                                rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kết quả</label>
                            <select class="form-select" id="ket_qua" name="ket_qua" required>
                                <option value="">Chọn kết quả</option>
                                <option value="dau">Đậu</option>
                                <option value="rot">Rớt</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Lưu kết quả</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#resultForm').submit(function(e) {
        e.preventDefault();
        
        let formData = {
            diem_so: $('#diem_so').val(),
            nhan_xet: $('#nhan_xet').val(),
            ket_qua: $('#ket_qua').val()
        };

        $.ajax({
            url: `/admin/interviews/{{ $interview->id }}/result`,
            method: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Đã lưu kết quả phỏng vấn');
                window.location.href = '/admin/dashboard';
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endpush 