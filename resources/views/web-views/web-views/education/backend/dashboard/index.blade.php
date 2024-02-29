@extends('backend.layouts.application')
@section('title', __('Dashboard'))
@section('access', 'Quick Access')
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-lg-6">
                <h3 class="vironeer-counter-box-title">{{ __('Total Users') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalUsers }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fa fa-users"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-lg-2">
                <h3 class="vironeer-counter-box-title">{{ __('Total Tickets') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalTickets }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-ticket-alt"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-lg-3">
                <h3 class="vironeer-counter-box-title">{{ __('Total Pages') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalPages }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="far fa-file-alt"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-lg-4">
                <h3 class="vironeer-counter-box-title">{{ __('Total Articles') }}</h3>
                <p class="vironeer-counter-box-number">{{ $totalArticles }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-rss"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-primary">
                <h3 class="vironeer-counter-box-title">{{ __('Opened Tickets') }}</h3>
                <p class="vironeer-counter-box-number">{{ $openedTicketsCount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-hourglass-half"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-3">
            <div class="vironeer-counter-box bg-success">
                <h3 class="vironeer-counter-box-title">{{ __('Answered Tickets') }}</h3>
                <p class="vironeer-counter-box-number">{{ $answeredTicketsCount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="far fa-comment-dots"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-girl">
                <h3 class="vironeer-counter-box-title">{{ __('Replied Tickets') }}</h3>
                <p class="vironeer-counter-box-number">{{ $repliedTicketsCount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="fas fa-reply-all"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vironeer-counter-box bg-fire">
                <h3 class="vironeer-counter-box-title">{{ __('Closed Tickets') }}</h3>
                <p class="vironeer-counter-box-number">{{ $closedTicketsCount }}</p>
                <span class="vironeer-counter-box-icon">
                    <i class="far fa-times-circle"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <div class="col-12 col-lg-8 col-xxl-8">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Users statistics for last 7 days') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('users.index') }}">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas height="380" id="vironeer-users-charts"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4 col-xxl-4">
            <div class="card vhp-460">
                <div class="vironeer-box v2">
                    <div class="vironeer-box-header mb-3">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Recently registered') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('users.index') }}">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="vironeer-random-lists">
                            @forelse ($users as $user)
                                <div class="vironeer-random-list">
                                    <div class="vironeer-random-list-cont">
                                        <a class="vironeer-random-list-img" href="#">
                                            <img src="{{ asset($user->avatar) }}" />
                                        </a>
                                        <div class="vironeer-random-list-info">
                                            <div>
                                                <a class="vironeer-random-list-title fs-exact-14"
                                                    href="{{ route('users.edit', $user->id) }}">
                                                    {{ $user->firstname . ' ' . $user->lastname }}
                                                </a>
                                                <p class="vironeer-random-list-text mb-0">
                                                    {{ $user->created_at->diffforhumans() }}
                                                </p>
                                            </div>
                                            <div class="vironeer-random-list-action d-none d-lg-block">
                                                <a href="{{ route('users.edit', $user->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('backend.includes.emptysmall')
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="vironeer-box chart-bar">
                    <div class="vironeer-box-header">
                        <p class="vironeer-box-header-title large mb-0">{{ __('Monthly tickets statistics') }}</p>
                        <div class="vironeer-box-header-action ms-auto">
                            <button type="button" class="btn btn-sm rounded-3" data-bs-toggle="dropdown">
                                <i class="fa fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-sm-end">
                                <li><a class="dropdown-item"
                                        href="{{ route('tickets.index') }}">{{ __('View All') }}</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="vironeer-box-body">
                        <div class="chart-bar">
                            <canvas height="400" id="vironeer-tickets-charts"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts_libs')
        <script src="{{ asset('/public/assets/vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ asset('/public/assets/vendor/admin/js/charts.js') }}"></script>
    @endpush
@endsection
