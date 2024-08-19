<?php

namespace App\Http\Controllers\backend\stock;

use App\Models\Achat;
use App\Models\Produit;
use App\Models\Ajustement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AjustementController extends Controller
{
    //
    //Ajustement
    public function create($id)
    {
        try {
            $data_ajustement = Achat::find($id);
            return view('backend.pages.stock.ajustement.create', compact('data_ajustement'));
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }


    public function store(Request $request)
    {

        try {

            //request  validate
            $request->validate([
                'stock_ajustement' => 'required|numeric',
                'mouvement' => 'required',
            ]);
            $data_ajustement = Achat::find($request['achat_id']);
            
        
            $newAjustement =   Ajustement::create([
                    'code' => 'SAJ-' . strtoupper(Str::random(8)),
                    'achat_id' => $request['achat_id'],
                    'mouvement' => $request['mouvement'],
                    'stock_actuel' =>  $data_ajustement['quantite_stockable'],
                    'stock_ajustement' =>  $request['stock_ajustement'],
                    'user_id' => Auth::id(),
                ]);

                  //mise a jour du stock dans la table achat
            if ($request['mouvement'] == 'ajouter') {
               
                $data_ajustement->quantite_stockable += $request['stock_ajustement'];
                $data_ajustement->save();
            } elseif ($request['mouvement'] == 'retirer') {
                $data_ajustement->quantite_stockable -= $request['stock_ajustement'];
                $data_ajustement->save();
            }

            //mise a jour du stock dans la table produit si le statut est active
            if ($data_ajustement['statut']=='active' && $request['mouvement'] == 'ajouter') {
                $produit = Produit::find($data_ajustement['produit_id']);
                $produit->stock += $request['stock_ajustement'];
                $produit->save();
            } elseif ($data_ajustement['statut']=='active' && $request['mouvement'] == 'retirer') {
                $produit = Produit::find($data_ajustement['produit_id']);
                $produit->stock -= $request['stock_ajustement'];
                $produit->save();
            }


            Alert::success('Opération réussi', 'Success Message');
            return redirect()->route('ajustement.create', ['id' => $request['achat_id']]);
        } catch (\Throwable $e) {
            return  $e->getMessage();
        }
    }
}
