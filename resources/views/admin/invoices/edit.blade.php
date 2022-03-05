@extends('admin.layouts.page')

@section('title', 'Édition')

@section('content_header')
    <h1>@yield('title')</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-sm-6">
                        <h6 class="card-title">Infos Générales</h6>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            Appartient à <a href="{{ route('admin.user.edit', ['id' => App\Models\User::find($invoice->userid)->id]) }}">{{ App\Models\User::find($invoice->userid)->firstname }} {{ App\Models\User::find($invoice->userid)->lastname }} ({{ App\Models\User::find($invoice->userid)->email }})</a>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ route('admin.invoice.update', ['id' => $invoice->invoiceid]) }}" class="card-body row text-center">
            @csrf
                <div class="@if(is_null($invoice->txid)) col-lg-6 @else col-lg-4 @endif">
                    <label>Identifiant</label>
                    <input disabled type="text" value="{{ $invoice->invoiceid }}" class="form-control">
                </div>
                <div class="@if(is_null($invoice->txid)) col-lg-6 @else col-lg-4 @endif">
                    <label>Statut</label>
                    <div class="input-group mb-3">
                        <select class="form-control" name="status">
                            <option value="paid" @selected($invoice->status == 'paid')>Payée</option>
                            <option value="pending" @selected($invoice->status == 'pending')>En attente</option>
                            <option value="unpaid" @selected($invoice->status == 'unpaid')>Impayée</option>
                        </select>
                        <div class="input-group-prepend">
                            <span class="input-group-text"><button class="btn btn-primary btn-sm btn-icon"><i class="fa fa-save"></i></span>
                        </div>
                    </div>
                </div>
                @if(!is_null($invoice->txid))
                <div class="col-lg-4">
                    <label>Identifiant du paiement</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-{{ $invoice->paymentmethod }}"></i></span>
                        </div>
                        <input disabled type="text" class="form-control" value="{{ $invoice->txid }}">
                    </div>
                </div>
                @endif
            </form>
        </div>
        <div class="card">
            <div class="card-header">
                <h6 class="card-title">Items</h6>
            </div>
            <div class="card-body row">
                <table id="invoices" class="table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th># du produit/service</th>
                            <th>Type</th>
                            <th>Montant</th>
                            <th>Statut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->productid }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->amount }}€</td>
                            <td>{{ $item->status }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.invoice.item.delete', ['id' => $item->invoiceid, 'itemid' => $item->id]) }}">
                                @csrf
                                    <button class="btn btn-danger btn-block"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <form method="POST" action="{{ route('admin.invoice.item.add', ['id' => $invoice->invoiceid]) }}">
                            @csrf
                            <td>
                                <input type="text" name="description" class="@error('description') is-invalid @enderror form-control">
                            </td>
                            <td>
                                <input type="text" name="productid" class="@error('productid') is-invalid @enderror form-control">
                            </td>
                            <td>
                                <select class="@error('type') is-invalid @enderror form-control" name="type">
                                    <option value="hosting.game">Livraison d'un service game</option>
                                    <option value="renew.game">Renouvellement d'un service game</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="@error('amount') is-invalid @enderror form-control" name="amount" placeholder="Prix (exemple: 5)">
                            </td>
                            <td>
                                <select class="@error('status') is-invalid @enderror form-control" name="status">
                                    <option value="unpaid">Impayée</option>
                                    <option value="pending">Livraison</option>
                                    <option value="paid">Livré</option>
                                </select>
                            </td>
                            <td>
                                <button type="submit" class="btn btn-success btn-block"><i class="fa fa-plus"></i></button>
                            </td>
                            </form>
                        </tr>
                    </tbody>
                </table>
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