<?php

use App\Models\Optimize;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\user\AdminController;
use App\Http\Controllers\backend\user\ClientController;
use App\Http\Controllers\backend\vente\VenteController;
use App\Http\Controllers\backend\stock\EntreeController;
use App\Http\Controllers\backend\stock\SortieController;
use App\Http\Controllers\backend\module\ModuleController;
use App\Http\Controllers\backend\depense\DepenseController;
use App\Http\Controllers\backend\permission\RoleController;
use App\Http\Controllers\backend\produit\ProduitController;
use App\Http\Controllers\backend\rapport\RapportController;
use App\Http\Controllers\backend\stock\EtatStockController;
use App\Http\Controllers\backend\stock\InventaireController;
use App\Http\Controllers\backend\parametre\SettingController;
use App\Http\Controllers\backend\categorie\CategorieController;
use App\Http\Controllers\backend\configuration\CaisseController;
use App\Http\Controllers\backend\configuration\MagasinController;
use App\Http\Controllers\backend\permission\PermissionController;
use App\Http\Controllers\backend\depense\LibelleDepenseController;
use App\Http\Controllers\backend\depense\CategorieDepenseController;
use App\Http\Controllers\backend\configuration\ModePaiementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::fallback(function () {
    return view('backend.utility.auth-404-basic');
});

Auth::routes();
//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

// Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

// //Update User Details
// Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
// Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->name('index');


######################      START BACKEND ROUTE         ###########################################################

//login  for dashboard
Route::controller(AdminController::class)->prefix('admin')->group(function () {
    route::get('/login', 'login')->name('admin.login');
    route::post('/login', 'login')->name('admin.login');
    route::post('/logout', 'logout')->name('admin.logout');
});



Route::prefix('admin')->middleware(['admin'])->group(function () {

    //Dashboard
    Route::controller(DashboardController::class)->group(function () {
        route::get('', 'index')->name('dashboard.index'); // dashboard
    });

    //register client
    Route::prefix('client')->controller(ClientController::class)->group(function () {
        route::get('', 'index')->name('client.index'); // liste des client
        route::post('store', 'store')->name('client.store'); // ajouter client
        route::post('update/{id}', 'update')->name('client.update'); // modifier client
        route::get('delete/{id}', 'delete')->name('client.delete'); // supprimer client
        route::get('profil/{id}', 'profil')->name('client.profil');
        route::post('change-password', 'changePassword')->name('client.new-password');
    });


    //register admin
    Route::prefix('register')->controller(AdminController::class)->group(function () {
        route::get('', 'index')->name('admin-register.index');
        route::post('store', 'store')->name('admin-register.store');
        route::post('update/{id}', 'update')->name('admin-register.update');
        route::get('delete/{id}', 'delete')->name('admin-register.delete');
        route::get('profil/{id}', 'profil')->name('admin-register.profil');
        route::post('change-password', 'changePassword')->name('admin-register.new-password');
    });

    //role
    Route::prefix('role')->controller(RoleController::class)->group(function () {
        route::get('', 'index')->name('role.index');
        route::post('store', 'store')->name('role.store');
        route::post('update/{id}', 'update')->name('role.update');
        route::get('delete/{id}', 'delete')->name('role.delete');
    });

    //role
    Route::prefix('permission')->controller(PermissionController::class)->group(function () {
        route::get('', 'index')->name('permission.index');
        route::get('create', 'create')->name('permission.create');
        route::post('store', 'store')->name('permission.store');
        route::get('edit{id}', 'edit')->name('permission.edit');
        route::put('update/{id}', 'update')->name('permission.update');
        route::get('delete/{id}', 'delete')->name('permission.delete');
    });

    //module
    Route::prefix('module')->controller(ModuleController::class)->group(function () {
        route::get('', 'index')->name('module.index');
        route::post('store', 'store')->name('module.store');
        route::post('update/{id}', 'update')->name('module.update');
        route::get('delete/{id}', 'delete')->name('module.delete');
    });




    //Setting
    Route::prefix('setting')->controller(SettingController::class)->group(function () {
        route::get('', 'index')->name('setting.index');
        route::post('store', 'store')->name('setting.store');

        // download backua db
        Route::get('download-backup/{file}', 'downloadBackup')->name('setting.download-backup');
    });


  





    #############  SETTING  #####################
    //optimize clear : cache:clear  , route:cache , config:cache , 'view:clear' , optimize:clear
    Route::get('/cache-clear', function () {
        Artisan::call('optimize:clear');
        Optimize::create([
            'type_clear' => 'cache',
        ]);
        return response()->json(['message' => 'cache clear', 'status' => 200], 200);
    })->name('setting.cache-clear');

    //maintenance mode up
    Route::get(
        '/disable-maintenance-mode',
        function () {
            Artisan::call('up');
            Maintenance::create([
                'type' => 'up',
            ]);
            return response()->json(['message' => 'mode maintenance desactivé', 'status' => 200], 200);
        }
    )->name('setting.maintenance-up');

    //maintenance mode down
    Route::get(
        '/enable-maintenance-mode',
        function () {
            Artisan::call('down', [
                '--secret' => 'admin@',
                '--render' => 'backend.pages.maintenance-mode-view',
            ]);
            Maintenance::create([
                'type' => 'down',
            ]);
            return response()->json(['message' => 'mode maintenance activé', 'status' => 200], 200);
        }
    )->name('setting.maintenance-down');

    //rapport
    Route::prefix('rapport')->controller(RapportController::class)->group(function () {
        route::get('categorie', 'categorie')->name('rapport.categorie');
        route::get('produit', 'produits')->name('rapport.produit');
        route::get('vente', 'vente')->name('rapport.vente');
        route::get('exploitation', 'exploitation')->name('rapport.exploitation');
        route::get('detail', 'detail')->name('rapport.detail');  //detail exploitation en fonction de la categorie depense
        route::get('historique', 'historique')->name('rapport.historique'); // historique, vente, achats inventaire pour chaque produit


        route::get('caisse', 'caisses')->name('rapport.caisse');
        route::get('commande', 'commandes')->name('rapport.commande');
        route::get('depense', 'depenses')->name('rapport.depense');
    });


    //magasin
    Route::prefix('magasin')->controller(MagasinController::class)->group(function () {
        route::get('', 'index')->name('magasin.index');
        route::post('store', 'store')->name('magasin.store');
        route::post('update/{id}', 'update')->name('magasin.update');
        route::get('delete/{id}', 'delete')->name('magasin.delete');
    });


    //caisse
    Route::prefix('caisse')->controller(CaisseController::class)->group(function () {
        route::get('', 'index')->name('caisse.index');
        route::post('store', 'store')->name('caisse.store');
        route::post('update/{id}', 'update')->name('caisse.update');
        route::get('select', 'selectCaisse')->name('caisse.select')->middleware('role:caisse|supercaisse');
        route::post('select', 'selectCaisse')->name('caisse.select.post')->middleware('role:caisse|supercaisse');
        route::post('session-date-vente', 'sessionDate')->name('vente.session-date')->middleware('role:caisse|supercaisse');  // definir manuellement une session date pour la vente


        // route::get('delete/{id}', 'delete')->name('caisse.delete');
    });

    //mode paiement
    Route::prefix('mode-paiement')->controller(ModePaiementController::class)->group(function () {
        route::get('', 'index')->name('mode_paiement.index');
        route::post('store', 'store')->name('mode_paiement.store');
        route::post('update/{id}', 'update')->name('mode_paiement.update');
        route::get('delete/{id}', 'delete')->name('mode_paiement.delete');
    });

    //categorie
    Route::prefix('categorie')->controller(CategorieController::class)->group(function () {
        route::get('create', 'create')->name('categorie.create');
        route::post('store', 'store')->name('categorie.store');
        route::get('add-subCat/{id}', 'addSubCat')->name('categorie.add-subCat'); // add subCategorie
        route::post('add-subCat-store', 'addSubCatStore')->name('categorie.add-subCat-store'); // add subCategorie
        route::get('edit/{id}', 'edit')->name('categorie.edit');
        route::post('update/{id}', 'update')->name('categorie.update');
        route::get('delete/{id}', 'delete')->name('categorie.delete');
        
        // Nouvelles routes pour les fonctionnalités avancées
        route::post('reorder', 'reorder')->name('categorie.reorder'); // Drag & drop
        route::post('quick-update/{id}', 'quickUpdate')->name('categorie.quick-update'); // Édition rapide
    });


  


    // produit
    Route::prefix('produit')->controller(ProduitController::class)->group(function () {
        route::get('', 'index')->name('produit.index')->middleware('can:voir-produit'); // liste des produit
        route::get('create', 'create')->name('produit.create')->middleware('can:creer-produit'); // vue de la page de creation produit
        route::post('store', 'store')->name('produit.store')->middleware('can:creer-produit'); // ajouter produit
        route::get('show/{id}', 'show')->name('produit.show')->middleware('can:voir-produit'); // detail produit
        route::get('edit/{id}', 'edit')->name('produit.edit')->middleware('can:modifier-produit');
        route::put('update/{id}', 'update')->name('produit.update')->middleware('can:modifier-produit');
        route::get('delete/{id}', 'delete')->name('produit.delete')->middleware('can:supprimer-produit'); // supprimer produit
    });

    //etat stock
    Route::prefix('etat-stock')->controller(EtatStockController::class)->group(function () {
        route::get('', 'index')->name('etat-stock.index');
        route::get('suivi-stock', 'suiviStock')->name('etat-stock.suiviStock');
    });




    // stock -sortie
    Route::prefix('sortie')->controller(SortieController::class)->group(function () {
        route::get('', 'index')->name('sortie.index');
        route::get('show/{id}', 'show')->name('sortie.show');
        route::get('create', 'create')->name('sortie.create');
        route::post('store', 'store')->name('sortie.store');
        route::get('delete/{id}', 'delete')->name('sortie.delete');

    });

        // stock -entree
        Route::prefix('entree')->controller(EntreeController::class)->group(function () {
            route::get('', 'index')->name('entree.index');
            route::get('show/{id}', 'show')->name('entree.show');
            route::get('create', 'create')->name('entree.create');
            route::post('store', 'store')->name('entree.store');
            route::get('delete/{id}', 'delete')->name('entree.delete');
        });


    // stock -inventaire
    Route::prefix('inventaire')->controller(InventaireController::class)->group(function () {
        route::get('', 'index')->name('inventaire.index');
        route::get('show/{id}', 'show')->name('inventaire.show');
        route::get('create', 'create')->name('inventaire.create');
        route::post('store', 'store')->name('inventaire.store');
        route::get('fiche-inventaire', 'ficheInventaire')->name('inventaire.fiche-inventaire');
        route::get('delete/{id}', 'delete')->name('inventaire.delete');
    });


    // vente
    Route::prefix('vente')->controller(VenteController::class)->group(function () {
        route::get('', 'index')->name('vente.index')->middleware('can:voir-vente');
        route::get('show/{id}', 'show')->name('vente.show')->middleware('can:voir-vente'); // detail vente
        route::get('create', 'create')->name('vente.create')->middleware('can:creer-vente'); // vue de la page de creation vente
        route::post('store', 'store')->name('vente.store')->middleware('can:creer-vente'); // ajouter vente
        route::get('fermer-caisse', 'fermerCaisse')->name('vente.fermer-caisse')->middleware('can:voir-vente'); // cloture caisse
        route::get('rapport', 'rapportVente')->name('vente.rapport-caisse')->middleware('can:voir-vente'); // rapport de vente caisse

     
        ##supprimer une vente
        route::get('delete/{id}', 'delete')->name('vente.delete')->middleware('can:supprimer-vente'); // supprimer vente
    });

    Route::prefix('categorie-depense')->controller(CategorieDepenseController::class)->group(function () {
        route::get('', 'index')->name('categorie-depense.index');
        route::get('create', 'create')->name('categorie-depense.create');
        route::post('store', 'store')->name('categorie-depense.store');
        route::get('edit/{id}', 'edit')->name('categorie-depense.edit');
        route::post('update/{id}', 'update')->name('categorie-depense.update');
        route::get('delete/{id}', 'delete')->name('categorie-depense.delete');
        route::post('position/{id}', 'position')->name('categorie-depense.position');
    });


    Route::prefix('libelle-depense')->controller(LibelleDepenseController::class)->group(function () {
        route::get('', 'index')->name('libelle-depense.index');
        route::get('create', 'create')->name('libelle-depense.create');
        route::post('store', 'store')->name('libelle-depense.store');
        route::get('edit/{id}', 'edit')->name('libelle-depense.edit');
        route::post('update/{id}', 'update')->name('libelle-depense.update');
        route::get('delete/{id}', 'delete')->name('libelle-depense.delete');
        route::post('position/{id}', 'position')->name('libelle-depense.position');
    });

    Route::prefix('depense')->controller(DepenseController::class)->group(function () {
        route::get('', 'index')->name('depense.index');
        route::get('getList', 'getList')->name('depense.getList');
        route::get('create', 'create')->name('depense.create');
        route::post('store', 'store')->name('depense.store');
        route::get('edit/{id}', 'edit')->name('depense.edit');
        route::post('update/{id}', 'update')->name('depense.update');
        route::get('delete/{id}', 'delete')->name('depense.delete');
    });











});

######################      END BACKEND ROUTE         ###########################################################

    ######################      END FRONT ROUTE         ###########################################################
