<div class="card">
    <div class="card-header">
        <div class="card-title-wrap bar-success">
            <div class="card-title">
                <div class="row">
                    <div class="col-md-6">
                        {{$title}}
                    </div>
                    <div class="col-md-6 text-md-right">
                        @if ($etat === 'add')
                            <button class="btn btn-outline-primary" wire:click.prevent="retour"><i class="icon-action-undo" aria-hidden="true"></i> Retour</button>
                        @else

                            <button class="btn btn-outline-success" wire:click.prevent="addNew">Ajouter</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body bg-light p-3">
        @if ($etat === 'add')
            <form enctype="multipart/form-data" wire:submit.prevent="save">
                <div class="form-group">
                    <label for="">Nom du site</label>
                    <input type="text"  class="form-control @error('form.nom') is-invalid @enderror" wire:model="form.titre">
                    @error('form.titre')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="" class="">Contrat</label>
                    <div class="custom-file">
                            <input type="file" class="custom-file-input @error('form.fichier') is-invalid @enderror" wire:model="form.fichier">
                            <label for="image" class="custom-file-label">Selectionner un document</label>
                            <div wire:loading wire:target="form.fichier">Chargement...</div>

                            @error('form.fichier')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                </div>
                <button class="btn btn-outline-success">Ajouter</button>
            </form>
        @else
            <div class="row">
                @foreach ($docs as $doc)
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <div class="card-body bar-primary">
                                <div class="card-block">
                                    <div class="align-self-center halfway-fab text-center">
                                        <a class="profile-image">
                                            <i class="fa fa-file-pdf-o text-danger fa-4x" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                    <div class="text-center">
                                        <span class="text-uppercase">{{$doc->titre}}</span>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </div>
                            <div class="card-footer">

                                <div class="row">
                                    <div class="col">
                                        <a href="storage/contrats/{{$doc->fichier}}" target="_blank" class="btn btn-sm btn-success" rel="noopener noreferrer">
                                            <i title="Consulter" class="ft-eye"></i>
                                        </a>
                                </div>
                                <div class="col">
                                    <button class="btn btn-danger btn-sm">
                                        <i title="Supprimer" class="fa fa-trash-o"></i>
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
