<?php

namespace App\Http\Controllers\backend\produit;

use App\Models\Unite;
use App\Models\Format;
use App\Models\Magasin;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    //
    public function index()
    {
        $categorie = Categorie::whereIn('type', ['restaurant', 'bar'])->get();

        $data_produit = Produit::withWhereHas('typeProduit', fn($q) => $q->whereIn('type', ['restaurant', 'bar']))->get();
        // dd(  $data_produit->toArray());
        return view('backend.pages.produit.index', compact('data_produit'));
    }

    public function create(Request $request)
    {
        try {

            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('type', ['bar', 'restaurant'])
                ->OrderBy('position', 'ASC')->get();

            $categorieAll = Categorie::all();

            $data_unite = Unite::all();
            $data_magasin = Magasin::all();


            // dd($data_produit->toArray());

            return view('backend.pages.produit.create', compact('data_categorie', 'categorieAll', 'data_unite', 'data_magasin'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {

            //get principal category of categorie request
            $principaCat = Categorie::find($request['categorie']);
            $principaCat =  $principaCat->getPrincipalCategory();

            //request validation
            $request->validate([
                'nom' => 'required|unique:produits',
                'description' => '',
                'categorie' => 'required',
                'stock' => '',
                'stock_alerte' => 'required',
                'statut' => '',
                'magasin' => '',
                'quantite_unite' => $principaCat->name == 'bar' ? 'required' : '',
                'unite_mesure' => $principaCat->name == 'bar' ? 'required' : '',
                'imagePrincipale' => 'required',

            ]);



            $sku = 'PROD-' . strtoupper(Str::random(8));
            $data_produit = Produit::firstOrCreate([
                'nom' => $request['nom'],
                'code' =>  $sku,
                'description' => $request['description'],
                'categorie_id' => $request['categorie'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' =>   $principaCat['id'], // type produit
                'quantite_unite' => $request['quantite_unite'],
                'unite_id' => $request['unite_mesure'],
                'magasin_id' => $request['magasin'],
                'user_id' => Auth::id(),

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


    public function show($id)
    {
        try {
            $data_produit = Produit::find($id);
            return view('backend.pages.produit.show', compact('data_produit'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function edit($id)
    {
        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('type', ['bar', 'restaurant'])
                ->OrderBy('position', 'ASC')->get();

            $data_produit = Produit::find($id);

            $categorieAll = Categorie::all();

            $data_unite = Unite::all();
            $data_magasin = Magasin::all();


            //get Image from database
            $galleryProduit = [];

            foreach ($data_produit->getMedia('galleryProduit') as $value) {
                // Read the file content
                $fileContent = file_get_contents($value->getPath());

                // Encode the file content to base64
                $base64File = base64_encode($fileContent);
                array_push($galleryProduit, $base64File);
            }

            // dd($galleryProduit);

            $id = $id;
            return view('backend.pages.produit.edit', compact('data_produit', 'data_categorie', 'categorieAll', 'data_unite', 'data_magasin', 'galleryProduit', 'id'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {

            //get principal category of categorie request
            $principaCat = Categorie::find($request['categorie']);
            $principaCat =  $principaCat->getPrincipalCategory();

            //request validation
            $request->validate([
                'nom' => 'required',
                'description' => '',
                'categorie' => 'required',
                'stock' => '',
                'stock_alerte' => 'required',
                'magasin' => '',
                'quantite_unite' => $principaCat->name == 'bar' ? 'required' : '',
                'unite_mesure' => $principaCat->name == 'bar' ? 'required' : '',
                'imagePrincipale' => '',
            ]);



            $data_produit = tap(Produit::find($id))->update([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'categorie_id' => $request['categorie'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' =>   $principaCat['id'], // type produit

                'quantite_unite' => $request['quantite_unite'],
                'unite_id' => $request['unite_mesure'],
                'magasin_id' => $request['magasin'],
                'user_id' => Auth::id(),
            ]);


            if (request()->hasFile('imagePrincipale')) {
                $data_produit->clearMediaCollection('ProduitImage');
                $data_produit->addMediaFromRequest('imagePrincipale')->toMediaCollection('ProduitImage');
            }


            if ($request->images) {
                $data_produit->clearMediaCollection('galleryProduit');

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


    public function delete($id)
    {
        Produit::find($id)->forceDelete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
