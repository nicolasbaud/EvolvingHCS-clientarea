@extends('layouts.app')

@section('title', 'Facture')

@section('content')
<div class="row mt--7">
  <div class="col-md-11 mx-auto">
    @if ($status == 'paid')
    <div class="card">
      <div class="card-body">
        <div class="success-checkmark">
          <div class="check-icon">
            <span class="icon-line line-tip"></span>
            <span class="icon-line line-long"></span>
            <div class="icon-circle"></div>
            <div class="icon-fix"></div>
          </div>
        </div>
        <h4 class="text-center">Votre paiement à bien été validé, veuillez laisser quelques minutes à notre système afin de livrer vos produits.</h4>
      </div>
    </div>
    @else
    <div class="card">
      <div class="card-body">
        <div class="d-flex justify-content-center">
          <i style="color: var(--bs-danger);" class="fa fa-times-circle fa-7x"></i>
        </div>
        <br />
        <h4 class="text-center">Une erreur est survenu durant la validation du paiement, si vous pensez qu'il s'agit d'une erreur, veuillez nous contacter.</h4>
      </div>
    </div>
    @endif
  </div>
</div>
@endsection