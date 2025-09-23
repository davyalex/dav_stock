<?php

namespace App\Http\Controllers\backend\configuration;

use Carbon\Carbon;
use App\Models\ModePaiement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ModePaiementController extends Controller
{
    public function index()
    {
        $data_mode_paiement = ModePaiement::orderBy('libelle')->get();
        return view('backend.pages.configuration.mode_paiement.index', compact('data_mode_paiement'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $data = $request->validate([
                'libelle' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
            ]);

            ModePaiement::firstOrCreate([
                'libelle' => $data['libelle'],

            ], [
                'code' => 'MP-' . strtoupper(Str::random(5)),
                'description' => $data['description'] ?? null,
                'statut' => 'active',
            ]);

            Alert::success('Opération réussie', 'Mode de paiement ajouté');
            return back();
        } catch (\Throwable $e) {
            Alert::error('Erreur', 'Une erreur est survenue : ' . $e->getMessage());
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'libelle' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'statut' => 'required|in:active,desactive',
            ]);

            ModePaiement::findOrFail($id)->update($data);

            Alert::success('Opération réussie', 'Mode de paiement modifié');
            return back();
        } catch (\Throwable $e) {
            Alert::error('Erreur', 'Une erreur est survenue : ' . $e->getMessage());
            return back();
        }
    }

    public function delete($id)
    {
        try {
            ModePaiement::findOrFail($id)->delete();
            return response()->json(['status' => 200]);
        } catch (\Throwable $e) {
            return response()->json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
