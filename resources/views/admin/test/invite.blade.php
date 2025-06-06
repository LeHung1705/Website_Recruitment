@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')

    <div class="card">
        <div class="card-header">
            <h4>Mời ứng viên làm bài kiểm tra</h4>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <form action="{{ route('admin.test.send.invite', $test->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Danh sách ứng viên</label>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Vị trí ứng tuyển</th>
                                    <th>Ngày ứng tuyển</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applicants as $applicant)
                                <tr>
                                    <td>
                                        <input type="checkbox" 
                                               name="applicants[]" 
                                               value="{{ $applicant->ungvien->id }}"
                                               class="applicant-checkbox">
                                    </td>
                                    <td>{{ $applicant->ungvien->name }}</td>
                                    <td>{{ $applicant->ungvien->email }}</td>
                                    <td>{{ $applicant->tintuyendung->tieu_de }}</td>
                                    <td>
                                        <span class="date">
                                            {{ $applicant->created_at->format('d/m/Y') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary" id="inviteBtn">
                        Gửi lời mời
                    </button>
                </div>
            </form>
        </div>
    </div>


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.getElementsByClassName('applicant-checkbox');
    const inviteBtn = document.getElementById('inviteBtn');

    // Select all functionality
    selectAll.addEventListener('change', function() {
        Array.from(checkboxes).forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });
        updateInviteButton();
    });

    // Individual checkbox change
    Array.from(checkboxes).forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            selectAll.checked = allChecked;
            updateInviteButton();
        });
    });

    // Update invite button state
    function updateInviteButton() {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
        inviteBtn.disabled = !anyChecked;
    }

    // Initial button state
    updateInviteButton();
});
</script>
@endpush
@endsection 