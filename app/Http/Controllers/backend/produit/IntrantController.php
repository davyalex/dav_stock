<?php

namespace App\Http\Controllers\backend\produit;

use App\Models\Intrant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class IntrantController extends Controller
{
    public function index(Request $request)
    {
        $data_intrant = Intrant::orderBy('created_at', 'DESC')->get();
        return view('backend.pages.intrant.index', compact('data_intrant'));
    }

    public function create(Request $request)
    {
        return view('backend.pages.intrant.create');
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'stock_alerte' => 'required|integer|min:0',
                'prix' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

            // Vérifier si l'intrant existe déjà
            $existingIntrant = Intrant::where('nom', $request['nom'])->exists();
            if ($existingIntrant) {
            Alert::error('Erreur', 'Un intrant avec ce nom existe déjà.');
            return back()->withInput();
        }

            // Générer un code unique
            $sku = 'INT-' . strtoupper(Str::random(8));

            $data_intrant = Intrant::create([
                'nom' => $request['nom'],
                'code' => $sku,
                'description' => $request['description'],
                'stock_alerte' => $request['stock_alerte'],
                'prix' => $request['prix'] ?? 0,
                'statut' => 'active',
                'user_id' => Auth::id(),
            ]);

            if ($request->hasFile('image')) {
                $media = $data_intrant->addMediaFromRequest('image')->toMediaCollection('IntrantImage');
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
            }

            Alert::success('Opération réussie', 'Intrant créé avec succès');
            return redirect()->route('intrant.create');
        } catch (\Throwable $e) {
            return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $data_intrant = Intrant::find($id);
            return view('backend.pages.intrant.show', compact('data_intrant'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function edit($id)
    {
        try {
            $data_intrant = Intrant::find($id);
            return view('backend.pages.intrant.edit', compact('data_intrant'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'stock_alerte' => 'required|integer|min:0',
                'prix' => 'required|numeric|min:0',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            ]);

            $data_intrant = Intrant::find($id);
            $data_intrant->update([
                'nom' => $request['nom'],
                'description' => $request['description'],
                'stock_alerte' => $request['stock_alerte'],
                'prix' => $request['prix'],
                'statut' => $request['statut'],
                'user_id' => Auth::id(),
            ]);

            if ($request->hasFile('image')) {
                $data_intrant->clearMediaCollection('IntrantImage');
                $media = $data_intrant->addMediaFromRequest('image')->toMediaCollection('IntrantImage');
                \Spatie\ImageOptimizer\OptimizerChainFactory::create()->optimize($media->getPath());
            }

            Alert::success('Opération réussie', 'Intrant modifié avec succès');
            return redirect()->route('intrant.edit', $id);
        } catch (\Throwable $e) {
            return back()->with('error', 'Une erreur s\'est produite : ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        Intrant::find($id)->forceDelete();
        return response()->json([
            'status' => 200,
        ]);
    }
}
