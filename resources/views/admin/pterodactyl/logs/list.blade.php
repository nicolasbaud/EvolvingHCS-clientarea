@extends('admin.layouts.page')

@section('title', 'Liste des logs')

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
@if (App\Models\PterodactylLogs::where('type', 'error')->count() >= '1')
<div class="alert alert-danger">
    <b>Attention !</b> Il y a {{ App\Models\PterodactylLogs::where('type', 'error')->count() }} erreur(s)
</div>
@endif
<div class="row">
    <div class="card col-lg-12">
        <div class="card-body">
            <table id="logs" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Identifiant du service</th>
                        <th>Type</th>
                        <th>Sévérité</th>
                        <th>Créé le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td><a href="{{ route('admin.pterodactyl.services.edit', ['id' => $log->serviceid]) }}">{!! $log->serviceid !!}</a></td>
                        <td>{{ $log->name }}</td>
                        <td>{{ $log->type }}</td>
                        <td>{{ Carbon\Carbon::parse($log->created_at)->format('d/m/Y') }}</td>
                        <td class="row">
                            <a class="btn btn-primary" href="{{ route('admin.pterodactyl.logs.view', ['id' => $log->id]) }}"><i class="fa fa-eye"></i></a>
                            &nbsp;
                            <form method="post" action="{{ route('admin.pterodactyl.logs.delete', ['id' => $log->id]) }}">
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
    $("#logs").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 3, "asc" ]]
    }).buttons().container().appendTo('#logs_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection