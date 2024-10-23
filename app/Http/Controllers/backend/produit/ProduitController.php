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
use Illuminate\Support\Facades\Validator;

class ProduitController extends Controller
{
    //
    public function index()
    {
        $categorie = Categorie::whereIn('type', ['restaurant', 'bar'])->get();

        $data_produit = Produit::withWhereHas('typeProduit', fn($q) => $q->whereIn('type', ['restaurant', 'bar']))->orderBy('created_at', 'DESC')->get();
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
            $data_format = Format::all();
            $data_magasin = Magasin::all();


            // dd($data_produit->toArray());

            return view('backend.pages.produit.create', compact('data_categorie', 'categorieAll', 'data_unite', 'data_magasin', 'data_format'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            // Récupérer la catégorie principale de la catégorie demandée
            $categorie = Categorie::find($request['categorie_id']);
            $principaCat = $categorie->getPrincipalCategory();
        
            // Validation des données de la requête
            $validator = Validator::make($request->all(), [
                'nom' => 'required',
                'description' => '',
                'categorie_id' => 'required',
                'stock' => '',
                'stock_alerte' => 'required',
                'statut' => '',
                'prix' => $categorie->famille == 'bar' ? 'required' : '',
                'valeur_unite' => '',
                'unite_id' => '',
                'unite_sortie_id' => 'required',
                'imagePrincipale' => $categorie->famille == 'bar' ? 'required' : '',
            ]);
        
            // Vérifier si la validation échoue
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity
            }
        
            // Vérifier si le produit existe déjà
            $existingProduct = Produit::where('nom', $request['nom'])
                ->where('valeur_unite', $request['valeur_unite'])
                ->where('unite_id', $request['unite_id'])
                ->exists();
        
            if ($existingProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ce produit existe déjà',
                ], 409); // 409 Conflict
            }
        
            // Générer un SKU unique
            $sku = 'PROD-' . strtoupper(Str::random(8));
        
            // Créer le produit
            $data_produit = Produit::create([
                'nom' => $request['nom'],
                'code' => $sku,
                'description' => $request['description'],
                'categorie_id' => $request['categorie_id'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' => $principaCat['id'], // Type produit
                'prix' => $request['prix'],
                'valeur_unite' => $request['valeur_unite'],
                'unite_id' => $request['unite_id'],
                'unite_sortie_id' => $request['unite_sortie_id'],
                'statut' => 'active',
                'user_id' => Auth::id(),
            ]);
        
            // Si une image principale est présente, l'ajouter
            if ($request->hasFile('imagePrincipale')) {
                $media = $data_produit->addMediaFromRequest('imagePrincipale')->toMediaCollection('ProduitImage');
                // Optimiser l'image après l'ajout
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
            }
        
            // Ajouter d'autres images si elles sont présentes
            if ($request->images) {
                foreach ($request->input('images') as $fileData) {
                    // Décoder l'image base64
                    $fileData = explode(',', $fileData);
                    $fileExtension = explode('/', explode(';', $fileData[0])[0])[1];
                    $decodedFile = base64_decode($fileData[1]);
        
                    // Créer un fichier temporaire
                    $tempFilePath = sys_get_temp_dir() . '/' . uniqid() . '.' . $fileExtension;
                    file_put_contents($tempFilePath, $decodedFile);
        
                    // Ajouter l'image à la collection de médias
                    $media = $data_produit->addMedia($tempFilePath)->toMediaCollection('galleryProduit');
        
                    // Optimiser l'image après l'ajout
                    \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
                }
            }
        
            // Réponse en cas de succès
            return response()->json([
                'success' => true,
                'message' => 'Produit créé avec succès',
                'product' => $data_produit
            ], 201);
        } catch (\Throwable $e) {
            // En cas d'exception, retourner un message d'erreur
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500); // 500 Internal Server Error
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
            $data_format = Format::all();
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
            return view('backend.pages.produit.edit', compact('data_produit', 'data_categorie', 'categorieAll', 'data_unite', 'data_magasin', 'galleryProduit', 'id', 'data_format'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {

            //get principal category of categorie request
            $categorie = Categorie::find($request['categorie_id']);
            $principaCat =  $categorie->getPrincipalCategory();

            //request validation
            $request->validate([
                'nom' => 'required',
                'description' => '',
                'categorie_id' => 'required',
                'stock' => '',
                'stock_alerte' => 'required',
                'prix' => $categorie->famille == 'bar' ? 'required' : '',

                // 'magasin' => '',

                'valeur_unite' => '',
                'unite_id' => '',
                // 'format_id' => '',
                // 'valeur_format' => '',
                'unite_sortie_id' => 'required',
                'imagePrincipale' => $categorie->famille == 'bar' ? 'required' : '',
            ]);

            // active  :  desactive le produit
            $statut = '';
            if ($request['statut'] == 'on') {
                $statut = 'active';
            } else {
                $statut = 'desactive';
            }


            $data_produit = tap(Produit::find($id))->update([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'categorie_id' => $request['categorie_id'],
                'stock_alerte' => $request['stock_alerte'],
                'type_id' =>   $principaCat['id'], // type produit
                'prix' => $request['prix'],
                'valeur_unite' => $request['valeur_unite'],
                'unite_id' => $request['unite_id'],
                // 'format_id' => $request['format_id'],
                // 'valeur_format' => $request['valeur_format'],
                'unite_sortie_id' => $request['unite_sortie_id'],
                'statut' => $statut,
                'user_id' => Auth::id(),
            ]);


            if (request()->hasFile('imagePrincipale')) {
                $data_produit->clearMediaCollection('ProduitImage');
                $media = $data_produit->addMediaFromRequest('imagePrincipale')->toMediaCollection('ProduitImage');
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
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
                    // Add file to media library
                    $media = $data_produit->addMedia($tempFilePath)->toMediaCollection('galleryProduit');

                    // Optimiser l'image après l'ajout
                    \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
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
