<?php

namespace App\Models;

use DateTime;
use App\Models\Country;
use App\Models\History;
use App\Models\StaticData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Astuce extends Model
{
    public function addHistorique($message, $type)
    {
        History::create([
            'description' => $message,
            'type' => $type,
            'date' => new DateTime(),
            'user_id' => Auth::user()->id
        ]);
    }

    public function getFonction()
    {
        return StaticData::where('type', 'Type de fonction')->orderBy('valeur', 'ASC')->get();
    }

    public function getTaxe()
    {
        return StaticData::where('type', 'TVA')->orderBy('valeur', 'ASC')->get();
    }

    public function getProductType()
    {
        return StaticData::where('type', 'Type des produits et services')->orderBy('valeur', 'ASC')->get();
    }


    public function getTaskStatus()
    {
        return StaticData::where('type', 'Statut de la tâche')->orderBy('valeur', 'ASC')->get();
    }

    public function getEmployes()
    {
        return Employed::orderBy('prenom', 'ASC')->get();
    }

    public function getClients()
    {
        return Client::orderBy('nom', 'ASC')->get();
    }

    public function getProducts()
    {
        return Product::orderBy('nom', 'ASC')->get();
    }

    public function getCountries()
    {
        return Country::orderBy('nom_fr', 'ASC')->get();
    }

    public function getProspectSource()
    {
        return StaticData::where('type', 'Source du prospect')->orderBy('valeur', 'ASC')->get();
    }

    public function getDevisStatus()
    {
        return StaticData::where('type', 'Statut des devis')->orderBy('valeur', 'ASC')->get();
    }

    public function getPaymentsMode()
    {
        return StaticData::where('type', 'Mode de paiement')->orderBy('valeur', 'ASC')->get();
    }

    public function getExpenseType()
    {
        return StaticData::where('type', 'Type de dépense')->orderBy('valeur', 'ASC')->get();
    }

    public function sumSale()
    {
        $ventes = Vente::select(DB::raw('distinct Sum(total_amount) as somme, Month(date) as mois'))
            ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $som = 0;

        $moisActuel = intval(date('m'));

        foreach ($ventes as $vente) {
            if ($moisActuel === $vente->mois) {
                $som = $vente->somme;
                break;
            }
        }
        return $som;
    }

    public function sumExpense()
    {
        $expenses = Expense::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
            ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $som = 0;

        $moisActuel = intval(date('m'));

        foreach ($expenses as $exp) {
            if ($moisActuel === $exp->mois) {
                $som = $exp->somme;
                break;
            }
        }
        return $som;
    }

    public function saleByMonth()
    {
        $ventes = Vente::select(DB::raw('distinct Sum(total_amount) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();


        $data = [];


        $moisActuel = intval(date('m'));

        for ($i = 1; $i <= $moisActuel; $i++) {
            $som = 0;
            foreach ($ventes as $vente) {
                if ($i === $vente->mois) {
                    $som = $vente->somme;
                    break;
                }
            }
            $data[] = $som;
        }

        // for ($i = 12 - $moisActuel; $i <= 12; $i++) {
        //     $data[] = 0;
        // }

        return json_encode($data);
    }

    public function expenseByMonth()
    {
        $expenses = Expense::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $data = [];


        $moisActuel = intval(date('m'));

        for ($i = 1; $i <= $moisActuel; $i++) {
            $som = 0;
            foreach ($expenses as $exp) {
                if ($i === $exp->mois) {
                    $som = $exp->somme;
                    break;
                }
            }
            $data[] = $som;
        }

        return json_encode($data);
    }

    public function compta()
    {
        $expenses = Expense::select(DB::raw('distinct Sum(montant) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $somex = 0;
        $reponse = [];

        $moisActuel = intval(date('m'));

        foreach ($expenses as $exp) {
            if ($moisActuel === $exp->mois) {
                $somex = $exp->somme;
                break;
            }
        }


        $ventes = Vente::select(DB::raw('distinct Sum(total_amount) as somme, Month(date) as mois'))
        ->groupBy(DB::raw("Month(date)"))->orderBy(DB::raw("MONTH(date)"), "ASC")->get();

        $somsale = 0;
        foreach ($ventes as $vente) {
            if ($moisActuel === $vente->mois) {
                $somsale = $vente->somme;
                break;
            }
        }

        $reponse[] = $somsale - $somex;
        $reponse[] = $somsale;

        $reponse[] = (int)$somex;

        return json_encode($reponse);
    }

    public function getSumBetweenTwoDate($form)
    {
        $resultat = [];
        $vente = DB::table("ventes")
        ->whereBetween(DB::raw("DATE(date)"), [$form['dateFrom'], $form['dateTo']])
            ->groupBy(DB::raw("DATE(date)"))
            ->sum("total_amount");
        $depense = DB::table("expenses")
        ->whereBetween(DB::raw("DATE(date)"), [$form['dateFrom'], $form['dateTo']])
            ->groupBy(DB::raw("DATE(date)"))
            ->sum("montant");

        $resultat['vente'] = $vente;
        $resultat['depense'] = $depense;
        $resultat['from'] = $form['dateFrom'];
        $resultat['to'] = $form['dateTo'];

        return $resultat;
    }

    public function getAppVars()
    {
        $data = [];
        $data['name'] = config('app.name');
        $data['logo'] = config('app.logo');
        $data['icon'] = config('app.icon');

        return $data;
    }

    public function allCounts()
    {
        $nbreVente = Vente::count();
        $nbreClient = Client::count();
        $nbreDevis = Devis::count();
        $nbreProduit = Product::count();

        $data['vente'] = $nbreVente;
        $data['client'] = $nbreClient;
        $data['devis'] = $nbreDevis;
        $data['produit'] = $nbreProduit;

        return $data;
    }

}
