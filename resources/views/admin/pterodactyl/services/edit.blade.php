@extends('admin.layouts.page')

@section('title', 'Services')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
    <h1>@yield('title')</h1>
    </div>
    <div class="col-sm-6">
        <div class="float-sm-right">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#create"><i class="fa fa-plus"></i></button>
        </div>
    </div>
</div>
@endsection

@section('content')
@include('layouts.errors')
<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Information basique</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label>Identifiant service</label>
                        <input disabled value="{{ $service->serviceid }}" class="form-control">
                    </div>
                    <div class="col-sm-6">
                        <label>Utilisateur</label>
                        <select name="userid" class="@error('userid') is-invalid @enderror form-control select2" style="width: 100%;">
                            @foreach (App\Models\User::get() as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->email }} ({{ $customer->firstname }} {{ $customer->lastname }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Offre</label>
                        <select name="offer_id" class="@error('offer_id') is-invalid @enderror form-control select2" style="width: 100%;">
                            @foreach (App\Models\PterodactylProducts::get() as $offer)
                                <option value="{{ $offer->id }}">{{ $offer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label>Prix</label>
                        <input type="text" name="recurrent_price" class="@error('recurrent_price') is-invalid @enderror form-control" value="{{ $service->recurrent_price }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label>Localisation</label>
                        <select name="location" class="@error('location') is-invalid @enderror form-control select2" style="width: 100%;">
                            @foreach (App\Models\PterodactylNodes::get() as $node)
                                <option value="{{ $node->id }}">{{ $node->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label>Date d'expiration</label>
                        <input type="text" name="expired_at" class="@error('expired_at') is-invalid @enderror form-control" value="{{ $service->expired_at }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label>Statut</label>
                        <select name="status" class="@error('status') is-invalid @enderror form-control select2" style="width: 100%;">
                            <option value="active">Actif</option>
                            <option value="pending">En attente</option>
                            <option value="expired">Expiré</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Sauvegarder</button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    Statut: 
                    @php
                        if (!$application->get('servers/external/'.$service->serviceid)->suspended) {
                            $status = $client->get('servers/'.$application->get('servers/external/'.$service->serviceid)->identifier.'/resources')->current_state;
                        } else {
                            $status = false;
                        }
                    @endphp
                    @if ($status == 'running')
                        <div class="badge bg-success">Allumé</div>
                    @elseif ($status == 'offline')
                        <div class="badge bg-danger">Éteint</div>
                    @elseif ($status == 'stopping')
                        <div class="badge bg-info">Action en cours...</div>
                    @elseif ($status == 'starting')
                        <div class="badge bg-info">Action en cours...</div>
                    @elseif ($application->get('servers/external/'.$service->serviceid)->suspended)
                        <div class="badge bg-warning">Suspendu</div>
                    @else
                        <div class="badge bg-dark">{{ $status }}</div>
                    @endif
                </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        @if (!$application->get('servers/external/'.$service->serviceid)->suspended)
                        <form method="post" action="{{ route('admin.pterodactyl.services.power', ['id' => $service->serviceid, 'signal' => 'suspend']) }}">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-block">Suspendre</button>
                        </form>
                        @elseif ($application->get('servers/external/'.$service->serviceid)->suspended)
                        <form method="post" action="{{ route('admin.pterodactyl.services.power', ['id' => $service->serviceid, 'signal' => 'unsuspend']) }}">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">Remettre en service</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="post" action="{{ route('admin.pterodactyl.services.power', ['id' => $service->serviceid, 'signal' => 'delete']) }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style type="text/css">
    .hide { display: none !important; }
</style>
@endsection

@section('js')
<script type="text/javascript">
$(function () {
    $('.select2').select2()
});
</script>
@endsection