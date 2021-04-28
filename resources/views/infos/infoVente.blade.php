
<section class="invoice-template">
    <div class="card">
        <div class="card-header">
            <button class="btn btn-outline-primary" wire:click="retour"><i class="icon-action-undo" aria-hidden="true"></i> Retour</button>
            <button type="button" class="btn btn-outline-success" onclick="printDiv('infoDevis')"><i class="ft-file-text" aria-hidden="true"></i> Imprimer</button>
        </div>
        <div class="card-body p-3" id="infoDevis">
            <div id="invoice-template" class="card-block">
                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row">
                    <div class="col-6 text-left">
                        <img src="{{asset('storage/images/logo.png')}}" alt="company logo" class="mb-2" width="70">
                        <ul class="px-0 list-unstyled">
                            <ul class="px-0 list-unstyled">
                            {{-- <li class="text-bold-800">{{config('app.name')}}</li> --}}
                            <li class="h5">CLient : {{$vente->client->nom}}</li>
                            <li class="h5">Adresse : {{$vente->client->adresse}}</li>
                            <li class="h5">Tel : {{$vente->client->tel}}</li>
                            <li class="h5">Email : {{$vente->client->email}}</li>
                        </ul>
                        </ul>
                    </div>
                    <div class="col-md-6 text-right">
                        <h2 class="h1">Facture</h2>
                        <p class="text-bold h5"># Fac-{{$vente->id}}</p>
                        <p class=" h5">Date: {{$vente->date}}</p>
                    </div>
                </div>
                <!--/ Invoice Company Details -->
                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Produit &amp; Description</th>
                                        <th class="text-right">Prix</th>
                                        <th class="text-right">Quantité</th>
                                        <th class="text-right">Montant</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($vente->produitVendus as $key=>$item)
                                        <tr>
                                            <th scope="row">{{$key+1}}</th>
                                            <td>
                                                <p>{{$item->nom}}</p>
                                            </td>
                                            <td class="text-right">{{$item->amount}}F CFA</td>
                                            <td class="text-right">{{$item->qte}}</td>
                                            <td class="text-right">{{$item->qte*$item->amount}}F CFA</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-sm-12 text-left">

                        </div>
                        <div class="col-md-8 col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td  class="h1">Remise:</td>
                                            <td class="text-right h1">{{$vente->discount}}%</td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold h1">Montant Total:</td>
                                            <td class="text-bold h1 text-right">{{$vente->total_amount}} F CFA</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Invoice Footer -->
                <div id="invoice-footer">
                    <p>Merci de votre confiance, A Bientôt.</p>
                    </div>
                </div>
                <!--/ Invoice Footer -->
            </div>
        </div>
    </div>
</section>
