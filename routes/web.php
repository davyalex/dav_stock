<?php

use App\Models\Equipe;
use App\Models\Optimize;
use App\Models\Maintenance;
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
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use App\Http\Controllers\backend\module\ModuleController;
use App\Http\Controllers\backend\produit\ProduitController;
use App\Http\Controllers\backend\basic_site\SlideController;
use App\Http\Controllers\backend\blog\BlogContentController;
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


    //page
    Route::prefix('page')->controller(PageController::class)->group(function () {
        route::get('', 'index')->name('page.index');
        route::get('create', 'create')->name('page.create');
        route::post('store', 'store')->name('page.store');
        route::get('edit/{id}', 'edit')->name('page.edit');
        route::post('update/{id}', 'update')->name('page.update');
        route::post('delete/{id}', 'delete')->name('page.delete');
    });


    //Setting
    Route::prefix('setting')->controller(SettingController::class)->group(function () {
        route::get('', 'index')->name('setting.index');
        route::post('store', 'store')->name('setting.store');
    });


    #############  BLOG  #####################
    //blog---category
    Route::prefix('blog-category')->controller(BlogCategoryController::class)->group(function () {
        route::get('', 'index')->name('blog-category.index');
        route::post('store', 'store')->name('blog-category.store');
        route::post('update/{id}', 'update')->name('blog-category.update');
        route::get('delete/{id}', 'delete')->name('blog-category.delete');
        route::post('position/{id}', 'position')->name('blog-category.position');
    });


    //blog---content
    Route::prefix('blog-content')->controller(BlogContentController::class)->group(function () {
        route::get('', 'index')->name('blog-content.index');
        route::get('create', 'create')->name('blog-content.create');
        route::post('store', 'store')->name('blog-content.store');
        route::get('edit/{id}', 'edit')->name('blog-content.edit');
        route::post('update/{id}', 'update')->name('blog-content.update');
        route::get('delete/{id}', 'delete')->name('blog-content.delete');
    });


    #############  MENU  #####################
    Route::prefix('menu')->controller(MenuController::class)->group(function () {
        // route::get('', 'index')->name('menu.index');
        route::get('create', 'create')->name('menu.create');
        route::post('store', 'store')->name('menu.store');
        route::get('add-item/{id}', 'addMenuItem')->name('menu.add-item'); // add subMenu
        route::post('add-item-store', 'addMenuItemStore')->name('menu.add-item-store'); // add subMenu

        route::get('edit/{id}', 'edit')->name('menu.edit');
        route::post('update/{id}', 'update')->name('menu.update');
        route::get('delete/{id}', 'delete')->name('menu.delete');
    });


    #############  SERVICE  #####################

    //service of basic site
    Route::prefix('service')->controller(ServiceController::class)->group(function () {
        route::get('', 'index')->name('service.index');
        route::get('create', 'create')->name('service.create');
        route::post('store', 'store')->name('service.store');
        route::get('edit/{id}', 'edit')->name('service.edit');
        route::post('update/{id}', 'update')->name('service.update');
        route::get('delete/{id}', 'delete')->name('service.delete');
    });


    #############  REFERENCE  #####################

    //reference of basic site
    Route::prefix('reference')->controller(ReferenceController::class)->group(function () {
        route::get('', 'index')->name('reference.index');
        route::post('store', 'store')->name('reference.store');
        route::post('update/{id}', 'update')->name('reference.update');
        route::get('delete/{id}', 'delete')->name('reference.delete');
    });



    #############  EQUIPE  #####################

    //equipe of basic site
    Route::prefix('equipe')->controller(EquipeController::class)->group(function () {
        route::get('', 'index')->name('equipe.index');
        route::post('store', 'store')->name('equipe.store');
        route::post('update/{id}', 'update')->name('equipe.update');
        route::get('delete/{id}', 'delete')->name('equipe.delete');
    });

    #############  SLIDER  #####################

    //slider of basic site
    Route::prefix('slide')->controller(SlideController::class)->group(function () {
        route::get('', 'index')->name('slide.index');
        route::post('store', 'store')->name('slide.store');
        route::post('update/{id}', 'update')->name('slide.update');
        route::get('delete/{id}', 'delete')->name('slide.delete');
    });


    #############  TEMOIGNAGE  #####################

    //slider of basic site
    Route::prefix('temoignage')->controller(TemoignageController::class)->group(function () {
        route::get('', 'index')->name('temoignage.index');
        route::post('store', 'store')->name('temoignage.store');
        route::post('update/{id}', 'update')->name('temoignage.update');
        route::get('delete/{id}', 'delete')->name('temoignage.delete');
    });


    #############  MEDIATHEQUE  #####################

    //mediatheque---category
    Route::prefix('media-category')->controller(MediaCategoryController::class)->group(function () {
        route::get('', 'index')->name('media-category.index');
        route::post('store', 'store')->name('media-category.store');
        route::post('update/{id}', 'update')->name('media-category.update');
        route::get('delete/{id}', 'delete')->name('media-category.delete');
        route::post('position/{id}', 'position')->name('media-category.position');
    });


    //mediatheque---media
    Route::prefix('media-content')->controller(MediaContentController::class)->group(function () {
        route::get('', 'index')->name('media-content.index');
        route::get('create', 'create')->name('media-content.create');
        route::post('store', 'store')->name('media-content.store');
        route::get('edit/{id}', 'edit')->name('media-content.edit');
        route::post('update/{id}', 'update')->name('media-content.update');
        route::get('delete/{id}', 'delete')->name('media-content.delete');
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
        route::get('create-new-product', 'createNewProduct')->name('produit.createNewProduct'); // creer un nouveau de produit-formulaire
        route::post('store-new-product', 'StoreNewProduct')->name('produit.StoreNewProduct'); // creer un nouveau de produit-store

        route::post('store', 'store')->name('produit.store');
        // route::post('update/{id}', 'update')->name('produit.update');
        // route::get('delete/{id}', 'delete')->name('produit.delete');
    });
});




######################      END BACKEND ROUTE         ###########################################################
