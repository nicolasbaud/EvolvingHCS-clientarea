@extends('layouts.app')

@section('title', 'Gestion')

@section('content')
<div class="row mt--7">
  @if ($service->first()->status != 'active')
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <div class="product-icon text-center">
            <span class="fa-5x">
              <i class="fas text-danger fa-ban fa-inverse"></i>
            </span>
            <h3>Service indisponible</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  @elseif ($application->get('servers/external/'.$service->first()->serviceid)->suspended)
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <div class="mb-3">
          <div class="product-icon text-center">
            <span class="fa-5x">
              <i class="fas text-danger fa-exclamation-circle fa-inverse"></i>
            </span>
            <h3>Service suspendu</h3>
          </div>
        </div>
      </div>
    </div>
  </div>
  @else
  <div class="col-6">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <div class="d-flex">
          <p>@yield('title')</p>
          <div class="ms-auto">
            @if ($service->first()->status == 'active')
              <span class="badge bg-success">Actif</span>
            @elseif ($service->first()->status == 'pending')
              <span class="badge bg-dark">En attente</span>
            @elseif ($service->first()->status == 'suspend')
              <span class="badge bg-warning">Suspendu</span>
            @elseif ($service->first()->status == 'expired')
              <span class="badge bg-danger">Expiré</span>
            @else
              <span class="badge bg-info">{{ $service->first()->status }}</span>
            @endif
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="mb-3">
              <div class="product-icon text-center">
                <span class="fa-stack fa-3x">
                  <i class="fas fa-circle fa-stack-2x"></i>
                  <i class="fas fa-database fa-stack-1x fa-inverse"></i>
                </span>
                <h3>{{ $service->first()->offer }}</h3>
                <h5 class="@if (floor((strtotime($service->first()->expired_at) - time())/86400) <= 14) text-danger @endif">{{ floor((strtotime($service->first()->expired_at) - time())/86400) }} Jours restant</h5>
              </div>
              <div class="justify-content-center d-flex">
                  @php
                  $status = $client->get('servers/'.$application->get('servers/external/'.$service->first()->serviceid)->identifier.'/resources')->current_state;
                  @endphp
                  @if ($status == 'running')
                    <div class="badge bg-success">Allumé</div>
                  @elseif ($status == 'offline')
                    <div class="badge bg-danger">Éteint</div>
                  @elseif ($status == 'stopping')
                    <div class="badge bg-info">Action en cours...</div>
                  @elseif ($status == 'starting')
                    <div class="badge bg-info">Action en cours...</div>
                  @endif
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-6">
    <div class="row">
      <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0">
        <div class="card">
          <div class="card-body p-3">
            <div class="d-flex">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Prix</p>
                <h5 class="font-weight-bolder mb-0">{{ $service->first()->recurrent_price }}€</h5>
              </div>
              <div class="icon icon-shape bg-gradient-dark text-center rounded-circle ms-auto">
                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
            <p class="mb-0">
              <span class="text-success text-sm font-weight-bolder">
                @if (!str_contains((($service->first()->recurrent_price - $service->first()->first_price) / $service->first()->first_price) * 100, '-'))
                <span class="text-dark">+{{ (($service->first()->recurrent_price - $service->first()->first_price) / $service->first()->first_price) * 100 }}%</span>
                @else
                {{ (($service->first()->recurrent_price - $service->first()->first_price) / $service->first()->first_price) * 100 }}%
                @endif
              </span>
              depuis le premier paiement
            </p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-md-6 col-12 mt-4 mt-lg-0">
        <div class="card">
          <div class="card-body p-3">
            <div class="d-flex">
              <div class="numbers">
                <p class="text-sm mb-0 text-uppercase font-weight-bold">Échéance</p>
                <h5 class="font-weight-bolder mb-0">{{ Carbon\Carbon::parse($service->first()->expired_at)->format('d/m/Y') }}</h5>
              </div>
              <div class="icon icon-shape bg-gradient-dark text-center rounded-circle ms-auto">
                <i class="ni ni-planet text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
            <p class="mb-0">
              <a href="#renew" data-bs-toggle="modal" data-bs-target="#renew" class="text-danger font-weight-bold">Renouveler</a>
            </p>
          </div>
        </div>
      </div>
    </div>
    @php
      putenv('APP_NAME=VALUE')
    @endphp
    @include('services.game.modal.renew')
    <div class="card mt-4">
      <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
          <h6 class="mb-2">Facturation</h6>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center">
          <tbody>
            <tr>
              <td>
                <div class="text-center">
                  <p class="font-weight-bold mb-0">Prix:</p>
                  <h6 class="mb-0">{{ $service->first()->recurrent_price }}€</h6>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <p class="font-weight-bold mb-0">Date de création:</p>
                  <h6 class="mb-0">{{ Carbon\Carbon::parse($service->first()->created_at)->format('d/m/Y H:m') }}</h6>
                </div>
              </td>
              <td>
                <div class="text-center">
                  <p class="font-weight-bold mb-0">Date d'échéance:</p>
                  <h6 class="mb-0">{{ Carbon\Carbon::parse($service->first()->expired_at)->format('d/m/Y H:m') }}</h6>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-12 row mt-4">
      <div class="col-6">
        <a href="{{ $baseUri }}" target="_blank" class="btn btn-primary w-100">Accéder au panel</a>
      </div>
      <div class="col-6">
        <a href="{{ $baseUri }}/auth/password" target="_blank" class="btn btn-danger w-100">Définir un mot de passe</a>
      </div>
    </div>
  </div>
  @endif
</div>
@endsection