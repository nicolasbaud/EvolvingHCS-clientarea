@extends('admin.layouts.page')

@section('title', 'Paramètres')

@section('content_header')
    <h1>Paramètres</h1>
@endsection

@section('content')
@include('layouts.errors')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <form method="POST" action="{{ route('admin.settings.update') }}">
                @method('PATCH')
                @csrf
                <div class="card-header">
                    <h6 class="card-title">Paramètres Généraux</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Nom</label>
                            <input type="text" name="APP_NAME" value="{{ old('APP_NAME', config('app.name')) }}" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label>Url</label>
                            <input type="text" name="APP_URL" value="{{ old('APP_URL', config('app.url')) }}" class="form-control">
                        </div>
                    </div>
                    <h6 class="card-title">Paramètres Mail</h6><br />
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Host</label>
                            <input type="text" name="MAIL_HOST" value="{{ old('MAIL_HOST', config('mail.mailers.smtp.host')) }}" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Port</label>
                            <input type="text" name="MAIL_PORT" value="{{ old('MAIL_PORT', config('mail.mailers.smtp.port')) }}" class="form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Encryption</label>
                            <input type="text" name="MAIL_ENCRYPTION" value="{{ old('MAIL_ENCRYPTION', config('mail.mailers.smtp.encryption')) }}" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Utilisateur</label>
                            <input type="text" name="MAIL_USERNAME" value="{{ old('MAIL_USERNAME', config('mail.mailers.smtp.username')) }}" class="form-control">
                        </div>
                        <div class="col-lg-6">
                            <label>Mot de passe</label>
                            <input type="text" name="MAIL_PASSWORD" value="{{ old('MAIL_PASSWORD', config('mail.mailers.smtp.password')) }}" class="form-control">
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
</div>
@endsection