@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">   
@endpush

@section('content')
    <div class="card">
        <div class="card-header">
            <h4>Tất cả kết quả bài kiểm tra</h4>
        </div>
        <div class="card-body">
            <div class="all-results-container">
    <div class="all-results-header">
        <h2>Tất cả kết quả bài kiểm tra</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table all-results-table">
                    <thead>
                        <tr>
                            <th>Ứng viên</th>
                            <th>Bài kiểm tra</th>
                            <th>Điểm số</th>
                            <th>Ngày làm</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                            <tr>
                                <td class="result-user">{{ $result->nguoidung->name }}</td>
                                <td class="result-test-type">{{ $result->baikiemtra->loai_bai }}</td>
                                <td class="result-score">{{ $result->diem_so }}</td>
                                <td class="result-date">{{ $result->ngay_lam->format('d/m/Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Chưa có kết quả nào</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $results->links() }}
            </div>
        </div>
        </div>
    </div>
@endsection 