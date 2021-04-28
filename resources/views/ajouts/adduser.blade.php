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
                <div class="row">
                    <div class="form-group col">
                    <label for="name">Nom<span class="text-danger">*</span></label>
                     <input id="name" type="text" class="form-control @error('form.name') is-invalid @enderror" name="name" required wire:model="form.name" autofocus>
                                @error('form.name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                <div class="form-group col">
                    <label for="email">Adresse E-mail<span class="text-danger">*</span></label>
                    <input id="email" type="email" class="form-control @error('form.email') is-invalid @enderror" wire:model="form.email" required>
                                @error('form.email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                </div>
                </div>
                <div class="form-group">
                    <label for="password">Rôle<span class="text-danger">*</span></label>
                    <select  class="form-control @error('form.role') is-invalid @enderror" wire:model="form.role">
                                    <option value="">Selectionner un rôle</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Comptable">Comptable</option>
                                    <option value="Admin">Admin</option>
                                </select>
                                @error('form.role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="form-group">
                    <label for="sexe">Sexe<span class="text-danger">*</span></label>
                    <select  class="form-control @error('form.sexe') is-invalid @enderror" wire:model="form.sexe">
                                    <option value="">Selectionner un genre</option>
                                    <option value="Homme">Homme</option>
                                    <option value="Femme">Femme</option>
                                </select>
                                @error('form.sexe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                </div>
                <div class="row">
                    <div class="form-group col">
                    <label for="password">Mot de passe<span class="text-danger">*</span></label>
                    <input id="password" type="password" class="form-control @error('form.password') is-invalid @enderror" name="password" required wire:model="form.password">
                                @error('form.password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                </div>
                <div class="form-group col">
                    <label for="password_confirm">Mot de passe de confirmation<span class="text-danger">*</span></label>
                    <input id="password_confirm" type="password" class="form-control" name="password_confirmation" required wire:model="form.password_confirmation">

                </div>
                </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button  class="btn btn-outline-success">
                                    Ajouter
                                </button>
                            </div>
                        </div>
            </form>
        </div>
    </div>
    </div>

