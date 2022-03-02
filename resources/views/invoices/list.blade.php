@extends('layouts.app')

@section('title', 'Factures')

@section('content')
<div class="row mt--7">
  <div class="col-12">
    <div class="card mb-4">
      <div class="card-header pb-0">
        <h6>Factures</h6>
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
          <table class="table align-items-center justify-content-center mb-0">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Échéance</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Prix</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Statut</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($invoices as $invoice)
              <tr>
                <td>
                  <div class="d-flex px-2">
                    <div class="my-auto">
                      <h6 class="mb-0 text-sm">{{ $invoice->invoiceid }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{{ Carbon\Carbon::parse($invoice->due_at)->format('d/m/Y') }}</p>
                </td>
                <td>
                  <p class="text-sm font-weight-bold mb-0">{!! number_format(App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->sum('amount'), 2, ',') !!}€</p>
                </td>
                <td>
                  @if ($invoice->status == 'paid')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-success mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-check" aria-hidden="true"></i></button>
                      <span>Payée</span>
                    </div>
                  @elseif ($invoice->status == 'pending')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-warning mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-pause" aria-hidden="true"></i></button>
                      <span>Validation</span>
                    </div>
                  @elseif ($invoice->status == 'unpaid')
                    <div class="d-flex align-items-center">
                      <button class="btn btn-icon-only btn-rounded btn-outline-danger mb-0 me-2 btn-sm d-flex align-items-center justify-content-center"><i class="fas fa-times" aria-hidden="true"></i></button>
                      <span>Impayée</span>
                    </div>
                  @else
                  <span class="badge bg-dark">{{ $invoice->status }}</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('invoice.view', ['id' => $invoice->invoiceid]) }}" class="btn btn-icon btn-2 btn-primary btn-sm mb-0">
                    <i class="fa fa-file-alt text-xs" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @empty
              <div class="alert alert-danger text-white">
                Vous n'avez pas de factures
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