@extends('admin.layouts.page')

@section('title', 'Édition')

@section('content_header')
    <h1>@yield('title')</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Informations de facturation</h6>
            </div>
            <form method="post" action="{{ route('admin.edit.user', ['id' => $user->id]) }}">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="firstname">Prénom</label>
                            <input type="text" name="firstname" id="firstname" value="{{ $user->firstname }}" class="@error('firstname') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="lastname">Nom</label>
                            <input type="text" name="lastname" id="lastname" value="{{ $user->lastname }}" class="@error('lastname') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="email">Email</label>
                            <input type="text" name="email" disabled id="email" value="{{ $user->email }}" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="tel">Téléphone</label>
                            <input type="text" name="tel" id="tel" value="{{ $user->tel }}" class="@error('tel') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="address">Adresse</label>
                            <input type="text" name="address" id="address" value="{{ $user->address }}" class="@error('address') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="city">Ville</label>
                            <input type="text" name="city" id="city" value="{{ $user->city }}" class="@error('city') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="postalcode">Code Postal</label>
                            <input type="text" name="postalcode" id="postalcode" value="{{ $user->postalcode }}" class="@error('postalcode') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="region">Région</label>
                            <input type="text" name="region" id="region" value="{{ $user->region }}" class="@error('region') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-6">
                            <label for="country">Pays</label>
                            <input type="text" name="country" id="country" value="{{ $user->country }}" class="@error('country') is-invalid @enderror form-control">
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Sauvegarder</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <label for="created_at">Créé le</label>
                        <input type="text" id="created_at" value="{{ $user->created_at }}" disabled class="form-control">
                    </div>
                    <div class="col-lg-6">
                        <label for="updated_at">Mise à jour le</label>
                        <input type="text" id="updated_at" value="{{ $user->updated_at }}" disabled class="form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('admin.user.balance', ['id' => $user->id]) }}">
                @csrf
                    <div class="row">
                        <div class="col-lg-8">
                            <label for="balance">Balance</label>
                            <input type="text" id="balance" name="balance" value="{{ $user->balance }}" class="@error('balance') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="save">Action</label>
                            <button type="submit" id="save" class="btn btn-primary btn-block">Sauvegarder</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">
                    Statut: 
                    @if (is_null($user->email_verified_at))
                        <span class="badge badge-danger">Non vérifié</span>
                    @else
                        <span class="badge badge-success">Vérifié</span>
                    @endif
                </h6>
            </div>
            <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                        @if (is_null($user->email_verified_at))
                        <form method="post" action="{{ route('admin.user.verify', ['id' => $user->id]) }}">
                            <input type="hidden" name="verify" value="true">
                            @csrf
                            <button type="submit" class="btn btn-success btn-block">Forcer la vérification</button>
                        </form>
                        @else
                        <form method="post" action="{{ route('admin.user.verify', ['id' => $user->id]) }}">
                            <input type="hidden" name="verify" value="false">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block">Annuler la vérification</button>
                        </form>
                        @endif
                        </div>
                    </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Édition du mot de passe</h6>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('admin.user.password', ['id' => $user->id]) }}">
                @csrf
                    <div class="row">
                        <div class="col-lg-4">
                            <label for="password">Nouveau mot de passe</label>
                            <input type="password" name="password" class="@error('password') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label for="confirm">Confirmation</label>
                            <input type="password" name="confirm" class="@error('confirm') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Action</label>
                            <button type="submit" class="btn btn-primary btn-block">Sauvegarder</button>
                        </div>
                    </div>
                </form>
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
@endsection