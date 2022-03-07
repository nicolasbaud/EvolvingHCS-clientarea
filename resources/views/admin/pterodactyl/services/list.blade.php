@extends('admin.layouts.page')

@section('title', 'Liste des services')

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
    <div class="card col-lg-12">
        <div class="card-body">
            <table id="services" class="table">
                <thead>
                        <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Node</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Créé le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                    <tr>
                        <td>{{ $service->serviceid }}</td>
                        <td><a href="{{ route('admin.pterodactyl.products') }}">{!! App\Models\PterodactylProducts::find($service->offer_id)->name !!}</a></td>
                        <td><a href="{{ route('admin.pterodactyl.nodes') }}">{!! App\Models\PterodactylNodes::find($service->location)->name !!}</a></td>
                        <td>{{ $service->recurrent_price }}€</td>
                        <td>
                            @if ($service->status == 'active')
                                <span class="badge badge-success">Actif</span>
                            @elseif ($service->status == 'pending')
                                <span class="badge badge-warning">En attente</span>
                            @elseif ($service->status == 'suspend')
                                <span class="badge badge-warning">Suspendu</span>
                            @elseif ($service->status == 'expired')
                                <span class="badge badge-danger">Expiré</span>
                            @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($service->created_at)->format('d/m/Y') }}</td>
                        <td class="row">
                            <a href="{{ route('admin.pterodactyl.services.edit', ['id' => $service->serviceid]) }}" class="btn btn-icons btn-primary"><i class="fa fa-edit"></i></a>
                            &nbsp;
                            <form method="post" action="{{ route('admin.pterodactyl.services.delete', ['id' => $service->id]) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-icons btn-danger"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
    $("#services").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 1, "desc" ]]
    }).buttons().container().appendTo('#services_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection