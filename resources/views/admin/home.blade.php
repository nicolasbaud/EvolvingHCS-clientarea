@extends('admin.layouts.page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-users"></i></span>
            <div class="info-box-content hide" id="result6">
                <span class="info-box-text">Client(s)</span>
                <span class="info-box-number">{{ App\Models\User::count() }}</span>
            </div>
            <div class="overlay dark" id="loader6">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-envelope-open-text"></i></span>
            <div class="info-box-content hide" id="result1">
                <span class="info-box-text">Ticket Ouvert</span>
                <span class="info-box-number">{{ App\Models\Tickets::where('status', 'wait_staff')->where('status', 'open')->count() }}</span>
            </div>
            <div class="overlay dark" id="loader1">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
</div>
<h5>Addons Pterodactyl</h5>
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-cubes"></i></span>
            <div class="info-box-content hide" id="result2">
                <span class="info-box-text">Services</span>
                <span class="info-box-number">{{ App\Models\PterodactylServices::count() }}</span>
            </div>
            <div class="overlay dark" id="loader2">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-server"></i></span>
            <div class="info-box-content hide" id="result3">
                <span class="info-box-text">Nodes</span>
                <span class="info-box-number">{{ App\Models\PterodactylNodes::count() }}</span>
            </div>
            <div class="overlay dark" id="loader3">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content hide" id="result4">
                <span class="info-box-text">Produits</span>
                <span class="info-box-number">{{ App\Models\PterodactylProducts::count() }}</span>
            </div>
            <div class="overlay dark" id="loader4">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box shadow">
            <span class="info-box-icon bg-primary"><i class="fas fa-newspaper"></i></span>
            <div class="info-box-content hide" id="result5">
                <span class="info-box-text">Logs</span>
                <span class="info-box-number">{{ App\Models\PterodactylLogs::count() }}</span>
            </div>
            <div class="overlay dark" id="loader5">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <div class="card card-white">
            <div class="card-header">
                <h3 class="card-title">Chiffre d'affaire</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h3><span class="text-success font-weight-bold">{{ $turnover['today'] }}€</span><br /></h3>
                            <small>Chiffre d'affaire du jour</small>
                        </div>
                        <div class="col-md-6">
                            <h3><span class="text-info font-weight-bold">{{ $turnover['yesterday'] }}€</span><br /></h3>
                            <small>Chiffre d'affaire de hier</small>
                        </div>
                        <div class="col-md-6">
                            <h3><span class="text-warning font-weight-bold">{{ $turnover['month'] }}€</span><br /></h3>
                            <small>Chiffre d'affaire du mois</small>
                        </div>
                        <div class="col-md-6">
                            <h3><span class="text-danger font-weight-bold">{{ $turnover['year'] }}€</span><br /></h3>
                            <small>Chiffre d'affaire de l'année</small>
                        </div>
                        <div class="col-md-6">
                            <h3><span class="font-weight-bold">{{ $turnover['all'] }}€</span><br></h3>
                            <small>Chiffre d'affaire total</small>
                        </div>
                    </div>
                </div>
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
<script type="text/javascript">
setTimeout(function (){
    $('#loader1').addClass('hide');
    $('#result1').removeClass('hide');

    $('#loader2').addClass('hide');
    $('#result2').removeClass('hide');

    $('#loader3').addClass('hide');
    $('#result3').removeClass('hide');

    $('#loader4').addClass('hide');
    $('#result4').removeClass('hide');

    $('#loader5').addClass('hide');
    $('#result5').removeClass('hide');

    $('#loader6').addClass('hide');
    $('#result6').removeClass('hide');
}, 500)
</script>
@endsection