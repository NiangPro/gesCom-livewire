<div>
    @if ($etat === 'add')
            <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-primary">
                    <h4 class="card-title">
                        <div class="row">
                            <div class="col">
                                Ajout Taf
                            </div>
                            <div class="col text-md-right">
                                <button type="button" class="btn btn-outline-success btn-sm" wire:click.prevent="retour">
                                    retour
                                </button>
                            </div>
                        </div>
                    </h4>
                </div>
            </div>
            <div class="card-body p-2">
                <form wire:submit.prevent="save">
                    {{-- @csrf --}}
                    <div class="form-group">
                            <label for="titre">Titre<span class="text-danger">*</span></label>

                        <input id="titre" type="text" class="form-control @error('form.titre') is-invalid @enderror"  wire:model="form.titre" required >

                        @error('form.titre')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                            <label for="date">Date<span class="text-danger">*</span></label>

                        <input id="date" type="datetime-local" class="form-control @error('form.date') is-invalid @enderror"  wire:model="form.date" required >

                        @error('form.date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <button class="btn btn-outline-success">
                            Ajouter
                    </button>

            </form>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-primary">
                    <h4 class="card-title">
                        <div class="row">
                            <div class="col">
                                A faire
                            </div>
                            <div class="col text-md-right">
                                <button type="button" class="btn btn-outline-success btn-sm" wire:click.prevent="add">
                                    Ajouter
                                </button>
                            </div>
                        </div>
                    </h4>
                </div>
            </div>
            <div class="card-body p-2">
                <ul class="list-group">
                    @foreach ($todos as $td)

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <input type="checkbox" @if($td->is_check === 1) checked @endif> {{$td->titre}} <span class="text-success">{{$td->date}}</span>
                        </span>
                        <span class="badge badge-danger badge-pill" wire:click.prevent="delete({{$td->id}})"><i class="fa fa-trash" aria-hidden="true"></i></span>

                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>

