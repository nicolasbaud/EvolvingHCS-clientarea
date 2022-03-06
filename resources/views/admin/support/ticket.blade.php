@extends('admin.layouts.page')

@section('title', 'Ticket #'.$ticket->ticketid)

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-12">
        <div class="d-flex">
        <div class="justify-content-start">
            <h1>@yield('title')</h1>
        </div>
        &emsp;
        @if ($ticket->status != 'closed')
            <form method="POST" action="{{ route('admin.ticket.delete', ['id' => $ticket->ticketid]) }}">
                @method('DELETE')
                @csrf
                <button class="btn btn-icon btn-danger ms-2" type="submit">
                    Fermer le ticket
                </button>
            </form>
        @endif
    </div>
    </div>
</div>
@endsection

@section('content')
@include('layouts.errors')
<div class="row">
  @include('admin.support.ticket.modal.reply')
  @include('admin.support.ticket.replies')
</div>
@endsection