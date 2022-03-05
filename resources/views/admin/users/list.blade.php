@extends('admin.layouts.page')

@section('title', 'Liste des utilisateurs')

@section('content_header')
    <h1>@yield('title')</h1>
@endsection

@section('content')
<div class="row">
    <div class="card col-lg-12">
        <div class="card-body">
            <table id="users" class="table">
                <thead>
                        <tr>
                        <th>#</th>
                        <th>Nom complet</th>
                        <th>Email</th>
                        <th>Balance</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->firstname }} {{ $user->lastname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->balance }}</td>
                        <td>@if (is_null($user->email_verified_at)) <span class="badge badge-danger">Non vérifié</span> @else <span class="badge badge-success">Vérifié</span> @endif</td>
                        <td class="row"><a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-icons btn-primary"><i class="fa fa-edit"></i></a>&nbsp;
                            <form method="post" action="{{ route('admin.user.delete', ['id' => $user->id]) }}">
                                @csrf
                                <button class="btn btn-icons btn-danger"><i class="fa fa-trash"></i></button>
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
<link rel="stylesheet" href="/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection

@section('js')

<script type="text/javascript">
  $(function () {
    $("#users").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 1, "desc" ]]
    }).buttons().container().appendTo('#users_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection