@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="col-12">
  @if ($ticket->status != 'closed')
  <div class="d-sm-flex justify-content-end">
    <div class="d-flex">
      <button class="btn btn-icon btn-outline-white ms-2" type="button" id="replyButton">
        <span class="btn-inner--icon"><i class="fa fa-reply"></i></span>
      </button>
      <form method="POST" action="{{ route('ticket.close', ['id' => $ticket->ticketid]) }}">
        @method('DELETE')
        @csrf
        <button class="btn btn-icon btn-outline-white ms-2" type="submit">
          <span class="btn-inner--icon"><i class="fa fa-times"></i></span>
        </button>
      </form>
    </div>
  </div>
  @endif
  @error('content')
    <div class="alert alert-danger font-weight-bold text-white">{{ $message }}</div>
  @enderror
</div>
<div class="row mt--7">
  @include('support.ticket.modal.reply')
  @include('support.ticket.replies')
  @section('sidebar.ticket')
      <div class="card card-plain shadow-none" id="sidenavCard">
      <div class="card-body text-left p-3 w-100 pt-0">
        <p><b>Sujet:</b> {{ $ticket->subject }}</p>
        <p><b>Département:</b> {{ $ticket->department }}</p>
        @include('support.ticket.status')
      </div>
    </div>
  @endsection
</div>
@endsection