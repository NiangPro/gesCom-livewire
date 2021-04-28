<div class="card">
    <div class="card-header">
        <div class="card-title-wrap bar-success row">
            <div class="col">
                <h1 class="pl-md-3">{{$data['subtitle']}}</h1>
            </div>
            <div class="col text-md-right">
                <button class="btn btn-outline-primary" wire:click="retour"><i class="icon-action-undo" aria-hidden="true"></i> Retour</button>
            </div>
        </div>
    </div>
    <div class="card-body collapse show">
        <div class="card-block card-dashboard container col-md-6">
            <form wire:submit.prevent="save">
                    {{-- @csrf --}}
                    <div class="form-group">
                            <label for="category">Catégorie<span class="text-danger">*</span></label>

                            <select class="form-control @error('form.category') is-invalid @enderror" wire:model="form.category" >
                                <option value="">Selectionner un type de dépense</option>
                                @foreach ($categories as $c)
                                    <option value="{{$c->valeur}}">{{$c->valeur}}</option>
                                @endforeach
                            </select>
                        @error('form.category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="form-group col">
                            <label for="montant">Montant<span class="text-danger">*</span></label>

                        <input id="montant" type="number" class="form-control @error('form.montant') is-invalid @enderror"  wire:model="form.montant" required >

                        @error('form.montant')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col">
                            <label for="date">Date<span class="text-danger">*</span></label>

                        <input id="date" type="date" class="form-control @error('form.date') is-invalid @enderror"  wire:model="form.date" required >

                        @error('form.date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    </div>
                     <div class="form-group">
                            <label for="description">Description</label>

                        <textarea  class="form-control @error('form.description') is-invalid @enderror"  wire:model="form.description" ></textarea>

                        @error('form.description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="form-group col">
                            <label >Reférence</label>
                            <input id="recu" type="text" class="form-control @error('form.recu') is-invalid @enderror"  wire:model="form.recu" >

                        @error('form.recu')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                        <div class="form-group col">
                            <label >Mode de paiement</label>
                            <select class="form-control @error('form.payment_mode') is-invalid @enderror" wire:model="form.payment_mode" >
                                <option value="">Selectionner un mode</option>
                                @foreach ($payments as $p)
                                    <option value="{{$p->valeur}}">{{$p->valeur}}</option>
                                @endforeach
                            </select>

                            @error('form.payment_mode')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @if ($form['id'])
                        <button type="submit" class="btn btn-outline-warning">
                            Modfifier
                        </button>
                    @else
                        <button type="submit" class="btn btn-outline-success">
                            Ajouter
                        </button>
                    @endif

            </form>
        </div>
    </div>
    </div>
