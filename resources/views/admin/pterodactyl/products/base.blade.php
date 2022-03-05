@extends('admin.layouts.page')

@section('title', 'Liste des produits')

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
            <table id="products" class="table">
                <thead>
                        <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Node</th>
                        <th>Prix</th>
                        <th>Visibilité</th>
                        <th>Créé le</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->node }}</td>
                        <td>{{ $product->price }}€</td>
                        <td>
                            @if ($product->visibility == 'public')
                                <span class="badge badge-success">Public</span>
                            @else
                                <span class="badge badge-danger">Privé</span>
                            @endif
                        </td>
                        <td>{{ Carbon\Carbon::parse($product->created_at)->format('d/m/Y') }}</td>
                        <td class="row">
                            <button data-toggle="modal" data-target="#edit{{ $product->id }}" class="btn btn-icons btn-primary"><i class="fa fa-edit"></i></button>
                            &nbsp;
                            <form method="post" action="{{ route('admin.pterodactyl.nodes.delete', ['id' => $product->id]) }}">
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
        <form method="POST" action="{{ route('admin.pterodactyl.products.new') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLabel">Créer un produit</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-details_create-tab" data-toggle="pill" href="#vert-tabs-details_create" role="tab" aria-controls="vert-tabs-details_create" aria-selected="true">Détails</a>
                                <a class="nav-link" id="vert-tabs-ressources_create-tab" data-toggle="pill" href="#vert-tabs-ressources_create" role="tab" aria-controls="vert-tabs-ressources_create" aria-selected="false">Ressources</a>
                                <a class="nav-link" id="vert-tabs-options_create-tab" data-toggle="pill" href="#vert-tabs-options_create" role="tab" aria-controls="vert-tabs-options_create" aria-selected="false">Options</a>
                                <a class="nav-link" id="vert-tabs-settings_create-tab" data-toggle="pill" href="#vert-tabs-settings_create" role="tab" aria-controls="vert-tabs-settings_create" aria-selected="false">Paramètres</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade active show" id="vert-tabs-details_create" role="tabpanel" aria-labelledby="vert-tabs-details_create-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Nom</label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="@error('name') is-invalid @enderror form-control">
                                            <label>Prix</label>
                                            <input type="text" name="price" value="{{ old('price') }}" class="@error('price') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Description (HTML Autorisé)</label>
                                            <textarea name="description" style="height: 100%;" class="form-control">{!! old('description') !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-ressources_create" role="tabpanel" aria-labelledby="vert-tabs-ressources_create-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>CPU en pourcentage (100% = 1 Coeur)</label>
                                            <input type="text" name="cpu" value="{{ old('cpu') }}" class="@error('cpu') is-invalid @enderror form-control">
                                            <label>Mémoire (en MB)</label>
                                            <input type="text" name="memory" value="{{ old('memory') }}" class="@error('memory') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>SWAP (en MB)</label>
                                            <input type="text" name="swap" value="{{ old('swap') }}" class="@error('swap') is-invalid @enderror form-control">
                                            <label>Disque (en MB)</label>
                                            <input type="text" name="disk" value="{{ old('disk') }}" class="@error('disk') is-invalid @enderror form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-options_create" role="tabpanel" aria-labelledby="vert-tabs-options_create-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Base de données</label>
                                            <input type="text" name="databases" value="{{ old('databases') }}" class="@error('databases') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Sauvegardes</label>
                                            <input type="text" name="backups" value="{{ old('backups') }}" class="@error('backups') is-invalid @enderror form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Allocations</label>
                                        <input type="text" name="allocations" value="{{ old('allocations') }}" class="@error('allocations') is-invalid @enderror form-control">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-settings_create" role="tabpanel" aria-labelledby="vert-tabs-settings_create-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Nest</label>
                                            <input type="text" name="nest" value="{{ old('nest') }}" class="@error('nest') is-invalid @enderror form-control">
                                            <label>Node</label>
                                            <select class="@error('node') is-invalid @enderror form-control" name="node">
                                                @foreach(App\Models\PterodactylNodes::all() as $node)
                                                    <option @selected(old('node') == $node->id) value="{{ $node->id }}">{{ $node->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Egg</label>
                                            <input type="text" name="egg" value="{{ old('egg') }}" class="@error('egg') is-invalid @enderror form-control">
                                            <label>Visibilité</label>
                                            <select class="@error('visibility') is-invalid @enderror form-control" name="visibility">
                                                <option @selected(old('visibility') == 'pulic')  value="public">Public</option>
                                                <option @selected(old('visibility') == 'private') value="private">Privé</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
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

@foreach ($products as $product)
<div class="modal fade" id="edit{{ $product->id }}" tabindex="-1" aria-labelledby="edit{{ $product->id }}Label" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form method="POST" action="{{ route('admin.pterodactyl.products.edit', ['id' => $product->id]) }}">
            @method('PUT')
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="edit{{ $product->id }}Label">Édition du produit {{ $product->name }}</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-5 col-sm-3">
                            <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active" id="vert-tabs-details{{ $product->id }}-tab" data-toggle="pill" href="#vert-tabs-details{{ $product->id }}" role="tab" aria-controls="vert-tabs-details{{ $product->id }}" aria-selected="true">Détails</a>
                                <a class="nav-link" id="vert-tabs-ressources{{ $product->id }}-tab" data-toggle="pill" href="#vert-tabs-ressources{{ $product->id }}" role="tab" aria-controls="vert-tabs-ressources{{ $product->id }}" aria-selected="false">Ressources</a>
                                <a class="nav-link" id="vert-tabs-options{{ $product->id }}-tab" data-toggle="pill" href="#vert-tabs-options{{ $product->id }}" role="tab" aria-controls="vert-tabs-options{{ $product->id }}" aria-selected="false">Options</a>
                                <a class="nav-link" id="vert-tabs-settings{{ $product->id }}-tab" data-toggle="pill" href="#vert-tabs-settings{{ $product->id }}" role="tab" aria-controls="vert-tabs-settings{{ $product->id }}" aria-selected="false">Paramètres</a>
                            </div>
                        </div>
                        <div class="col-7 col-sm-9">
                            <div class="tab-content" id="vert-tabs-tabContent">
                                <div class="tab-pane text-left fade active show" id="vert-tabs-details{{ $product->id }}" role="tabpanel" aria-labelledby="vert-tabs-details{{ $product->id }}-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Nom</label>
                                            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="@error('name') is-invalid @enderror form-control">
                                            <label>Prix</label>
                                            <input type="text" name="price" value="{{ old('price', $product->price) }}" class="@error('price') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Description (HTML Autorisé)</label>
                                            <textarea name="description" style="height: 100%;" class="form-control">{!! old('description', $product->description) !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-ressources{{ $product->id }}" role="tabpanel" aria-labelledby="vert-tabs-ressources{{ $product->id }}-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>CPU en pourcentage (100% = 1 Coeur)</label>
                                            <input type="text" name="cpu" value="{{ old('cpu', $product->cpu) }}" class="@error('cpu') is-invalid @enderror form-control">
                                            <label>Mémoire (en MB)</label>
                                            <input type="text" name="memory" value="{{ old('memory', $product->memory) }}" class="@error('memory') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>SWAP (en MB)</label>
                                            <input type="text" name="swap" value="{{ old('swap', $product->swap) }}" class="@error('swap') is-invalid @enderror form-control">
                                            <label>Disque (en MB)</label>
                                            <input type="text" name="disk" value="{{ old('disk', $product->disk) }}" class="@error('disk') is-invalid @enderror form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-options{{ $product->id }}" role="tabpanel" aria-labelledby="vert-tabs-options{{ $product->id }}-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Base de données</label>
                                            <input type="text" name="databases" value="{{ old('databases', $product->databases) }}" class="@error('databases') is-invalid @enderror form-control">
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Sauvegardes</label>
                                            <input type="text" name="backups" value="{{ old('backups', $product->backups) }}" class="@error('backups') is-invalid @enderror form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Allocations</label>
                                        <input type="text" name="allocations" value="{{ old('allocations', $product->allocations) }}" class="@error('allocations') is-invalid @enderror form-control">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="vert-tabs-settings{{ $product->id }}" role="tabpanel" aria-labelledby="vert-tabs-settings{{ $product->id }}-tab">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label>Nest</label>
                                            <input type="text" name="nest" value="{{ old('nest', $product->nest) }}" class="@error('nest') is-invalid @enderror form-control">
                                            <label>Node</label>
                                            <select class="@error('node') is-invalid @enderror form-control" name="node">
                                                @foreach(App\Models\PterodactylNodes::all() as $node)
                                                    <option @selected(old('node', $node->id) == $node->id) value="{{ $node->id }}">{{ $node->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Egg</label>
                                            <input type="text" name="egg" value="{{ $product->egg }}" class="@error('egg') is-invalid @enderror form-control">
                                            <label>Visibilité</label>
                                            <select class="@error('visibility') is-invalid @enderror form-control" name="visibility">
                                                <option @selected(old('visibility', $product->visibility) == 'pulic')  value="public">Public</option>
                                                <option @selected(old('visibility', $product->visibility) == 'private') value="private">Privé</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div><input type="text" disabled value="/order/game/{{ $product->id }}" class="form-control"></div>
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
    $("#products").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
        "order": [[ 1, "desc" ]]
    }).buttons().container().appendTo('#products_wrapper .col-md-12:eq(0)');
  });
</script>
@endsection