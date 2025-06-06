@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/test.css') }}">
@endpush

@section('content')

    <div class="card">
        <div class="card-header" id="test-header">
            <h4>Quản lý bài kiểm tra</h4>
            <a href="{{ route('admin.test.create') }}" class="btn btn-primary">
                Tạo bài kiểm tra mới
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if($tests->isEmpty())
            <p>Chưa có bài kiểm tra nào.</p>
            @else
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loại bài</th>
                            <th>Số câu hỏi</th>
                            <th>Số người làm</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tests as $test)
                        @php
                            $questions = json_decode($test->noi_dung, true);
                        @endphp
                        <tr>
                            <td>{{ ucfirst($test->loai_bai) }}</td>
                            <td>{{ count($questions) }}</td>
                            <td>{{ $test->so_nguoi_lam }}</td>
                            <td>
                                <span class="date">
                                    {{ $test->created_at->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.test.invite', $test->id) }}" 
                                   class="btn btn-secondary">
                                    Mời ứng viên
                                </a>
                                <a href="{{ route('admin.test.results', $test->id) }}" 
                                   class="btn btn-primary">
                                    Xem kết quả
                                </a>
                                <form action="{{ route('admin.test.destroy', $test->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Bạn có chắc muốn xóa bài kiểm tra này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tests->links() }}
            </div>
            @endif
        </div>
    </div>

@endsection 