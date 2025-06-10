@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Xác nhận phỏng vấn</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Thông tin phỏng vấn:</h5>
                        <p><strong>Thời gian:</strong> {{ \Carbon\Carbon::parse($interview->thoi_gian)->format('d/m/Y H:i') }}</p>
                        <p><strong>Hình thức:</strong> {{ $interview->hinh_thuc }}</p>
                        <p><strong>Người phỏng vấn:</strong> {{ $interview->nguoidung->ho_ten }}</p>
                    </div>

                    <form id="confirmForm">
                        @csrf
                        <div class="alert alert-info">
                            Bạn có chắc chắn muốn xác nhận tham gia phỏng vấn vào thời gian trên?
                        </div>
                        <button type="submit" class="btn btn-primary">Xác nhận tham gia</button>
                        <a href="{{ url('/user/notifications') }}" class="btn btn-secondary">Quay lại</a>
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
    $('#confirmForm').submit(function(e) {
        e.preventDefault();
        
        $.ajax({
            url: `/user/interviews/{{ $interview->id }}/confirm`,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                alert('Xác nhận thành công');
                window.location.href = '/user/notifications';
            },
            error: function(xhr) {
                alert('Có lỗi xảy ra: ' + xhr.responseJSON.message);
            }
        });
    });
});
</script>
@endpush 