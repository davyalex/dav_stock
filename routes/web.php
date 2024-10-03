<?php

use App\Models\Optimize;
use App\Models\Inventaire;
use App\Models\Maintenance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\site\SiteController;
use App\Http\Controllers\site\PanierController;
use App\Http\Controllers\site\AuthUserController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\menu\MenuController;
use App\Http\Controllers\backend\menu\PlatController;
use App\Http\Controllers\backend\slide\SlideController;
use App\Http\Controllers\backend\stock\AchatController;
use App\Http\Controllers\backend\user\ClientController;
use App\Http\Controllers\backend\vente\VenteController;
use App\Http\Controllers\backend\stock\SortieController;
use App\Http\Controllers\backend\user\AdminController;  
use App\Http\Controllers\backend\module\ModuleController;
use App\Http\Controllers\backend\depense\DepenseController;
use App\Http\Controllers\backend\permission\RoleController;
use App\Http\Controllers\backend\produit\ProduitController;
use App\Http\Controllers\backend\stock\EtatStockController;
use App\Http\Controllers\backend\stock\AjustementController;
use App\Http\Controllers\backend\stock\InventaireController;
use App\Http\Controllers\backend\parametre\SettingController;
use App\Http\Controllers\backend\categorie\CategorieController;
use App\Http\Controllers\backend\configuration\CaisseController;
use App\Http\Controllers\backend\configuration\FormatController;
use App\Http\Controllers\backend\configuration\MagasinController;
use App\Http\Controllers\backend\permission\PermissionController;
use App\Http\Controllers\backend\depense\LibelleDepenseController;
use App\Http\Controllers\backend\fournisseur\FournisseurController;
use App\Http\Controllers\backend\depense\CategorieDepenseController;
use App\Http\Controllers\backend\configuration\UniteMesureController;

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
        route::get('', 'index')->name('dashboard.index');
    });

    //register client
    Route::prefix('client')->controller(ClientController::class)->group(function () {
        route::get('', 'index')->name('client.index');
        route::post('store', 'store')->name('client.store');
        route::post('update/{id}', 'update')->name('client.update');
        route::get('delete/{id}', 'delete')->name('client.delete');
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
        route::post('store', 'store')->name('permission.store');
        route::get('load-permission/{id}', 'getPermissionOfModule')->name('loadpermission'); // get permission of module with ajax
        route::post('update/{id}', 'update')->name('permission.update');
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
    });


    #############  SLIDER  #####################

    //slider of basic site
    Route::prefix('slide')->controller(SlideController::class)->group(function () {
        route::get('', 'index')->name('slide.index');
        route::post('store', 'store')->name('slide.store');
        route::post('update/{id}', 'update')->name('slide.update');
        route::get('delete/{id}', 'delete')->name('slide.delete');
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
                '--secret' => 'admin@2024',
                '--render' => 'backend.pages.maintenance-mode-view',
            ]);
            Maintenance::create([
                'type' => 'down',
            ]);
            return response()->json(['message' => 'mode maintenance activé', 'status' => 200], 200);
        }
    )->name('setting.maintenance-down');



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
        route::get('select', 'selectCaisse')->name('caisse.select')->middleware('role:caisse');
        route::post('select', 'selectCaisse')->name('caisse.select.post')->middleware('role:caisse');

        // route::get('delete/{id}', 'delete')->name('caisse.delete');
    });

    //categorie
    Route::prefix('categorie')->controller(CategorieController::class)->group(function () {
        // route::get('', 'index')->name('menu.index');
        route::get('create', 'create')->name('categorie.create');
        route::post('store', 'store')->name('categorie.store');
        route::get('add-subCat/{id}', 'addSubCat')->name('categorie.add-subCat'); // add subCategorie
        route::post('add-subCat-store', 'addSubCatStore')->name('categorie.add-subCat-store'); // add subCategorie
        route::get('edit/{id}', 'edit')->name('categorie.edit');
        route::post('update/{id}', 'update')->name('categorie.update');
        route::get('delete/{id}', 'delete')->name('categorie.delete');
    });


    //fournisseur
    Route::prefix('fournisseur')->controller(FournisseurController::class)->group(function () {
        route::get('', 'index')->name('fournisseur.index');
        route::post('store', 'store')->name('fournisseur.store');
        route::post('update/{id}', 'update')->name('fournisseur.update');
        route::get('delete/{id}', 'delete')->name('fournisseur.delete');
    });

    // unite de mesure
    Route::prefix('unite')->controller(UniteMesureController::class)->group(function () {
        route::get('', 'index')->name('unite.index');
        route::post('store', 'store')->name('unite.store');
        route::post('update/{id}', 'update')->name('unite.update');
        route::get('delete/{id}', 'delete')->name('unite.delete');
    });

    // format
    Route::prefix('format')->controller(FormatController::class)->group(function () {
        route::get('', 'index')->name('format.index');
        route::post('store', 'store')->name('format.store');
        route::post('update/{id}', 'update')->name('format.update');
        route::get('delete/{id}', 'delete')->name('format.delete');
    });

    // produit
    Route::prefix('produit')->controller(ProduitController::class)->group(function () {
        route::get('', 'index')->name('produit.index');
        route::get('create', 'create')->name('produit.create');
        route::post('store', 'store')->name('produit.store');
        route::get('show/{id}', 'show')->name('produit.show');
        route::get('edit/{id}', 'edit')->name('produit.edit');
        route::post('update/{id}', 'update')->name('produit.update');
        route::get('delete/{id}', 'delete')->name('produit.delete');
    });

    //etat stock
    Route::prefix('etat-stock')->controller(EtatStockController::class)->group(function () {
        route::get('', 'index')->name('etat-stock.index');
    });



    // stock -achat
    Route::prefix('achat')->controller(AchatController::class)->group(function () {
        route::get('facture', 'facture')->name('achat.facture');  // liste des facture
        route::get('facture/{id}', 'index')->name('achat.index');
        route::get('create', 'create')->name('achat.create');
        route::post('store', 'store')->name('achat.store');
        route::get('edit/{id}', 'edit')->name('achat.edit');
        route::post('update/{id}', 'update')->name('achat.update');
        route::get('delete/{id}', 'delete')->name('achat.delete');
        route::post('check-facture', 'checkFactureExist')->name('achat.check-facture');
        route::post('check-montant', 'verifiyMontant')->name('achat.check-montant');  // check montant facture

    });

    // stock -ajustement
    Route::prefix('ajustement')->controller(AjustementController::class)->group(function () {
        route::get('', 'index')->name('ajustement.index');
        route::get('create/{id}', 'create')->name('ajustement.create');
        route::post('store', 'store')->name('ajustement.store');
    });

    // stock -sortie
    Route::prefix('sortie')->controller(SortieController::class)->group(function () {
        route::get('', 'index')->name('sortie.index');
        route::get('show/{id}', 'show')->name('sortie.show');
        route::get('create', 'create')->name('sortie.create');
        route::post('store', 'store')->name('sortie.store');
    });


    // stock -inventaire
    Route::prefix('inventaire')->controller(InventaireController::class)->group(function () {
        route::get('', 'index')->name('inventaire.index');
        route::get('show/{id}', 'show')->name('inventaire.show');
        route::get('create', 'create')->name('inventaire.create');
        route::post('store', 'store')->name('inventaire.store');
    });


    // stock -vente
    Route::prefix('vente')->controller(VenteController::class)->group(function () {
        route::get('', 'index')->name('vente.index');
        route::get('show/{id}', 'show')->name('vente.show');
        route::get('create', 'create')->name('vente.create');
        route::post('store', 'store')->name('vente.store');
        route::get('cloture-caisse', 'clotureCaisse')->name('vente.cloture-caisse');
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
        route::get('create', 'create')->name('depense.create');
        route::post('store', 'store')->name('depense.store');
        route::get('edit/{id}', 'edit')->name('depense.edit');
        route::post('update/{id}', 'update')->name('depense.update');
        route::get('delete/{id}', 'delete')->name('depense.delete');
    });


    // produit menu
    Route::prefix('plat')->controller(PlatController::class)->group(function () {
        route::get('', 'index')->name('plat.index');
        route::get('create', 'create')->name('plat.create');
        route::post('store', 'store')->name('plat.store');
        route::get('show/{id}', 'show')->name('plat.show');
        route::get('edit/{id}', 'edit')->name('plat.edit');
        route::post('update/{id}', 'update')->name('plat.update');
        route::get('delete/{id}', 'delete')->name('plat.delete');
    });


    //  menu
    Route::prefix('menu')->controller(MenuController::class)->group(function () {
        route::get('', 'index')->name('menu.index');
        route::get('create', 'create')->name('menu.create');
        route::post('store', 'store')->name('menu.store');
        route::get('show/{id}', 'show')->name('menu.show');
        route::get('edit/{id}', 'edit')->name('menu.edit');
        route::post('update/{id}', 'update')->name('menu.update');
        route::get('delete/{id}', 'delete')->name('menu.delete');
    });
});

######################      END BACKEND ROUTE         ###########################################################






######################      START FRONT ROUTE         ###########################################################
//User Login
Route::controller(AuthUserController::class)->group(function () {
    route::get('connexion', 'login')->name('user.login');
    route::post('connexion', 'login')->name('user.login.post');
    route::get('inscription', 'register')->name('user.register');
    route::post('inscription', 'register')->name('user.register.post');
    route::get('logout', 'logout')->name('user.logout');
    route::get('profile', 'profile')->name('user.profile');
    route::get('mes-commandes', 'commande')->name('user.commande');
});

//site
Route::controller(SiteController::class)->group(function () {
    route::get('', 'accueil')->name('accueil');
    route::get('/categorie/{slug}', 'produit')->name('produit'); // get product of categorie selected
    route::get('/menu', 'menu')->name('menu');
    route::get('/produit/detail/{slug}', 'produitDetail')->name('produit.detail');
});

//panier
Route::controller(PanierController::class)->group(function () {
    route::get('panier', 'index')->name('panier');
    route::get('add/{id}', 'add')->name('cart.add');
    route::post('update', 'update')->name('cart.update');
    route::post('remove', 'remove')->name('cart.remove');
    route::get('caisse', 'checkout')->name('cart.checkout')->middleware('auth'); // caisse infos commande
    route::post('order', 'saveOrder')->name('cart.save-order')->middleware('auth'); // enregistrer la commande
    // route::get('clear', 'clear')->name('cart.clear');
});



  
  

    


    ######################      END FRONT ROUTE         ###########################################################
