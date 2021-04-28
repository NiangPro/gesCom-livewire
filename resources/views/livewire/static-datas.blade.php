@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')

    @if ($etat === 'add')
        @include('ajouts.addStaticData')

    @else
    <button class="btn btn-outline-success btn-sm" wire:click="addNew()">
                                <i class="icon-plus"></i>Ajouter
            </button>
    @foreach ($staticDatas as $index => $value)
      <div class="card collapse-icon accordion-icon-rotate">
          <div id="headingCollapse{{$this->removeSpace($index)}}"  class="card-header" >
          <a data-toggle="collapse" href="#collapse{{$this->removeSpace($index)}}" aria-expanded="true" aria-controls="collapse{{$this->removeSpace($index)}}" class="card-title lead text-dark">{{$index}} </a>
        </div>
        <div id="collapse{{$this->removeSpace($index)}}" role="tabpanel" aria-labelledby="headingCollapse{{$this->removeSpace($index)}}" class="collapse">
          <div class="card-body">
            <div class="card-block">
              <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Valeur</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($value as $sd)

                            <tr>
                                <td>{{$sd->label}}</td>
                                <td>{{$sd->valeur}}</td>
                                <td>
                                    <!-- <input type="checkbox" @click="changeStatus(sd.id)" v-if="sd.statut == 1" checked>
                                    <input type="checkbox" @click="changeStatus(sd.id)" v-if="sd.statut == 0"> -->
                                    <div class="form-group">
                                        <input type="checkbox" id="switcheryPrimary" data-size="xs" class="switchery" data-color="success" @if($sd->statut === 1)   checked  @endif/>
                                        </div>
                                    </td>
                                    <td><button class="btn btn-outline-warning btn-sm rounded mr-3" wire:click="edit({{$sd->id}})"><i class="fa fa-edit" aria-hidden="true"></i></button>
                                        <button class="btn btn-outline-danger btn-sm rounded"  wire:click="delete({{$sd->id}})"><i class="fa fa-trash"  aria-hidden="true"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

</div>

@section('js')
    <script>
        window.addEventListener('staticDataUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Donnée statique', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('staticDataAdded', event =>{
            toastr.success('Ajout avec succès!', 'Donnée statique', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('staticDataDeleted', event =>{
            toastr.warning('Donnée statique supprimée!', 'Donnée statique', {positionClass: 'toast-top-right'});
        })
    </script>
@endsection
