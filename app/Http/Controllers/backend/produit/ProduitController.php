<?php

namespace App\Http\Controllers\backend\produit;

use App\Models\Unite;
use App\Models\Format;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProduitController extends Controller
{
    //
    public function index()
    {
    }

    public function create(Request $request)
    {

        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();
            $data_produit = Produit::with('categorie.ancestors')->get();
            
            $data_format = Format::all();
            $data_unite = Unite::all();
            $data_fournisseur = Fournisseur::all();

            // dd($data_produit->toArray());
            return view('backend.pages.produit.create', compact('data_categorie' , 'data_produit' , 'data_format', 'data_unite' , 'data_fournisseur'));
        } catch (\Throwable $e) {
           return  $e->getMessage();
        }

        // dd($data_categorie->toArray());


    }

    /**Formulaire pour creer un nouveau produit */
    public function createNewProduct(Request $request)
    {
        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn ($q) => $q->OrderBy('position', 'ASC'))->withCount('children')->OrderBy('position', 'ASC')->get();
            return view('backend.pages.produit.partials.createProduct', compact('data_categorie'));
        } catch (\Throwable $e) {
            $e->getMessage();
        }

        // dd($data_categorie->toArray());


    }


    /**Ajouter un nouveau produit */
    public function StoreNewProduct(Request $request)
    {
        try {
            //request validation
            $request->validate([
                'nom' => 'required',
                'description' => '',
                'categorie' => 'required',
                'stock' => '',
                'visible' => '',
            ]);

            $data_produit = Produit::create([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'categorie_id' => $request['categorie'],
            ]);

            if (request()->hasFile('imagePrincipale')) {
                $data_produit->addMediaFromRequest('imagePrincipale')->toMediaCollection('ProduitImage');
            }


            if ($request->images) {

                foreach ($request->input('images') as $fileData) {
                    // Decode base64 file
                    $fileData = explode(',', $fileData);
                    $fileExtension = explode('/', explode(';', $fileData[0])[0])[1];
                    $decodedFile = base64_decode($fileData[1]);

                    // Create a temporary file
                    $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.' . $fileExtension;
                    file_put_contents($tempFilePath, $decodedFile);

                    // Add file to media library
                    $data_produit->addMedia($tempFilePath)->toMediaCollection('galleryProduit');

                    // // Delete the temporary file
                    // unlink($tempFilePath);
                }
            }

            return response([
                'message' => 'operation reussi'
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
