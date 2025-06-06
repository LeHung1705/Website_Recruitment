@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Bài kiểm tra của bạn</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('candidate.test.index') }}">
                        Bài kiểm tra mới
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('candidate.test.history') }}">
                        Lịch sử kiểm tra
                    </a>
                </li>
            </ul>

            @if($pendingTests->isEmpty())
            <p>Bạn chưa có bài kiểm tra nào mới.</p>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loại bài</th>
                            <th>Thời gian</th>
                            <th>Số câu hỏi</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingTests as $notification)
                        @php
                            $test = $notification->baikiemtra;
                            $questions = json_decode($test->noi_dung, true);
                        @endphp
                        <tr>
                            <td>{{ ucfirst($test->loai_bai) }}</td>
                            <td>30 phút</td>
                            <td>{{ count($questions) }}</td>
                            <td>
                                <a href="{{ $notification->link }}" 
                                   class="btn btn-primary"
                                   onclick="return confirm('Bạn có chắc muốn bắt đầu làm bài? Thời gian sẽ bắt đầu tính ngay khi bạn vào làm bài.')">
                                    Bắt đầu làm bài
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $pendingTests->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 