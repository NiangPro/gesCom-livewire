@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')
    
    <div class="card">
            <div class="card-header">
                <div class="card-title-wrap bar-warning">
                    <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item col">
                        <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Profil</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link " id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Paramètres Généraux</a>
                    </li>

                    <li class="nav-item col">
                        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Mot de passe</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">Utilisateurs</a>
                    </li>
                    <li class="nav-item col">
                        <a class="nav-link" id="pills-user-tab" data-toggle="pill" href="#pills-user" role="tab" aria-controls="pills-user" aria-selected="false">Ajout utilisateur</a>
                    </li>
                </ul>
                </div>
                
            </div>
            <div class="card-body">
                <div class="tab-content bg-light" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        {{-- <profil-user></profil-user> --}}
                        @include('infos.profilUser')
                    </div>
                    <div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        {{-- <edit-setting></edit-setting> --}}
                         @include('infos.editSetting')

                    </div>

                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        {{-- <edit-password :user="user"></edit-password> --}}
                        <livewire:edit-password/>
                    </div>
                    <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
                        {{-- <list-users :users="users" @userDeleted="refresh"></list-users> --}}                        
                        @include('infos.users')
                    </div>
                    <div class="tab-pane fade" id="pills-user" role="tabpanel" aria-labelledby="pills-user-tab">
                        {{-- <add-user @userAdded="refresh"></add-user> --}}
                        <livewire:adduser />
                    </div>
                </div>
            </div>
        </div>
</div>
@section('js')
    <script>
        window.addEventListener('userUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('passwordUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Mot de passe', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('userAdded', event =>{
            toastr.success('Ajout avec succès!', 'Utilisateur', {positionClass: 'toast-top-right'});
            location.reload();
        })

        window.addEventListener('userDeleted', event =>{
            toastr.warning('Utilisateur supprimé!', 'Utilisateur', {positionClass: 'toast-top-right'});
        })
    </script>
@endsection