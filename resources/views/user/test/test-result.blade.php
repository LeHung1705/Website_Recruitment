@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h4>Kết quả bài kiểm tra</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="result-summary mb-4">
                <h5>Thông tin chung</h5>
                <table class="table">
                    <tr>
                        <th>Loại bài:</th>
                        <td>{{ ucfirst($result->baikiemtra->loai_bai) }}</td>
                    </tr>
                    <tr>
                        <th>Điểm số:</th>
                        <td><span class="score">{{ $result->diem_so }}/100</span></td>
                    </tr>
                    <tr>
                        <th>Thời gian làm bài:</th>
                        <td>
                            <span class="date">
                                {{ \Carbon\Carbon::parse($result->ngay_lam)->format('d/m/Y H:i') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="result-detail">
                <h5>Chi tiết bài làm</h5>
                @php
                    $questions = json_decode($result->baikiemtra->noi_dung, true);
                    $answers = json_decode($result->dap_an, true) ?? [];
                @endphp

                @foreach($questions as $index => $question)
                <div class="question-block">
                    <h6>Câu {{ $index + 1 }}</h6>
                    <p>{{ $question['cau_hoi'] }}</p>
                    
                    <ul class="options-list">
                        @foreach($question['lua_chon'] as $optionIndex => $option)
                        <li class="option-item {{ $optionIndex == $question['dap_an'] ? 'correct' : '' }} 
                                               {{ isset($answers[$index]) && $answers[$index] == $optionIndex ? 'selected' : '' }}">
                            {{ $option }}
                            @if($optionIndex == $question['dap_an'])
                            <span class="badge badge-success">Đáp án đúng</span>
                            @endif
                            @if(isset($answers[$index]) && $answers[$index] == $optionIndex && $optionIndex != $question['dap_an'])
                            <span class="badge badge-danger">Đáp án của bạn</span>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('candidate.test.history') }}" class="btn btn-secondary">
                    Quay lại lịch sử
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.badge {
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    margin-left: 0.5rem;
}

.badge-success {
    background-color: #28a745;
    color: white;
}

.badge-danger {
    background-color: #dc3545;
    color: white;
}

.option-item.correct {
    border-color: #28a745;
    background-color: rgba(40, 167, 69, 0.1);
}

.option-item.selected:not(.correct) {
    border-color: #dc3545;
    background-color: rgba(220, 53, 69, 0.1);
}
</style>
@endpush
@endsection 