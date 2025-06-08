@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
<div class="test-card">
    <div class="test-card-header">
        <h4>Kết quả bài kiểm tra</h4>
    </div>
    <div class="test-card-body">
        @if($results->isEmpty())
            <p>Chưa có ứng viên nào hoàn thành bài kiểm tra.</p>
        @else
            <div class="table-responsive">
                <table class="table results-table">
                    <thead>
                        <tr>
                            <th>Ứng viên</th>
                            <th>Điểm số</th>
                            <th>Ngày làm bài</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($results as $result)
                        <tr>
                            <td>{{ $result->nguoidung->name }}</td>
                            <td><span class="score">{{ $result->diem_so }}/100</span></td>
                            <td>
                                <span class="date">
                                    {{ \Carbon\Carbon::parse($result->ngay_lam)->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.view.profile', $result->nguoi_lam_id) }}" 
                                   class="btn btn-primary">
                                    Xem hồ sơ
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($results->hasPages())
            <div class="mt-4">
                {{ $results->links() }}
            </div>
            @endif
        @endif
    </div>
</div>
@endsection 