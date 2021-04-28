@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')
     <div class="card">
         <div class="card-header">
            <div class="card-title-wrap bar-warning">
                <div class="card-title">
                    {{$data['subtitle']}}
                </div>
            </div>
        </div>
            <div class="card-body collapse show">
                <div class="card-block card-dashboard">
                    <form enctype="multipart/form-data" wire:submit.prevent="changeVars">
                        <div class="row">
                            <div class="form-group col-3 ">
                                <label for="">Nom du site</label>
                                <input type="text"  class="form-control" wire:model="appVars.name">
                            </div>

                            <div class="col">
                                <label for="" class="">Logo</label>
                                <div class="row">
                                    <div class="custom-file col ">
                                        <input type="file" class="custom-file-input" wire:model="logo">
                                        <label for="image" class="custom-file-label">Selectionner une image</label>
                                        <div wire:loading wire:target="logo">Chargement...</div>
                                    </div>
                                    <div class="text-center col" style="margin-top:-50px;">
                                        @if ($logo)
                                            <img src="{{$logo->temporaryUrl()}}"class="figure-img img-fluid rounded" alt="" style="max-height:100px;">
                                        @else
                                            <img src="storage/images/{{$appVars['logo']}}"class="figure-img img-fluid rounded" alt="" style="max-height:100px;">
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <label for="" class="">Favicon</label>
                                <div class="row">
                                    <div class="custom-file col ">
                                        <input type="file" class="custom-file-input" wire:model="icon">
                                        <label for="image" class="custom-file-label">Selectionner une image</label>
                                        <div wire:loading wire:target="icon">Chargement...</div>
                                    </div>
                                    <div class="text-center col" style="margin-top:-50px;">
                                        @if ($icon)
                                            <img src="{{$icon->temporaryUrl()}}"class="figure-img img-fluid rounded" alt="" style="max-height:100px;">
                                        @else
                                            <img src="storage/images/{{$appVars['icon']}}"class="figure-img img-fluid rounded" alt="" style="max-height:100px;">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-right m-3">
                                <button class="btn btn-outline-primary btn-sm text-right">Enregistrer les modification</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</div>

@section('js')
    <script>
        window.addEventListener('updateSetting', event =>{
            toastr.success('Mis à jour avec succès!', 'Paramètres', {positionClass: 'toast-top-right'});
            location.reload();
        })
    </script>
@endsection
