@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/jobs.css') }}" />
@endpush

@section('content')
    <div class="search-container">
        <img src="{{ asset('assets/images/banner.jpg') }}" alt="banner" class="banner">
        <div class="search-overlay">
            <form action="{{ route('jobs.search') }}" method="GET" class="search-filters">
                <div class="search-input">
                    <img src="{{ asset('assets/images/glass.png') }}" alt="search">
                    <input type="text" name="keyword" placeholder="Tìm kiếm công việc..." value="{{ request('keyword') }}">
                </div>
                <div class="location-select">
                    <select name="thanh_pho" id="thanh_pho">
                        <option value="">Tất cả thành phố</option>
                        <option value="TP.HCM" {{ request('thanh_pho') == 'TP.HCM' ? 'selected' : '' }}>TP. Hồ Chí Minh</option>
                        <option value="TP.Hà Nội" {{ request('thanh_pho') == 'TP.Hà Nội' ? 'selected' : '' }}>TP. Hà Nội</option>
                        <option value="TP.Đà Nẵng" {{ request('thanh_pho') == 'TP.Đà Nẵng' ? 'selected' : '' }}>TP. Đà Nẵng</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="jobs-grid">
            @foreach($jobs as $job)
            <div class="job-card" onclick="window.location.href='{{ route('jobs.show', $job->id) }}'">
                <div class="company-name">{{ $job->user->company_name ?? 'CÔNG TY CHƯA CẬP NHẬT' }}</div>
                <div class="job-title">{{ $job->tieu_de }}</div>
                <div class="job-attributes">
                    <div class="job-attribute">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $job->loai_cong_viec }}</span>
                    </div>
                    <div class="job-attribute">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M10.464 8.746c.227-.18.497-.311.786-.394v2.795a2.252 2.252 0 01-.786-.393c-.394-.313-.546-.681-.546-1.004 0-.323.152-.691.546-1.004zM12.75 15.662v-2.824c.347.085.664.228.921.421.427.32.579.686.579.991 0 .305-.152.671-.579.991a2.534 2.534 0 01-.921.42z" />
                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v.816a3.836 3.836 0 00-1.72.756c-.712.566-1.112 1.35-1.112 2.178 0 .829.4 1.612 1.113 2.178.502.4 1.102.647 1.719.756v2.978a2.536 2.536 0 01-.921-.421l-.879-.66a.75.75 0 00-.9 1.2l.879.66c.533.4 1.169.645 1.821.75V18a.75.75 0 001.5 0v-.81a4.124 4.124 0 001.821-.749c.745-.559 1.179-1.344 1.179-2.191 0-.847-.434-1.632-1.179-2.191a4.122 4.122 0 00-1.821-.75V8.354c.29.082.559.213.786.393l.415.33a.75.75 0 00.933-1.175l-.415-.33a3.836 3.836 0 00-1.719-.755V6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ number_format($job->luong, 0, ',', '.') }} VND</span>
                    </div>
                    <div class="job-attribute">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="m11.54 22.351.07.04.028.016a.76.76 0 00.723 0l.028-.015.071-.041a16.975 16.975 0 001.144-.742 19.58 19.58 0 002.683-2.282c1.944-1.99 3.963-4.98 3.963-8.827a8.25 8.25 0 00-16.5 0c0 3.846 2.02 6.837 3.963 8.827a19.58 19.58 0 002.682 2.282 16.975 16.975 0 001.145.742zM12 13.5a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                        </svg>
                        <span>{{ $job->dia_diem }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pagination">
            <div class="pagination-arrow {{ $jobs->onFirstPage() ? 'disabled' : '' }}">
                <a href="{{ $jobs->previousPageUrl() }}">&laquo;</a>
            </div>
        
            @for ($i = 1; $i <= $jobs->lastPage(); $i++)
                <div class="pagination-item {{ $jobs->currentPage() == $i ? 'active' : '' }}">
                    <a href="{{ $jobs->url($i) }}">{{ $i }}</a>
                </div>
            @endfor
        
            <div class="pagination-arrow {{ $jobs->currentPage() == $jobs->lastPage() ? 'disabled' : '' }}">
                <a href="{{ $jobs->nextPageUrl() }}">&raquo;</a>
            </div>
        </div>            
    </div>
@endsection
