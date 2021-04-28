<?php

namespace App\Http\Livewire;

use App\Models\Vente;
use App\Models\Astuce;
use App\Models\Product;
use Livewire\Component;
use App\Models\ProduitVendu;

class Ventes extends Component
{
    public $data = [
        'icon' => 'icon-basket-loaded',
        'title' => 'Ventes',
        'subtitle' => 'Liste des ventes'
    ];

    public $etat = 'list';
    public $histo;
    public $emps;
    public $clients;
    public $products;
    public $idProd;
    public $subtotal = 0.00;
    public $allProducts = [];
    public $vente;

    public $form = [
        'total_amount' => 0,
        'discount' => 0,
        'client_id' => null,
        'employed_id' => null,
        'date' => null,
        'description' => null,
        'id' => null,
    ];

    protected $rules = [
        'form.client_id' => 'required',
        'form.employed_id' => 'required',
        'form.date' => 'required',
    ];

    protected $messages = [
        'form.client_id.required' => 'Le champ client est requis',
        'form.employed_id.required' => 'Le champ employé est requis',
        'form.date.required' => 'Le champ date est requis',
    ];

    public function addNew()
    {
        $this->data['subtitle'] = 'Ajout Vente';
        $this->etat = 'add';
        $this->addRow();
    }

    public function retour()
    {
        $this->data['subtitle'] = 'Liste des ventes';
        $this->etat = 'list';

        $this->initValues();
    }

    public function info($id)
    {
        $this->data['subtitle'] = 'Information Vente';
        $this->etat = 'info';

        $this->vente = Vente::with(['client', 'employed', 'produitVendus'])->where('id', $id)->first();

    }

    public function fieldsNotEmpty()
    {
            $response = true;

            if(count($this->allProducts) > 0){
                foreach($this->allProducts as $item){
                    if($item['nom'] == '' || $item['description'] == '' || $item['qte'] == 0 || $item['tarif'] == 0)
                        $response = false;
                };
            }else{
                $response = false;
            }

            return $response;
    }

    public function getMontantTotal(){
        $this->subtotal = 0;
        foreach ($this->allProducts as $product) {
            $this->subtotal += $product['amount'];
        }

        $this->form['total_amount'] = $this->subtotal - ($this->subtotal * ($this->form['discount']/100));
    }

    public function getMontant($index)
    {
        dd(request()->all());


        $this->allProducts[$index]['amount'] = $this->allProducts[$index]['tarif'] * $this->allProducts[$index]['qte'] * (1+$this->allProducts[$index]['taxe']/100);

        $this->getMontantTotal();
    }

    public function addRow(){
        if($this->fieldsNotEmpty() || count($this->allProducts) == 0){
            $this->allProducts[] = [
                'nom' =>'',
                'description' =>'',
                'tarif' =>0,
                'qte' =>0,
                'taxe' =>0,
                'amount' =>0
            ];
            $this->getMontantTotal();
        }else{
            $this->dispatchBrowserEvent('rowEmpty');
        }
    }

    public function deleteRow($key){
        // $key = array_search($product, $this->allProducts);

        // if ($key !== false)
            unset($this->allProducts[$key]);

        $this->getMontantTotal();
    }

    public function addToAllProducts()
    {
        if($this->idProd){
            array_pop($this->allProducts);

            $product = Product::where('id', $this->idProd)->first();

            $this->allProducts[] = [
                'nom' => $product->nom,
                'description' => $product->description,
                'tarif' => $product->tarif,
                'qte' => 1,
                'taxe' => $product->taxe,
                'amount' => $product->tarif
            ];
        }

        $this->idProd = null;
        $this->getMontantTotal();
    }

    public function save()
    {
        $this->validate();

        if($this->fieldsNotEmpty()){
            $vente = new Vente();
            $vente->date = $this->form['date'];
            $vente->client_id = $this->form['client_id'];
            $vente->employed_id = $this->form['employed_id'];
            $vente->description = $this->form['description'];
            $vente->discount = $this->form['discount'];
            $vente->total_amount = $this->form['total_amount'];

            $vente->save();

            foreach ($this->allProducts as $prod) {
                ProduitVendu::create([
                    'nom' => $prod['nom'],
                    'qte' => $prod['qte'],
                    'description' => $prod['description'],
                    'taxe' => $prod['taxe'],
                    'amount' => $prod['amount'],
                    'vente_id' => $vente->id
                ]);
            }
            $this->dispatchBrowserEvent('venteAdded');
            $this->histo->addHistorique("Ajout d'une vente", "Ajout");

            $this->retour();

        }else{
            $this->dispatchBrowserEvent('rowNoAssign');
        }
    }

    public function delete($id)
    {
        $vente = Vente::where('id', $id)->first();

        $vente->delete();

        $this->dispatchBrowserEvent('venteDeleted');
        $this->histo->addHistorique("Suppression d'une vente", "Suppression");
    }

    public function render()
    {
        $ventes = Vente::with(['client', 'employed', 'produitVendus'])->orderBy('date', 'DESC')->get();

        $this->histo = new Astuce();

        $this->emps = $this->histo->getEmployes();
        $this->clients = $this->histo->getClients();
        $this->products = $this->histo->getProducts();


        return view('livewire.ventes', [
            'page' => 'vente',
            'ventes' => $ventes,
        ])->layout('layouts.app');
    }

    private function initValues()
    {
        $this->form['total_amount'] = 0;
        $this->form['discount'] = 0;
        $this->form['client_id'] = null;
        $this->form['employed_id'] = null;
        $this->form['date'] = null;
        $this->form['description'] = null;
        $this->form['id'] = null;

        $this->allProducts = [];
        $this->idProd = null;
        $this->vente = null;
        $this->subtotal = 0.00;
    }
}
