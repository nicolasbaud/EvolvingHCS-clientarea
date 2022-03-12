@extends('layouts.app')

@section('title', 'Facture')

@section('content')
<div class="row mt--7">
  <div class="col-md-11 mx-auto">
    <div class="card card-invoice">
      <div class="card-header text-center">
        <div class="row justify-content-between">
          <div class="col-lg-3 col-md-5 text-left mt-3">
            <h4 class="mb-1">Facturé par :</h4>
            <span class="d-block">{{ config('app.name') }}</span>
            <p>{{ config('app.address') }}<br>
              {{ config('app.zip') }} {{ config('app.city') }}<br>
              {{ config('app.country') }}
            </p>
          </div>
          <div class="col-lg-3 col-md-5 text-left mt-3">
            <h4 class="mb-1">Facturé à :</h4>
            <span class="d-block">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
            <p>{{ Auth::user()->address }}<br>
              {{ Auth::user()->postalcode }} {{ Auth::user()->city }}<br>
              {{ Auth::user()->country }}
            </p>
          </div>
        </div>
        <br>
        <div class="row justify-content-md-between">
          <div class="col-lg-3 col-md-5 text-left mt-3">
            <h3 class="mb-1">Facture N° <br><small class="mr-2">#{{ $invoice->invoiceid }}</small></h3>
          </div>
          <div class="col-lg-4 col-md-5">
            <div class="row mt-5">
              <div class="col-md-6">Date de création:</div>
              <div class="col-md-6">{{ Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:m:s') }}</div>
            </div>
            <div class="row">
              <div class="col-md-6">Date d'échéance:</div>
              <div class="col-md-6">{{ Carbon\Carbon::parse($invoice->due_at)->format('d/m/Y H:m:s') }}</div>
            </div>
          </div>
        </div>
      </div>
      @if ($invoice->status != 'paid')
      <div class="card-header d-flex justify-content-end">
        <form method="post" action="{{ route('invoice.pay.balance', ['id' => $invoice->invoiceid]) }}">
          <button type="submit" class="btn btn-primary"><i class="fa fa-euro-sign"></i> Payer par solde</button>
          @csrf
        </form>
        &nbsp;
        <form method="post" action="{{ route('invoice.pay.paypal', ['id' => $invoice->invoiceid]) }}">
          <button type="submit" class="btn btn-primary" style="background-color: #0070BA;"><i class="fa fa-paypal"></i> Payer par PayPal</button>
          @csrf
        </form>
        &nbsp;
        <form method="post" action="{{ route('invoice.pay.stripe', ['id' => $invoice->invoiceid]) }}">
          <button type="submit" class="btn btn-primary" style="background-color: #6772e5;"><i class="fa fa-credit-card"></i> Payer par carte bancaire</button>
          @csrf
        </form>
      </div>
      @endif
      <div class="card-body">
        <div class="row">
          <div class="col-12">
            <div class="table-responsive">
              <table class="table text-right">
                <thead class="bg-default">
                  <tr>
                    <th scope="col" class="text-right text-white">Produit</th>
                    <th scope="col" class="text-center text-white">Quantité</th>
                    <th scope="col" class="text-center text-white">Statut</th>
                    <th scope="col" class="text-center text-white">Montant</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach(App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->where('userid', Auth::user()->id)->get() as $item)
                  <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-center">1</td>
                    @if ($item->status == 'paid')
                      <td class="text-center row justify-content-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check" aria-hidden="true"></i></button>
                        Livré
                      </td>
                    @elseif ($item->status == 'pending')
                      <td class="text-center row justify-content-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-pause" aria-hidden="true"></i></button>
                        Livraison en cours
                      </td>
                    @elseif ($item->status == 'unpaid')
                      <td class="text-center row justify-content-center">
                        <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times" aria-hidden="true"></i></button>
                        Impayée
                      </td>
                    @endif
                    <td class="text-center">{{ number_format($item->amount, 2, ',') }}€</td>
                  </tr>
                  @endforeach
                </tbody>
                <tfoot class="col-lg-4 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                  <tr>
                    <th></th>
                    <th></th>
                    <th class="text-center h4">Sous-Total</th>
                    <th class="text-center h4">{!! number_format(App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->where('userid', Auth::user()->id)->sum('amount'), 2, ',') !!}</th>
                  </tr>
                  @if (!is_null($invoice->promocode) AND App\Models\Promotions::where('code', $invoice->promocode)->count() >= '1')
                  <tr>
                    <th></th>
                    <th></th>
                    <th class="text-center h4" style="color: #00b14f;">Promotion</th>
                    <th class="text-center h4" style="color: #00b14f;">{!! App\Models\Promotions::where('code', $invoice->promocode)->first()->value !!}%</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th></th>
                    <th class="text-center h4">Total</th>
                    <th class="text-center h4">{!! number_format((App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->where('userid', Auth::user()->id)->sum('amount') - (App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->where('userid', Auth::user()->id)->sum('amount') * (App\Models\Promotions::where('code', $invoice->promocode)->first()->value / 100))), 2, ',') !!}</th>
                  </tr>
                  @else
                  <tr>
                    <th></th>
                    <th></th>
                    <th class="text-center h4">Total</th>
                    <th class="text-center h4">{!! number_format(App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->where('userid', Auth::user()->id)->sum('amount'), 2, ',') !!}</th>
                  </tr>
                  @endif
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection