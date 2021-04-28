@section('sidebar')
    @include('layouts.sidebar')
@endsection

<div>
    @include('layouts.entete')
<div class="card mb-4">
    <div class="card-header">
        <div class="card-title-wrap bar-warning">
            <div class="card-title">
                <div class="row">
                    <div class="col-md-6">
                        {{$data['subtitle']}}
                    </div>
                    <div class="col-md-6 text-md-right">
                        <button class="btn btn-outline-primary" wire:click="retour"><i class="icon-action-undo" aria-hidden="true"></i> Retour</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body bar-primary">
        <div class="card-block">
            <div class="container col-md-10">
      {{-- <edit-avatar :userEditing="user" @avatarUploaded="avatarUpload" @imageError="avatarNull"></edit-avatar> --}}
    <div class="row">
        <div class="col-md-4">
            <form wire:submit.prevent="uploadImage" enctype="multipart/form-data">

               <div class="widget-user-image">
                   @if ($photo)
                       <img src="{{$photo->temporaryUrl()}}" class="img-circle elevation-2" style="height:250px;width:250px" alt="Card image">
                   @else
                    <img class="img-circle elevation-2" style="height:250px;width:250px" src="storage/images/{{$form['avatar']}}" alt="User Avatar">
                   @endif
                </div>
                <div class="text-center">
                    <div class="custom-file mt-3">
                        <input type="file" class="custom-file-input" wire:model="photo">
                        <label for="image" class="custom-file-label">Changer votre avatar</label>
                        <div wire:loading wire:target="photo">Chargement...</div>
                    </div>
                    @error('photo') <span class="error">{{ $message }}</span> @enderror
                    <button type="submit" class="btn btn-outline-warning mt-3">Changer</button>
                </div>
            </form>
        </div>
        <div class="col-md-4 ml-auto">
            <form wire:submit.prevent="save">

                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Nom</span>
                    </div>
                    <input type="text" class="form-control" wire:model="form.name">
                </div><br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="email" class="form-control" wire:model="form.email">
                </div>

                <br><div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Rôle</span>
                    </div>
                    @if ($form['role'] === 'Admin')
                        <select class="form-control" wire:model="form.role">
                            <option value="Commercial">Commercial</option>
                            <option value="Comptable">Comptable</option>
                            <option value="Admin">Admin</option>
                        </select>
                    @else
                    <input type="email" class="form-control" readonly wire:model="form.role">
                    @endif
                    </div>

                <br>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Sexe</span>
                    </div>
                    <select class="form-control" wire:model="form.sexe">
                        <option value="Homme">Homme</option>
                        <option value="Femme">Femme</option>
                    </select>
                </div><br>
                <button class="btn btn-outline-success">Mettre à jour</button>
            </form>
          </div>
      </div>
</div>
        </div>
        <!-- /.row -->
    </div>

</div>
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
