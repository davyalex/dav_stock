<?php

namespace App\Http\Controllers\backend\produit;

use App\Models\Unite;
use App\Models\Format;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProduitController extends Controller
{
    //
    public function index() {}

    public function create(Request $request)
    {
        try {

            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('name', ['bar', 'restaurant'])
                ->OrderBy('position', 'ASC')->get();

            // dd($data_produit->toArray());

            return view('backend.pages.produit.create', compact('data_categorie'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            //request validation
            $request->validate([
                'nom' => 'required|unique:produits',
                'description' => '',
                'categorie' => 'required',
                'stock' => '',
                'visible' => '',
            ]);

            //get principal category of categorie request
            $principaCat = Categorie::find($request['categorie']);
            $principaCat =  $principaCat->getPrincipalCategory();

            $sku = 'PROD-' . strtoupper(Str::random(8));
            $data_produit = Produit::firstOrCreate([
                'nom' => $request['nom'],
                'code' =>  $sku,
                'description' => $request['description'],
                'categorie_id' => $request['categorie'],
                'type_id' =>   $principaCat['id'],
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
