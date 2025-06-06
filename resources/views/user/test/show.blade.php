@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
<div class="card">
    <div class="card-header">
        <h4>Bài kiểm tra</h4>
    </div>
    <div class="card-body">
        <div class="timer" id="timer">Thời gian: 30:00</div>

        <form action="{{ route('test.submit', $test->id) }}" method="POST" id="testForm">
            @csrf
            @php
                $questions = json_decode($test->noi_dung, true);
            @endphp

            @foreach($questions as $index => $question)
            <div class="question-block">
                <h5>Câu {{ $index + 1 }}</h5>
                <p>{{ $question['cau_hoi'] }}</p>
                
                <ul class="options-list">
                    @foreach($question['lua_chon'] as $optionIndex => $option)
                    <li class="option-item">
                        <label>
                            <input type="radio" 
                                   name="answers[{{ $index }}]" 
                                   value="{{ $optionIndex }}"
                                   required>
                            {{ $option }}
                        </label>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

            <button type="submit" class="btn btn-primary" id="submitBtn">Nộp bài</button>
        </form>
    </div>
</div>

@push('scripts')
<script>
let timeLeft = 1800; // 30 minutes in seconds
const timerElement = document.getElementById('timer');
const form = document.getElementById('testForm');
const submitBtn = document.getElementById('submitBtn');

const timer = setInterval(() => {
    timeLeft--;
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `Thời gian: ${minutes}:${seconds.toString().padStart(2, '0')}`;

    if (timeLeft <= 0) {
        clearInterval(timer);
        form.submit();
    }
}, 1000);

// Prevent form resubmission
form.addEventListener('submit', () => {
    submitBtn.disabled = true;
    submitBtn.textContent = 'Đang nộp bài...';
});

// Warn before leaving page
window.addEventListener('beforeunload', (e) => {
    e.preventDefault();
    e.returnValue = '';
});
</script>
@endpush
@endsection 