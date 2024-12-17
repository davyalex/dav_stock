<?php

namespace App\Http\Controllers\site;

use Carbon\Carbon;
use App\Models\Menu;
use App\Models\Slide;
use App\Models\Produit;
use App\Mail\ContactMail;
use App\Models\Categorie;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SiteController extends Controller
{
    /**Accueil du site */

    public function accueil()
    {
        try {
            //slider
            $data_slide = Slide::with('media')->orderBy('id', 'DESC')->get();

            // Récupérer les produits de type bar
            $produitsBar = Produit::active()->whereHas('categorie', function ($query) {
                $query->where('famille', 'bar');
            })
                // ->whereHas('achats', function($query) {
                //     $query->where('statut', 'active');
                // })
                ->take(10)
                ->get();

            // Récupérer les produits de type menu
            $produitsMenu = Produit::active()->whereHas('categorie', function ($query) {
                $query->where('famille', 'menu');
            })

                ->take(10)
                ->get();

            // dd($produitsMenu->toArray());

            // Combiner les produits bar et menu
            $produits = $produitsMenu->concat($produitsBar);
            // dd($produits->toArray());

            // Récupérer les produits les plus commandés
            $produitsLesPlusCommandes = Produit::active()->whereHas('categorie', function ($query) {
                $query->whereIn('famille', ['bar', 'menu']);
            })
                // ->withCount('commandes')
                ->withCount('ventes')
                // ->havingRaw('commandes_count > 1')
                ->havingRaw('ventes_count > 1')
                ->orderBy('ventes_count', 'desc')
                ->get();

            // dd($produitsLesPlusCommandes->toArray());
            $categorieSelect = Categorie::first(); // recuperer les infos de la categorie a partir du slug

            return view('site.pages.accueil', compact(
                'data_slide',
                'produitsBar',
                'produitsMenu',
                'produits',
                'produitsLesPlusCommandes',
                'categorieSelect'
            ));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function nousContacter()
    {
        try {
            return view('site.pages.contact');
        } catch (\Throwable $th) {
            $th->getMessage();
        }
    }


    public function sendMailContacter(Request $request)
    {
        try {
            $request->validate([
                'nom' => 'required|string',
                'email' => 'required|email',
                'message' => 'required|string',
                'objet' => 'required|string',
            ]);

            // Récupérer les données du formulaire
            $data = [
                'nom' => $request->input('nom'),
                'email' => $request->input('email'),
                'message' => $request->input('message'),
                'objet' => $request->input('objet'),
            ];

            // Envoi de l'email avec les données et la vue
            // Mail::send('contact_mail', $data, function ($message) use ($data) {
            //     $message->to('info@chezjeanne.ci') // Destinataire
            //         ->subject($data['objet'])    // Objet de l'email
            //         ->from($data['email'], $data['nom']); // Expéditeur
            // });

            // // Envoi de l'email en utilisant du contenu HTML
            // Mail::html(
            //     "<h1>Message de Contact</h1>
            // <p><strong>Nom :</strong> {$data['nom']}</p>
            // <p><strong>Email :</strong> {$data['email']}</p>
            // <p><strong>Message :</strong><br>{$data['message']}</p>",
            //     function ($message) use ($data) {
            //         $message->to('info@chezjeanne.ci') // Destinataire
            //             ->subject($data['objet'])        // Objet de l'email
            //             ->from($data['email'], $data['nom']); // Expéditeur
            //     }
            // );


            Mail::to('info@chezjeanne.ci')->queue(new ContactMail($data));
            Alert::success('Votre message a bien été envoyé');
            return back();

            // Rediriger avec un message de succès
            
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }


    /**Liste des produit en fonction de la categorie
     * 
     * @param{id-categorie}
     */
    public function produit(Request $request, $id)
    {
        try {
            $categorieSelect = Categorie::whereId($id)->first(); // recuperer les infos de la categorie a partir du slug

            if (!$categorieSelect) {
                return redirect()->route('accueil');
            }
            if ($categorieSelect->type) {
                $produits = Produit::active()->where('type_id', $categorieSelect->id)
                    ->paginate(9);
            } else {
                $produits = Produit::active()->where('categorie_id', $categorieSelect->id)
                    ->paginate(9);
            }
            // // retourner les achats du produits si type=bar
            // if ($categorieSelect->type == 'bar') {
            //     $produits = Produit::where('type_id', $categorieSelect->id)
            //         ->withWhereHas('achats', fn($q) => $q->whereStatut('active'))
            //         ->whereStatut('active')
            //         ->paginate(10);
            // } elseif ($categorieSelect->type == 'menu') {
            //     $produits = Produit::where('type_id', $categorieSelect->id)
            //         ->whereStatut('active')
            //         ->paginate(10);
            // } elseif ($categorieSelect->famille == 'bar') {
            //     $produits = Produit::where('categorie_id', $categorieSelect->id)
            //         ->withWhereHas('achats', fn($q) => $q->whereStatut('active'))
            //         ->whereStatut('active')
            //         ->paginate(10);
            // } elseif ($categorieSelect->famille == 'menu') {
            //     $produits = Produit::where('categorie_id', $categorieSelect->id)
            //         // ->withWhereHas('achats', fn($q) => $q->whereStatut('active'))
            //         ->whereStatut('active')
            //         ->paginate(10);
            // }

            // dd($produits->toArray());
            // $produits  =   $produits->achats;

            // $categorie = Categorie::with(['children' , 'parent'])
            //     ->withCount('children')->where('parent_id', $categorieSelect->id)->OrderBy('position', 'ASC')->get();  // categorie et ses souscategorie 

            $categories = Categorie::whereNull('parent_id')
                ->with('children')
                ->whereIn('type', ['menu', 'bar'])
                ->orderBy('position', 'DESC')
                ->get();
            // dd($categorieSelect->id);

            return view('site.pages.produit', compact(
                'produits',
                'categories',
                'categorieSelect',
            ));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


    // public function menu(Request $request)
    // {
    //     try {
    //         $today = Carbon::today();

    //         // Récupérer le menu du jour avec les relations nécessaires
    //         $menu = Menu::with([
    //             'produits.achats',
    //             'produits.categorie' => function ($query) {
    //                 $query->with(['parent', 'children', 'descendants']); // Charger les sous-catégories
    //             }
    //         ])->where('date_menu', $today)->first();

    //         if ($menu) {
    //             // Récupérer toutes les catégories associées aux produits du menu
    //             $categories = $this->getCategoriesFromMenu($today);

    //             // Si une catégorie est passée dans la requête
    //             if ($request->has('categorie')) {
    //                 $categorieRequest = Categorie::where('slug', $request->categorie)->first();

    //                 if ($categorieRequest) {
    //                     // Filtrer les produits appartenant à la catégorie demandée ou ses descendants
    //                     $produitsFiltres = $menu->produits->filter(function ($produit) use ($categorieRequest) {
    //                         return $produit->categorie->id === $categorieRequest->id ||
    //                             $produit->categorie->parent_id === $categorieRequest->id ||
    //                             $produit->categorie->descendants->contains('id', $categorieRequest->id);
    //                     });

    //                     // Regrouper les produits filtrés par la catégorie principale
    //                     $produitsFiltres = $produitsFiltres->groupBy(function ($produit) {
    //                         return $produit->categorie->getPrincipalCategory()->type;
    //                     });

    //                     return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories', 'categorieRequest'));
    //                 }
    //             } else {
    //                 // Si aucune catégorie spécifique n'est demandée, on regroupe par catégorie principale
    //                 $produitsFiltres = $menu->produits->groupBy(function ($produit) {
    //                     return $produit->categorie->getPrincipalCategory()->type;
    //                 });

    //                 return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories'));
    //             }
    //         } else {
    //             // Si aucun menu n'est trouvé pour aujourd'hui
    //             $produitsFiltres = collect();
    //             $categories = [];


    //             return view('site.pages.menu', compact('menu', 'produitsFiltres', 'categories'));
    //         }
    //     } catch (\Throwable $e) {
    //         return $e->getMessage();
    //     }
    // }

    public function menu(Request $request)
    {
        try {
            // $today = Carbon::today();
            // recuperer le menu du jour
            // $menu = Menu::where('date_menu', Carbon::today()->toDateString())
            //     ->with([
            //         'produits' => function ($query) {
            //             $query->with('categorieMenu', 'complements');
            //         },
            //     ])->first();

            // recuperer le menu du jour en session
            $cartMenu = Session::get('cartMenu');


            // Récupérer le menu du jour avec les produits, compléments et garnitures
            $menu = Menu::where('date_menu', Carbon::today()->toDateString())
                ->with([
                    'plats' => function ($query) {
                        $query->with([
                            'categorieMenu',  // Relation vers la catégorie de produit
                            'complements' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            },
                            'garnitures' => function ($query) {
                                $query->wherePivot('menu_id', function ($subQuery) {
                                    $subQuery->select('id')
                                        ->from('menus')
                                        ->where('date_menu', Carbon::today()->toDateString());
                                });
                            }
                        ]);
                    },
                ])->first();

            // Vérifier s'il y a un menu
            if (!$menu) {
                return view('site.pages.menu', ['menu' => null, 'categories' => []]);
            }

            // Grouper les produits par nom de catégorie et trier par position de catégorie
            $categories = $menu->plats
                ->groupBy(function ($plat) {
                    return $plat->categorieMenu->nom; // Grouper par le nom de la catégorie
                })
                ->sortBy(function ($group, $key) {
                    // Trier les groupes par la position des catégories
                    $categorie = $group->first()->categorieMenu;
                    return $categorie ? $categorie->position : 0; // Si une catégorie n'a pas de position, utiliser 0
                });



            // dd($cartMenu);

            return view('site.pages.menu', compact('categories', 'menu', 'cartMenu'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }




    public function getCategoriesFromMenu($today)
    {
        // Charger le menu avec les produits et les catégories
        $menu = Menu::with([
            'produits.categorie' => function ($query) {
                $query->with(['parent', 'children' => function ($q) {
                    $q->with('children'); // Charger les sous-catégories récursivement
                }]);
            }
        ])->where('date_menu', $today)->first();

        if (!$menu) {
            return collect(); // Retourner une collection vide si le menu n'existe pas
        }

        // Récupérer toutes les catégories des produits du menu
        $categories = collect();
        foreach ($menu->produits as $produit) {
            $categorie = $produit->categorie;
            if ($categorie) {
                $categories = $categories->merge($categorie->descendants->push($categorie));
            }
        }

        // Grouper les catégories par leur catégorie principale
        $groupedCategories = $categories->groupBy(function ($categorie) {
            return $categorie->getPrincipalCategory()->id; // Grouper par catégorie principale
        })->map(function ($categorieGroup) {
            return $categorieGroup->unique('id');
        });

        return $groupedCategories;
    }



    public function produitDetail($slug)
    {

        try {
            $produit = Produit::where('slug', $slug)->first();
            $produit = Produit::find($produit->id);
            // dd($produit->categorie->toArray());

            $categories = Categorie::whereNull('parent_id')
                ->with('children')
                ->whereIn('type', ['menu', 'bar'])
                ->orderBy('position', 'DESC')
                ->get();

            $categorieSelect = Categorie::whereId($produit->categorie_id)->first(); // recuperer les infos de la categorie a partir du slug


            $produitsRelateds = Produit::where('categorie_id', $produit->categorie_id)->where('id', '!=', $produit->id)->get();
            // dd($produitsRelateds->toArray());

            return view('site.pages.produit-detail', compact('produit', 'produitsRelateds', 'categories', 'categorieSelect'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    //systeme de recherche
    public function recherche(Request $request)
    {

        try {
            $query = $request->input('query'); // Récupère la requête de recherche
            $produits = Produit::active()->where('nom', 'LIKE', "%$query%")
                ->orWhere('description', 'LIKE', "%$query%")
                ->get();

            // $categorieSelect = Categorie::first(); // recuperer les infos de la categorie a partir du slug

            return view('site.pages.produit-search', compact('produits', 'query'));
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }



    // Controller












    // public function
}
