@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Lịch sử kiểm tra</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('candidate.test.index') }}">
                        Bài kiểm tra mới
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('candidate.test.history') }}">
                        Lịch sử kiểm tra
                    </a>
                </li>
            </ul>

            @if($completedTests->isEmpty())
            <p>Bạn chưa hoàn thành bài kiểm tra nào.</p>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loại bài</th>
                            <th>Điểm số</th>
                            <th>Ngày làm</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($completedTests as $result)
                        <tr>
                            <td>{{ ucfirst($result->baikiemtra->loai_bai) }}</td>
                            <td>
                                <span class="score">{{ $result->diem_so }}/100</span>
                            </td>
                            <td>
                                <span class="date">
                                    {{ \Carbon\Carbon::parse($result->ngay_lam)->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('candidate.test.result', $result->bai_kiem_tra_id) }}" 
                                   class="btn btn-primary">
                                    Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $completedTests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 