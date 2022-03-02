@extends('layouts.app')

@section('title', 'Tickets')

@section('content')
<div class="row mt--7">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">

        <div class="d-sm-flex justify-content-between">
          <h5>Liste des tickets</h5>
          <div class="d-flex">
            <a class="btn btn-icon btn-primary ms-2" href="{{ route('ticket.new') }}">
              <span class="btn-inner--icon"><i class="fa fa-plus"></i></span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center justify-content-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sujet</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Département</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Création</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Statut</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($tickets as $ticket)
              <tr>
                <td>
                  <div class="d-flex px-2">
                    <div class="my-auto">
                      <h6 class="mb-0 text-sm">{{ $ticket->ticketid }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ $ticket->subject }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ $ticket->department }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y') }}</p>
                </td>
                <td>
                  @if ($ticket->status == 'open')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check" aria-hidden="true"></i></button>
                      <span>Ouvert</span>
                    </div>
                  @elseif ($ticket->status == 'wait_staff')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-info mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-clock" aria-hidden="true"></i></button>
                      <span>En attente du staff</span>
                    </div>
                  @elseif ($ticket->status == 'wait_customer')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-info mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-clock" aria-hidden="true"></i></button>
                      <span>En attente du client</span>
                    </div>
                  @elseif ($ticket->status == 'closed')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times" aria-hidden="true"></i></button>
                      <span>Clos</span>
                    </div>
                  @else
                  <span class="badge bg-dark">{{ $ticket->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('ticket', ['id' => $ticket->ticketid]) }}" class="btn btn-icon btn-2 btn-primary btn-sm mb-0">
                    <i class="fa fa-file-alt text-xs" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @empty
              <div class="alert alert-danger text-white">
                Vous n'avez aucun ticket.
              </div>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection