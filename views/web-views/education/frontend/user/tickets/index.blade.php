@extends('admin-views.education.frontend.user.layouts.dash')
@section('title', \App\CPU\Helpers::translate(My Tickets', 'user'))
@section('link', route('user.tickets.create'))
@section('search', true)
@section('status_dropdown', true)
@section('content')
    <div class="row g-3 mb-4">
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vr__counter__box bg-primary">
                <h3 class="vr__counter__box__title">{{ \App\CPU\Helpers::translate(Opened', 'tickets') }}</h3>
                <p class="vr__counter__box__number">{{ $openedTicketsCount }}</p>
                <span class="vr__counter__box__icon">
                    <i class="fas fa-hourglass-half"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vr__counter__box bg-success">
                <h3 class="vr__counter__box__title">{{ \App\CPU\Helpers::translate(Answered', 'tickets') }}</h3>
                <p class="vr__counter__box__number">{{ $answeredTicketsCount }}</p>
                <span class="vr__counter__box__icon">
                    <i class="far fa-comment-dots"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vr__counter__box bg-girl">
                <h3 class="vr__counter__box__title">{{ \App\CPU\Helpers::translate(Replied', 'tickets') }}</h3>
                <p class="vr__counter__box__number">{{ $repliedTicketsCount }}</p>
                <span class="vr__counter__box__icon">
                    <i class="fas fa-reply-all"></i>
                </span>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xxl-3">
            <div class="vr__counter__box bg-fire">
                <h3 class="vr__counter__box__title">{{ \App\CPU\Helpers::translate(Closed', 'tickets') }}</h3>
                <p class="vr__counter__box__number">{{ $closedTicketsCount }}</p>
                <span class="vr__counter__box__icon">
                    <i class="far fa-times-circle"></i>
                </span>
            </div>
        </div>
    </div>
    @if ($tickets->count() > 0)
        <div class="vr__dash__table">
            <div class="vr__table">
                <table>
                    <thead>
                        <th>{{ \App\CPU\Helpers::translate(Ticket number', 'tickets') }}</th>
                        <th>{{ \App\CPU\Helpers::translate(Subject', 'tickets') }}</th>
                        <th class="text-center">{{ \App\CPU\Helpers::translate(Priority', 'tickets') }}</th>
                        <th class="text-center">{{ \App\CPU\Helpers::translate(Status', 'tickets') }}</th>
                        <th class="text-center">{{ \App\CPU\Helpers::translate(Opened date', 'tickets') }}</th>
                        <th class="text-center">{{ \App\CPU\Helpers::translate(Action', 'tickets') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr>
                                <td><a class="text-primary"
                                        href="{{ route('user.tickets.view', $ticket->ticket_number) }}"><i
                                            class="fas fa-ticket-alt me-2"></i>{{ \App\CPU\Helpers::translate(Ticket', 'tickets') }}#{{ $ticket->ticket_number }}</a>
                                </td>
                                <td><a class="text-dark"
                                        href="{{ route('user.tickets.view', $ticket->ticket_number) }}">
                                        {{ shortertext($ticket->subject, 60) }}</a>
                                </td>
                                <td class="text-center">{!! ticketPriority($ticket->priority) !!}</td>
                                <td class="text-center">{!! ticketStatus($ticket->status) !!}</td>
                                <td class="text-center">{{ vDate($ticket->created_at) }}</td>
                                <td class="text-center">
                                    <a href="{{ route('user.tickets.view', $ticket->ticket_number) }}"
                                        class="btn btn-blue btn-sm"><i class="fa fa-eye"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (!request()->input('search'))
                {{ $tickets->links() }}
            @endif
        </div>
    @else
        @include('admin-views.education.frontend.user.includes.empty')
    @endif
@endsection
