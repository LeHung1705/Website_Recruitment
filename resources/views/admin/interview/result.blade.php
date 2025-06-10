@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">
                    <h4>Nhập kết quả phỏng vấn</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5>Thông tin ứng viên:</h5>
                        <p><strong>Họ tên:</strong> {{ $interview->donungtuyen->ungvien->name }}</p>
                        <p><strong>Thời gian phỏng vấn:</strong> {{ \Carbon\Carbon::parse($interview->thoi_gian)->format('d/m/Y H:i') }}</p>
                        <p><strong>Hình thức:</strong> {{ $interview->hinh_thuc }}</p>
                    </div>

                    <form action="{{ route('admin.interview.result.store', $interview->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Điểm số (0-10)</label>
                            <input type="number" class="form-control @error('diem_so') is-invalid @enderror" 
                                name="diem_so" min="0" max="10" required value="{{ old('diem_so') }}">
                            @error('diem_so')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nhận xét</label>
                            <textarea class="form-control @error('nhan_xet') is-invalid @enderror" 
                                name="nhan_xet" rows="4" required>{{ old('nhan_xet') }}</textarea>
                            @error('nhan_xet')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kết quả</label>
                            <select class="form-select @error('ket_qua') is-invalid @enderror" 
                                name="ket_qua" required>
                                <option value="">Chọn kết quả</option>
                                <option value="dau" {{ old('ket_qua') == 'dau' ? 'selected' : '' }}>Đậu</option>
                                <option value="rot" {{ old('ket_qua') == 'rot' ? 'selected' : '' }}>Rớt</option>
                            </select>
                            @error('ket_qua')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn muốn lưu kết quả phỏng vấn này?')">Lưu kết quả</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Quay lại</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 