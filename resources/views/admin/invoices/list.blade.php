@extends('admin.layouts.page')

@section('title', 'Liste des factures')

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
<div class="row">
    <div class="card col-lg-12">
        <div class="card-body">
            <table id="invoices" class="table">
                <thead>
                        <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->invoiceid }}</td>
                        <td>{{ Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</td>
                        <td>{!! number_format(App\Models\InvoiceItems::where('invoiceid', $invoice->invoiceid)->sum('amount'), 2, ',') !!}€</td>
                        @if ($invoice->status == 'paid')
                        <td><span class="badge badge-success">Payée</span></td>
                        @elseif ($invoice->status == 'pending')
                        <td><span class="badge badge-warning">En Attente</span></td>
                        @elseif ($invoice->status == 'unpaid')
                        <td><span class="badge badge-danger">Impayée</span></td>
                        @else
                        <td><span class="badge badge-dark">{{ $invoice->status }}</span></td>
                        @endif
                        <td><a href="{{ route('admin.invoice.edit', ['id' => $invoice->invoiceid]) }}" class="btn btn-icons btn-primary"><i class="fa fa-edit"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form method="post" action="{{ route('admin.invoice.new') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">Création d'une facture</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <label>Utilisateur</label>
                            <select name="userid" class="@error('userid') is-invalid @enderror form-control select2" multiple style="width: 100%;">
                                @foreach (App\Models\User::get() as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->email }} ({{ $customer->firstname }} {{ $customer->lastname }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </form>
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
    $("#invoices").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 1, "desc" ]]
    }).buttons().container().appendTo('#invoices_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection