@extends('layouts.app')

@section('title', 'Vérification')

@section('content')
  <div class="row mt-4">
    <div class="col-lg-12">
      @if (session('resent'))
        <div class="alert alert-info text-white" role="alert">
          Un nouveau lien de vérification a été envoyé à votre adresse e-mail.
        </div>
      @endif
      <div class="card">
        @if (is_null(Auth::user()->email_verified_at))
        <div class="card-body">
          <div class="d-flex justify-content-center">
            <i style="color: var(--bs-danger);" class="fa fa-exclamation-circle fa-7x"></i>
          </div>
          <br />
          <h3 class="text-center">Votre adresse e-mail n'est pas vérifié !</h3>
          <br />
          <div class="d-flex justify-content-center">
            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
              @csrf
              <button type="submit" class="btn btn-primary">Envoyer un lien de vérification.</button>
            </form>
          </div>
        </div>
        @else
        <div class="card-body">
          <div class="success-checkmark">
            <div class="check-icon">
              <span class="icon-line line-tip"></span>
              <span class="icon-line line-long"></span>
              <div class="icon-circle"></div>
              <div class="icon-fix"></div>
            </div>
          </div>
          <h3 class="text-center">Votre adresse e-mail est vérifié, aucun action requise.</h3>
        </div>
        @endif
      </div>
    </div>
  </div>
@endsection