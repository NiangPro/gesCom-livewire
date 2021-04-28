@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')

    @if ($etat === 'add')
        @include('ajouts.adduser')
    @elseif ($etat === 'info')
        @include('infos.infoUser')
    @elseif ($etat === 'edit')
        @include('edits.editPassword')
    @else
        <button class="btn btn-outline-success" wire:click="addNew">Ajouter</button>
        <div class="row">
            @foreach ($users as $user)

                <div class="col-xl-3 col-lg-12">
                    <div class="card mb-4">
                        <div class="card-body bar-primary">
                            <div class="card-block">
                                <div class="align-self-center halfway-fab text-center">
                                    <a class="profile-image">
                                        <img src="storage/images/{{$user->avatar}}" class="rounded-circle img-border gradient-summer width-100" alt="Card image">
                                    </a>
                                </div>
                                <div class="text-center">
                                    <span class="font-medium-2 text-uppercase">{{$user->name}}</span>
                                    <p class="grey font-small-2">{{$user->role}}</p>
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                        <div class="card-footer">

                            <div class="row">
                                <div class="col">
                                <button class="btn btn-outline-success btn-sm" title="Consulter" wire:click="info({{$user->id}})"><i class="ft-eye"></i> </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-warning btn-sm" title="Modifier le mot de passe" wire:click="edit({{$user->id}})"><i class="ft-edit"></i> </button>
                            </div>
                            <div class="col">
                                <button class="btn btn-outline-danger btn-sm" title="Supprimer" wire:click="delete({{$user->id}})"><i class="fa fa-trash-o"></i> </button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.widget-user -->
                </div>
            @endforeach

        </div>
        <div class="row">
            {{ $users->links() }}
        </div>
    @endif
</div>

@section('js')
    <script>
        window.addEventListener('userUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('profilUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('userAdded', event =>{
            toastr.success('Ajout avec succès!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('userDeleted', event =>{
            toastr.warning('Utilisateur supprimé!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })
    </script>
@endsection
