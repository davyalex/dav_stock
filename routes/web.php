<?php

use App\Models\Equipe;
use App\Models\Optimize;
use App\Models\Maintenance;
use App\Models\CategorieDepense;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\backend\PageController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\SettingController;
use App\Http\Controllers\backend\AuthAdminController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\menu\MenuController;
use App\Http\Controllers\backend\menu\PlatController;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Controllers\backend\stock\AchatController;
use App\Http\Controllers\backend\module\ModuleController;
use App\Http\Controllers\backend\depense\DepenseController;
use App\Http\Controllers\backend\produit\ProduitController;
use App\Http\Controllers\backend\basic_site\SlideController;
use App\Http\Controllers\backend\blog\BlogContentController;
use App\Http\Controllers\backend\menu\ProduitMenuController;
use App\Http\Controllers\backend\stock\AjustementController;
use App\Http\Controllers\backend\basic_site\EquipeController;
use App\Http\Controllers\backend\blog\BlogCategoryController;
use App\Http\Controllers\backend\basic_site\ServiceController;
use App\Http\Controllers\backend\media\MediaContentController;
use App\Http\Controllers\backend\categorie\CategorieController;
use App\Http\Controllers\backend\media\MediaCategoryController;
use App\Http\Controllers\backend\basic_site\ReferenceController;
use App\Http\Controllers\backend\configuration\FormatController;
use App\Http\Controllers\backend\basic_site\TemoignageController;
use App\Http\Controllers\backend\permission\PermissionController;
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
Route::controller(AuthAdminController::class)->prefix('admin')->group(function () {
    route::get('/login', 'login')->name('admin.login');
    route::post('/login', 'login')->name('admin.login');
    route::post('/logout', 'logout')->name('admin.logout');
});



Route::middleware(['admin'])->group(function () {

    //Dashboard
    Route::prefix('dashboard')->controller(DashboardController::class)->group(function () {
        route::get('', 'index')->name('dashboard.index');
    });


    //register admin
    Route::prefix('register')->controller(AuthAdminController::class)->group(function () {
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
        route::post('delete/{id}', 'delete')->name('role.delete');
    });

    //role
    Route::prefix('permission')->controller(PermissionController::class)->group(function () {
        route::get('', 'index')->name('permission.index');
        route::post('store', 'store')->name('permission.store');
        route::get('load-permission/{id}', 'getPermissionOfModule')->name('loadpermission'); // get permission of module with ajax
        route::post('update/{id}', 'update')->name('permission.update');
        route::post('delete/{id}', 'delete')->name('permission.delete');
    });

    //module
    Route::prefix('module')->controller(ModuleController::class)->group(function () {
        route::get('', 'index')->name('module.index');
        route::post('store', 'store')->name('module.store');
        route::post('update/{id}', 'update')->name('module.update');
        route::post('delete/{id}', 'delete')->name('module.delete');
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



    #############  BASIC PAGE  #####################



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


    // stock -achat
    Route::prefix('achat')->controller(AchatController::class)->group(function () {
        route::get('', 'index')->name('achat.index');
        route::get('create', 'create')->name('achat.create');
        route::post('store', 'store')->name('achat.store');
        route::get('edit/{id}', 'edit')->name('achat.edit');
        route::post('update/{id}', 'update')->name('achat.update');
        route::get('delete/{id}', 'delete')->name('achat.delete');
    });

    // stock -ajustement
    Route::prefix('ajustement')->controller(AjustementController::class)->group(function () {
        route::get('', 'index')->name('ajustement.index');
        route::get('create/{id}', 'create')->name('ajustement.create');
        route::post('store', 'store')->name('ajustement.store');
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
