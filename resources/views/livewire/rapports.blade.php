@section('sidebar')
    @include('layouts.sidebar')
@endsection


<div>
    @include('layouts.entete')

    <div class="row">
        <div class="col-md-7">
            <div class="row">
                @include('infos.rapportBetween')
            </div>
            <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title-wrap bar-success">
                                <h5 class="">Rapports Annuels des Ventes et Dépenses</h5>
                            </div>                    
                        </div>
                        <div class="card-body">
                            <canvas id="myChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
        </div>
        <div class="col-md-5">
            <div class="row">                
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title-wrap bar-success">
                                <h5 class="">Graphique du mois (<?= date('M') ?>)</h5>
                            </div>
                            
                        </div>
                        <div class="card-body">
                            <canvas id="myBar" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <div class="card-title-wrap bar-success">
                        <h5 class="">Comptabilité du mois (<?= date('M') ?>)</h5>
                    </div>
                    
                </div>
                <div class="card-body">
                    <div class="row p-2">
                        <div class="col-lg-12 col-12">
                            <div class="card gradient-light-blue-cyan">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="icon-basket-loaded text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h3 class="text-white">{{$sumSale}} FCFA</h3>
                                        <span>Ventes</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            <div class="card gradient-orange-amber">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="icon-credit-card text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h3 class="text-white">{{$sumExpense}} FCFA</h3>
                                        <span>Dépenses</span>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-12">
                            <div class="card gradient-mint">
                                <div class="card-body">
                                <div class="px-3 py-3">
                                    <div class="media">
                                    <div class="align-center">
                                        <i class="icon-wallet text-white font-large-2 float-left"></i>
                                    </div>
                                    <div class="media-body text-white text-right">
                                        <h3 class="text-white">{{$sumSale - $sumExpense}} FCFA</h3>
                                        <span>Revenues</span>
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
        
    </div>

</div>

</div>
@section('js')
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var depenses = JSON.parse(`<?php echo $depenses; ?>`);
    var ventes = JSON.parse(`<?php echo $ventes; ?>`);
    var compta = JSON.parse(`<?php echo $compta; ?>`);
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fev', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil', 'Août', 'Sept', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Dépenses',
                data: depenses,
                backgroundColor:'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
            },
            {
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
            labels: ['Ventes', 'Dépenses', 'Revenues'],
            datasets: [{
                label: 'Comptabilité mensuelle',
                data: [compta[1],compta[2], compta[0]],
                backgroundColor: ['blue', 'red', 'green'],
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
</script>
@endsection
