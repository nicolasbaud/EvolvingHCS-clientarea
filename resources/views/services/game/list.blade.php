@extends('layouts.app')

@section('title', 'Services Game')

@section('content')
<div class="row mt--7">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>@yield('title')</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center justify-content-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Création</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Échéance</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Prix</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Statut</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($services as $service)
              <tr>
                <td>
                  <div class="d-flex px-2">
                    <div class="my-auto">
                      <h6 class="mb-0 text-sm">{{ $service->serviceid }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ Carbon\Carbon::parse($service->created_at)->format('d/m/Y H:m') }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ Carbon\Carbon::parse($service->expired_at)->format('d/m/Y H:m') }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ $service->recurrent_price }}€</p>
                </td>
                <td>
                  @if ($service->status == 'active')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check" aria-hidden="true"></i></button>
                      <span>Actif</span>
                    </div>
                  @elseif ($service->status == 'pending')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-pause" aria-hidden="true"></i></button>
                      <span>En attente</span>
                    </div>
                  @elseif ($service->status == 'suspend')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times" aria-hidden="true"></i></button>
                      <span>Suspendu</span>
                    </div>
                  @else
                  <span class="badge bg-dark">{{ $service->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('service.game.manage', ['id' => $service->serviceid]) }}" class="btn btn-icon btn-2 btn-primary btn-sm mb-0">
                    <i class="fa fa-cogs text-xs" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="4">
                  Aucun service
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection