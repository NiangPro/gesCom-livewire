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
        <div class="card-block card-dashboard container col-md-4">
            <form method="POST" wire:submit.prevent="save">
                <div class="form-group controls">
                    <label for="">Type</label>
                    <select wire:model="form.type" class="form-control">
                        <option value="">Selectionner un type</option>
                        @foreach ($types as $t)
                            <option value="{{$t->type}}">{{$t->type}}</option>
                        @endforeach
                    </select>
                    @error('form.type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="controls">
                        <label for="">Valeur</label>
                        <input type="text"  wire:model="form.valeur"  class="form-control">
                        @error('form.valeur')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @if ($form['id'])
                <button class="btn btn-outline-warning">Modifier</button>
                @else
                <button class="btn btn-outline-success">Ajouter</button>
                @endif
            </form>
        </div>
    </div>
    </div>
