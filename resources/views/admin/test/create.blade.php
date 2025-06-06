@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')
    <div class="test-card">
        <div class="test-card-header">
            <h4>Tạo bài kiểm tra mới</h4>
        </div>
        <div class="test-card-body">
            <form action="{{ route('admin.test.store') }}" method="POST" id="createTestForm" class="test-form">
                @csrf
                <div class="form-row">
                    <label class="form-label">Loại bài kiểm tra</label>
                    <select name="loai_bai" class="form-input" required>
                        <option value="">Chọn loại bài kiểm tra</option>
                        <option value="technical">Kiến thức chuyên môn</option>
                        <option value="iq">IQ</option>
                        <option value="english">Tiếng Anh</option>
                    </select>
                </div>

                <div id="questionsContainer">
                    <!-- Template for a question block -->
                    <div class="question-block" data-question="0">
                        <h5 class="question-title">Câu hỏi #1</h5>
                        <div class="form-row">
                            <label class="form-label">Nội dung câu hỏi</label>
                            <textarea name="questions[0][cau_hoi]" class="form-input" required></textarea>
                        </div>

                        <div class="options-container">
                            <div class="form-row">
                                <label class="form-label">Các lựa chọn</label>
                                <div class="option-inputs">
                                    <input type="text" name="questions[0][lua_chon][]" class="form-input" placeholder="Lựa chọn A" required>
                                    <input type="text" name="questions[0][lua_chon][]" class="form-input" placeholder="Lựa chọn B" required>
                                    <input type="text" name="questions[0][lua_chon][]" class="form-input" placeholder="Lựa chọn C" required>
                                    <input type="text" name="questions[0][lua_chon][]" class="form-input" placeholder="Lựa chọn D" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <label class="form-label">Đáp án đúng</label>
                                <select name="questions[0][dap_an]" class="form-input" required>
                                    <option value="0">A</option>
                                    <option value="1">B</option>
                                    <option value="2">C</option>
                                    <option value="3">D</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-secondary" id="addQuestion">
                        Thêm câu hỏi
                    </button>
                    <button type="submit" class="btn-primary">
                        Tạo bài kiểm tra
                    </button>
                </div>
            </form>
        </div>
    </div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('questionsContainer');
    const addButton = document.getElementById('addQuestion');
    let questionCount = 1;

    addButton.addEventListener('click', function() {
        const template = container.children[0].cloneNode(true);
        questionCount++;
        
        // Update question number
        template.querySelector('.question-title').textContent = `Câu hỏi #${questionCount}`;
        
        // Update input names
        template.setAttribute('data-question', questionCount - 1);
        template.querySelectorAll('input, textarea, select').forEach(input => {
            const name = input.getAttribute('name');
            if (name) {
                input.setAttribute('name', name.replace('[0]', `[${questionCount - 1}]`));
                input.value = '';
            }
        });

        container.appendChild(template);
    });

    // Form validation
    const form = document.getElementById('createTestForm');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Convert form data to JSON structure
        const formData = new FormData(form);
        const jsonData = {
            loai_bai: formData.get('loai_bai'),
            noi_dung: {}
        };

        // Group questions data
        const questions = {};
        for (const [key, value] of formData.entries()) {
            if (key.startsWith('questions[')) {
                const matches = key.match(/questions\[(\d+)\]\[(\w+)\](\[\])?/);
                if (matches) {
                    const [, index, field, isArray] = matches;
                    if (!questions[index]) {
                        questions[index] = {};
                    }
                    if (isArray) {
                        if (!questions[index][field]) {
                            questions[index][field] = [];
                        }
                        questions[index][field].push(value);
                    } else {
                        questions[index][field] = value;
                    }
                }
            }
        }

        jsonData.noi_dung = JSON.stringify(questions);

        // Create hidden input for JSON data
        const jsonInput = document.createElement('input');
        jsonInput.type = 'hidden';
        jsonInput.name = 'noi_dung';
        jsonInput.value = jsonData.noi_dung;
        form.appendChild(jsonInput);

        form.submit();
    });
});
</script>
@endpush
@endsection 