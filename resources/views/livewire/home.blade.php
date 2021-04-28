@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')
    <div class="row p-2">
                        <div class="col-md-3">
                            <div class="card gradient-light-blue-cyan">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="icon-basket-loaded text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h1 class="text-white">{{$total['vente']}}</h1>
                                        <span>Ventes</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card gradient-orange-amber">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="fas fa-file-invoice text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h1 class="text-white">{{$total['devis']}}</h1>
                                        <span>Devis</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card gradient-mint">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="fas fa-users text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h1 class="text-white">{{$total['client']}}</h1>
                                        <span>Clients</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card gradient-king-yna">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="fab fa-product-hunt text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h1 class="text-white">{{$total['produit']}}</h1>
                                        <span>Produits & Services</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
    </div>

    <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title-wrap bar-success">
                                    <h5 class="">Rapports Annuels des Ventes</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="myChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title-wrap bar-success">
                                    <h5 class="">Rapports Annuels des Dépenses</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="myBar" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-12">
                        <livewire:todolist/>
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title-wrap bar-danger">
                                <h4 class="card-title">Dernières Activitées</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="col-12 timeline-left" id="activity">
                                <div class="timeline">
                                    <ul class="list-unstyled base-timeline activity-timeline">
                                        @foreach ($activities[0] as $act)
                                        <li class="">
                                            <div class="timeline-icon   @if ($act->type === 'Ajout') bg-success @elseif($act->type === 'Edition') bg-warning @else bg-danger @endif">
                                                @if ($act->type === 'Ajout')
                                                    <i class="icon-plus"></i>
                                                @elseif($act->type === 'Edition')
                                                    <i class="ft-edit"></i>
                                                @else
                                                <i class="ft-trash-2"></i>
                                                @endif
                                            </div>
                                            <div class="base-timeline-info">
                                            <a href="#" class="text-uppercase  @if ($act->type === 'Ajout') text-success @elseif($act->type === 'Edition') text-warning @else text-danger @endif">{{$act->description}}</a>
                                            </div>
                                            <small class="text-muted">
                                                                {{$act->date}}
                                            </small>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>


@section('js')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var depenses = JSON.parse(`<?php echo $depenses; ?>`);
    var ventes = JSON.parse(`<?php echo $ventes; ?>`);

    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Ventes',
                data: ventes,
                backgroundColor:'lightgreen',
                borderColor: 'green',
                borderWidth: 1,
            }
        ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },
    });

    var ct = document.getElementById('myBar').getContext('2d');
    var myChart2 = new Chart(ct, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Fev', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Dépenses',
                data: depenses,
                backgroundColor: 'rgba(255, 99, 132, 1)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    window.addEventListener('errorDate', event =>{
            toastr.error('La date du debut doit être inférieur à la date de Fin', 'Date', {positionClass: 'toast-top-right'});
        });
    window.addEventListener('refresh', event =>{
            location.reload();
        });

        window.addEventListener('todoAdded', event =>{
            toastr.success('Ajout avec succès!', 'Travail à faire', {positionClass: 'toast-top-right'});
        });
        window.addEventListener('todoDeleted', event =>{
            toastr.error('Vous avez supprimé le taf!', 'Travail à faire', {positionClass: 'toast-top-right'});
        });
</script>
@endsection
