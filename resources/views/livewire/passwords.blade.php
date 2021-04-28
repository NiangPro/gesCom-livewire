@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')
    <div class="card mb-4">
    <div class="card-header">
        <div class="card-title-wrap bar-warning">
            <div class="card-title">
                {{$data['subtitle']}}
            </div>
        </div>
    </div>
    <div class="card-body bar-primary">
        <div class="card-block">
            <div class="container col-md-10">
                <form  wire:submit.prevent="editPassword">
            <div class="row">
                <div class="form-group col">
                    <label for="">Nouveau Mot de passe<span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('form.password') is-invalid @enderror" wire:model="form.password" required>
                    @error('form.password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <div class="form-group col">
                    <label for="">Mot de passe de confirmation<span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('form.password_confirmation') is-invalid @enderror" wire:model="form.password_confirmation" required>
                     @error('form.password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
                <div class="col mt-4">
                    <button class="btn btn-outline-success text-right">Enregistrer les modification</button>
                </div>
            </div>
    </form>
            </div>
        </div>
        <!-- /.row -->
    </div>

</div>
</div>

@section('js')
    <script>
        window.addEventListener('passwordUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Mot de passe', {positionClass: 'toast-top-right'});
            location.reload();
        })
    </script>
@endsection
