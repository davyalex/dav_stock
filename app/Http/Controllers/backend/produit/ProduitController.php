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
    public function index()
    {
        $data_produit = Produit::all();
        // dd(  $data_produit->toArray());
        return view('backend.pages.produit.index', compact('data_produit'));
    }

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
                'stock_alerte' => '',
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
                'stock_alerte' => $request['stock_alerte'],
                'type_id' =>   $principaCat['id'], // type produit
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


    public function edit($id)
    {
        try {
            $data_categorie = Categorie::whereNull('parent_id')->with('children', fn($q) => $q->OrderBy('position', 'ASC'))->withCount('children')
                ->whereIn('name', ['bar', 'restaurant'])
                ->OrderBy('position', 'ASC')->get();

            $data_produit = Produit::find($id);

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
            return view('backend.pages.produit.edit', compact('data_produit', 'data_categorie', 'galleryProduit', 'id'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {


            //request validation
            $request->validate([
                'nom' => 'required',
                'description' => '',
                'categorie' => 'required',
                'stock' => '',
                'stock_alerte' => '',
                'visible' => '',
            ]);

            //get principal category of categorie request
            $principaCat = Categorie::find($request['categorie']);
            $principaCat =  $principaCat->getPrincipalCategory();

            $data_produit = tap(Produit::find($id))->update([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'categorie_id' => $request['categorie'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' =>   $principaCat['id'], // type produit
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
        Produit::find($id)->delete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
