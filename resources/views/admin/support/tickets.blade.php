@extends('admin.layouts.page')

@section('title', 'Liste des tickets')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1>@yield('title')</h1>
    </div>
</div>
@endsection

@section('content')
@include('layouts.errors')
<div class="row">
    <div class="card col-lg-12">
        <div class="card-body">
            <table id="tickets" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Utilisateur</th>
                        <th>Département</th>
                        <th>Sujet</th>
                        <th>Statut</th>
                        <th>Date de création</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->ticketid }}</td>
                        <td><a href="{{ route('admin.user.edit', ['id' => App\Models\User::find($ticket->userid)->id]) }}">{{ App\Models\User::find($ticket->userid)->firstname }} {{ App\Models\User::find($ticket->userid)->lastname }} ({{ App\Models\User::find($ticket->userid)->email }})</a></td>
                        <td>{{ $ticket->department }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td>
                        @if ($ticket->status == 'open')
                            <span class="badge badge-success">Ouvert</span>
                        @elseif ($ticket->status == 'wait_staff')
                            <span class="badge badge-warning">En attente du staff</span>
                        @elseif ($ticket->status == 'wait_customer')
                            <span class="badge badge-info">En attente du client</span>
                        @elseif ($ticket->status == 'closed')
                            <span class="badge badge-danger">Clos</span>
                        @else
                            <span class="badge badge-dark">{{ $ticket->status }}</span>
                        @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($ticket->created_at)->format('d/m/Y H:m:s') }}</td>
                        <td class="row">
                            <a class="btn btn-primary" href="{{ route('admin.ticket', ['id' => $ticket->ticketid]) }}"><i class="fa fa-eye"></i></a>
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
    $("#tickets").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 4, "desc" ]]
    }).buttons().container().appendTo('#tickets_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection