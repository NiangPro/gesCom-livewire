@section('sidebar')
    @include('layouts.sidebar')
@endsection
<div>
    @include('layouts.entete')
    @if ($etat === 'add')
        @include('ajouts.addVente')
    @elseif ($etat === 'info')
        @include('infos.infoVente')
    @else
        <button class="btn btn-outline-success" wire:click="addNew">Ajouter</button>
        <div class="card">
            <div class="card-body collapse show">
                <div class="card-block card-dashboard">
                    <table class="table table-striped table-responsive-sm table-bordered file-export">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Employé</th>
                                <th>Montant Total</th>
                                <th>Produit/Service</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ventes as $v)
                                <tr>
                                    <td>
                                                {{$v->date}}
                                            </td>
                                            <td>{{ $v->client->nom }}</td>
                                            <td>
                                                {{ $v->employed->prenom }}
                                                {{ $v->employed->nom }}
                                            </td>
                                            <td>{{ $v->total_amount }} F CFA</td>
                                            <td>
                                                @foreach ($v->produitVendus as $item)
                                                    <span>{{$item->nom}}</span><br>
                                                @endforeach
                                            </td>
                                            <td>
                                                <button
                                                    class="btn btn-outline-primary rounded btn-sm"
                                                 wire:click.prevent="info({{$v->id}})">
                                                    <i
                                                        class="fa fa-eye"></i>
                                                </button>
                                                <button
                                                    class="btn btn-outline-danger rounded btn-sm" wire:click.prevent="delete({{$v->id}})">
                                                    <i
                                                        class="fa fa-trash"
                                                        aria-hidden="true"
                                                    ></i>
                                                </button>
                                            </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@section('js')
    <script>
        window.addEventListener('venteUpdated', event =>{
            toastr.success('Mis à jour avec succès!', 'Vente', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('venteAdded', event =>{
            toastr.success('Ajout avec succès!', 'Vente', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('venteDeleted', event =>{
            toastr.warning('Vente supprimé!', 'Vente', {positionClass: 'toast-top-right'});
        })

        window.addEventListener('rowEmpty', event =>{
            toastr.error('Veuillez remplir d\'abord la ligne courante', 'Vente', {positionClass: 'toast-bottom-right'});
        })

        window.addEventListener('rowNoAssign', event =>{
            toastr.error('Veuillez ajouter ou supprimer la ligne vide', 'Vente', {positionClass: 'toast-bottom-right'});
        })
    </script>
@endsection
