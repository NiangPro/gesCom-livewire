<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <div class="card-title-wrap bar-success">
                <div class="row">
                    <div class="col">
                        <h5 class="">Rapports entre deux dates</h5>
                    </div>
                    <div class="col text-right">
                        <button wire:click.prevent="refresh" title="Annuler la recherche" class="btn"><i class="ft-refresh-ccw"></i></button>
                    </div>
                </div>
            </div>                    
        </div>
        <div class="card-body">
            <div class="row">
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Date du <span class="text-danger">*</span></span>
                                        
                                    </div>
                                    <input type="date" class="form-control @error('form.dateFrom') is-invalid @enderror" wire:model="form.dateFrom">
                                    @error('form.dateFrom')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Au<span class="text-danger">*</span></span>
                                    </div>
                                    <input type="Date" class="form-control @error('form.dateTo') is-invalid @enderror" wire:model="form.dateTo">
                                    @error('form.dateTo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-success" wire:click="search">Valider</button>
                            </div>
            </div>
            @if ($etat)
            <h4 class="mt-3">Résultat de la recherche : Date du {{$form['dateFrom']}} au {{$form['dateTo']}}</h4>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
            <div class="media align-items-stretch">
                <div class="p-2 text-center bg-info rounded-left pt-3">
                <i class="icon-credit-card font-large-2 text-white"></i>
                </div>
                <div class="p-2 media-body">
                <h6>Dépenses</h6>
                <h6 class="text-bold-400 mb-0">{{$results['depense']}}FCFA</h6>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
            <div class="media align-items-stretch">
                <div class="p-2 text-center bg-success rounded-left pt-3">
                <i class="icon-basket-loaded font-large-2 text-white"></i>
                </div>
                <div class="p-2 media-body">
                <h6>Ventes</h6>
                <h6 class="text-bold-400 mb-0">{{$results['vente']}}FCFA</h6>
                </div>
            </div>
            </div>
        </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-body">
            <div class="media align-items-stretch">
                <div class="p-2 text-center bg-warning rounded-left pt-3">
                <i class="icon-wallet font-large-2 text-white"></i>
                </div>
                <div class="p-2 media-body">
                <h6>Revenues</h6>
                <h6 class="text-bold-400 mb-0">{{$results['vente'] - $results['depense']}}FCFA</h6>
                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
@endif
        </div>
    </div>
</div>
