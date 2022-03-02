@extends('layouts.app')

@section('title', 'Commande')

@section('content')
<div class="row mt--7">
  <div class="col-12">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('checkout.game.order', ['id' => $product->id]) }}" method="post">
          @csrf
          <h5 class="mb-4">Détails de la commande</h5>
          <div class="row">
            <div class="col-lg-6 mx-auto">
              <h3 class="mt-lg-0 mt-4">{{ $product->name }}</h3>
              <h6 class="mb-0 mt-3">Prix</h6>
              <h5>{{ number_format($product->price, 2, ',') }}€</h5>
              <br>
            </div>
            <div class="col-lg-6">
              <label class="text-left">Description</label>
              <br />
              {!! $product->description !!}
              <div class="row mt-4">
                <div class="col-lg-12 text-end">
                  @if ($product->visibility == 'public')
                    <button class="btn btn-primary mb-0 mt-lg-auto" type="submit">Passer au paiement <i class="fa fa-arrow-right"></i></button>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection