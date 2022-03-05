@extends('admin.layouts.page')

@section('title', 'Liste des nodes')

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
            <table id="nodes" class="table">
                <thead>
                        <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Location</th>
                        <th>Hôte</th>
                        <th>Créé le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($nodes as $node)
                    <tr>
                        <td>{{ $node->id }}</td>
                        <td>{{ $node->name }}</td>
                        <td>{{ $node->location_id }}</td>
                        <td>{{ $node->fqdn }}</td>
                        <td>{{ Carbon\Carbon::parse($node->created_at)->format('d/m/Y') }}</td>
                        <td class="row">
                            <button data-toggle="modal" data-target="#edit{{ $node->id }}" class="btn btn-icons btn-primary"><i class="fa fa-edit"></i></button>
                            &nbsp;
                            <form method="post" action="{{ route('admin.pterodactyl.nodes.delete', ['id' => $node->id]) }}">
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

<div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('admin.pterodactyl.nodes.new') }}">
            <input type="hidden" name="status" value="public">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">Créer une node</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nom</label>
                            <input type="text" name="name" placeholder="Nom souhaité" class="@error('name') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Identifiant de la Location</label>
                            <input type="text" name="location_id" placeholder="Identifiant de la location Pterodactyl" class="@error('location_id') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Hôte</label>
                            <input type="text" name="fqdn" placeholder="Hôte" class="@error('fqdn') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Clé client</label>
                            <input type="text" name="key" placeholder="Clé client" class="@error('key') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-6">
                            <label>Clé admin</label>
                            <input type="text" name="pass" placeholder="Clé admin" class="@error('pass') is-invalid @enderror form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
</div>

@foreach ($nodes as $node)
<div class="modal fade" id="edit{{ $node->id }}" tabindex="-1" aria-labelledby="edit{{ $node->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('admin.pterodactyl.nodes.edit', ['id' => $node->id]) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit{{ $node->id }}Label">Édition de la node {{ $node->name }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <label>Nom</label>
                            <input type="text" name="name" value="{{ $node->name }}" class="@error('name') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Identifiant de la Location</label>
                            <input type="text" name="location_id" value="{{ $node->location_id }}" class="@error('location_id') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-4">
                            <label>Hôte</label>
                            <input type="text" name="fqdn" value="{{ $node->fqdn }}" class="@error('fqdn') is-invalid @enderror form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Clé client</label>
                            <input type="text" name="key" value="{{ $node->key }}" class="@error('key') is-invalid @enderror form-control">
                        </div>
                        <div class="col-lg-6">
                            <label>Clé admin</label>
                            <input type="text" name="pass" value="{{ $node->pass }}" class="@error('pass') is-invalid @enderror form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endforeach
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
    $("#nodes").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 1, "desc" ]]
    }).buttons().container().appendTo('#invoices_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection