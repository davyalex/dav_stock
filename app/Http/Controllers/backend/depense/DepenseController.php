<?php

namespace App\Http\Controllers\backend\depense;

use Carbon\Carbon;
use App\Models\Depense;
use Illuminate\Http\Request;
use App\Models\LibelleDepense;
use App\Models\CategorieDepense;
// use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;


class DepenseController extends Controller
{
    //
    //
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     //
    //     try {
    //         $query = Depense::OrderBy('created_at', 'DESC');
    //         $data_libelle_depense = LibelleDepense::OrderBy('created_at', 'ASC')->get();
    //         $categorie_depense = CategorieDepense::whereNotIn('slug', ['achats'])->get();

    //         $dateDebut = $request->input('date_debut');
    //         $dateFin = $request->input('date_fin');
    //         $categorie = $request->input('categorie');
    //         $periode = $request->input('periode');


    //         // Formatage des dates
    //         $dateDebut = $request->filled('date_debut') ? Carbon::parse($dateDebut)->format('Y-m-d') : null;
    //         $dateFin = $request->filled('date_fin') ? Carbon::parse($dateFin)->format('Y-m-d') : null;

    //         // Application des filtres de date
    //         if ($dateDebut && $dateFin) {
    //             $query->whereBetween('created_at', [$dateDebut, $dateFin]);
    //         } elseif ($dateDebut) {
    //             $query->where('created_at', '>=', $dateDebut);
    //         } elseif ($dateFin) {
    //             $query->where('created_at', '<=', $dateFin);
    //         }

    //         // Application du filtre de statut
    //         if ($request->filled('categorie')) {
    //             $query->where('categorie_depense_id', $categorie);
    //         }

    //          // Application du filtre de periode
    //         // periode=> jour, semaine, mois, année
    //         if ($request->filled('periode')) {
    //             $periode = $request->periode; // Ajout de cette ligne pour récupérer la période

    //             if ($periode == 'jour') {
    //                 $query->whereDate('created_at', Carbon::today());
    //             } elseif ($periode == 'semaine') {
    //                 $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    //             } elseif ($periode == 'mois') {
    //                 $query->whereMonth('created_at', Carbon::now()->month)
    //                       ->whereYear('created_at', Carbon::now()->year); // Ajout pour éviter d'avoir des résultats de plusieurs années
    //             } elseif ($periode == 'annee') {
    //                 $query->whereYear('created_at', Carbon::now()->year);
    //             }
    //         }

    //         $data_depense = $query->orderBy('created_at', 'desc')->get();

    //         // dd($categorie_depense->toArray());
    //         return view('backend.pages.depense.index', compact('data_depense', 'categorie_depense', 'data_libelle_depense'));
    //     } catch (\Throwable $th) {
    //         //throw $th;
    //         return $th->getMessage();
    //     }
    // }



    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $query = Depense::with(['categorie_depense', 'libelle_depense', 'user'])->orderBy('created_at', 'desc');
                $total = $query->sum('montant');

                if ($request->filled('date_debut')) {
                    $query->where('created_at', '>=', $request->date_debut);
                }

                if ($request->filled('date_fin')) {
                    $query->where('created_at', '<=', $request->date_fin);
                }

                if ($request->filled('categorie')) {
                    $query->where('categorie_depense_id', $request->categorie);
                }

                if ($request->filled('periode')) {
                    switch ($request->periode) {
                        case 'jour':
                            $query->whereDate('created_at', now());
                            break;
                        case 'semaine':
                            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                            break;
                        case 'mois':
                            $query->whereMonth('created_at', now()->month);
                            break;
                        case 'annee':
                            $query->whereYear('created_at', now()->year);
                            break;
                    }
                }

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('categorie', fn($row) => $row->categorie_depense->libelle ?? '')
                    ->addColumn('libelle', fn($row) => $row->libelle_depense->libelle ?? ($row->categorie_depense->libelle ?? ''))
                    ->addColumn('user', fn($row) => $row->user->first_name ?? '')
                    ->addColumn('date_depense', fn($row) => $row->date_depense ? \Carbon\Carbon::parse($row->date_depense)->format('d/m/Y') : '')
                    ->addColumn('actions', function ($row) {
                        return '
                            <div class="dropdown">
                                <button class="btn btn-soft-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="ri-more-fill align-middle"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                    <a href="#" class="dropdown-item edit-item-btn" data-bs-toggle="modal"
                                    data-bs-target="#editModal_' . $row->id . '">
                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i> Modifier
                                    </a>
                                    </li>
                                    <li><a class="dropdown-item delete" href="#" data-id="' . $row->id . '">Supprimer</a></li>
                                </ul>
                            </div>';
                    })
                    ->rawColumns(['actions'])
                    ->with(['total_montant' => $total])
                    ->make(true);
            }

            $data_libelle_depense = LibelleDepense::orderBy('created_at', 'ASC')->get();
            $categorie_depense = CategorieDepense::whereNotIn('slug', ['achats'])->get();

            return view('backend.pages.depense.index', compact('data_libelle_depense', 'categorie_depense'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    public function create()
    {
        try {
            // $data_depense = Depense::OrderBy('created_at', 'DESC')->get();
            $data_libelle_depense = LibelleDepense::OrderBy('created_at', 'ASC')->get();
            $categorie_depense = CategorieDepense::with('libelleDepenses')->whereNotIn('slug', ['achats'])->get();

            // dd($categorie_depense->toArray());
            return view('backend.pages.depense.create', compact('categorie_depense', 'data_libelle_depense'));
        } catch (\Throwable $th) {
            //throw $th;
            return $th->getMessage();
        }
    }


    public function store(Request $request)
    {
        try {
            // dd($request->all());

            $data_libelle = LibelleDepense::whereId($request->libelle)->first(); // LibelleDepense
            $data_categorie = CategorieDepense::whereId($request->categorie_depense)->first(); // CategorieDepense

            $libelle = '';
            $categorie = '';
            // dd($data_libelle->toArray());

            if ($data_libelle) {
                $libelle =  $data_libelle->id;
                $categorie =  $data_libelle->categorie_depense_id;
            } elseif ($data_categorie) {
                $categorie =  $data_categorie->id;
                $libelle = null;
            }

            $data = $request->validate([
                'libelle' => '',
                'categorie_depense' => 'required',
                'montant' => 'required',
                'description' => '',
                'date_depense' => 'required',
            ]);

            $data_count = Depense::count();

            $data_depense = Depense::firstOrCreate([
                'categorie_depense_id' => $categorie,
                'libelle_depense_id' => $libelle,
                'libelle' => $request->libelle,
                'montant' => $request->montant,
                'description' => $request->description,
                'date_depense' => $request->date_depense,
                'user_id' => Auth::id()
            ]);

            Alert::success('Operation réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        try {
            //request validation ......
            $data = $request->validate([
                'libelle' => '',
                'categorie_depense_id' => '',
                'montant' => 'required',
                'description' => '',
                'date_depense' => 'required',

            ]);


            // verifier si c'est une categorie ou libelle on reçoit
            $data_libelle = LibelleDepense::whereId($request->categorie)->first();
            $data_categorie = CategorieDepense::whereId($request->categorie)->first();

            $libelle = '';
            $categorie = '';

            if ($data_libelle) {
                $libelle =  $data_libelle->id;
                $categorie =  $data_libelle->categorie_depense_id;
            } elseif ($data_categorie) {
                $categorie =  $data_categorie->id;
                $libelle = null;
            }


            // $data_libelle = LibelleDepense::whereId($request->libelle)->first();
            // $data_categorie = CategorieDepense::whereId($request->categorie_depense)->first();

            // $libelle = '';
            // $categorie = '';
            // // dd($data_categorie->toArray());

            // if ($data_libelle) {
            //     $libelle =  $data_libelle->id;
            //     $categorie =  $data_libelle->categorie_depense_id;
            // } elseif ($data_categorie) {
            //     $categorie =  $data_categorie->id;
            //     $libelle = null;
            // }


            $data_depense = Depense::find($id)->update(
                [
                    'categorie_depense_id' => $categorie,
                    'libelle_depense_id' => $libelle,
                    'libelle' => $request->libelle,
                    'montant' => $request->montant,
                    'description' => $request->description,
                    'date_depense' => $request->date_depense,
                    'user_id' => Auth::id()
                ]
            );

            Alert::success('Opération réussi', 'Success Message');
            return back();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    public function delete($id)
    {

        try {
            Depense::find($id)->forceDelete();
            return response()->json([
                'status' => 200,
            ]);
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }
}
