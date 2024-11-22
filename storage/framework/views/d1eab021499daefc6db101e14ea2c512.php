<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        
        <!-- Dark Logo-->
        <?php if($setting != null): ?>
            
            <!-- Light Logo-->
            <a href="#" class="logo logo-light">
                <span class="logo-sm">
                    <img src="<?php echo e(URL::asset($setting->getFirstMediaUrl('logo_header'))); ?>" alt="" height="22">
                </span>
                <span class="logo-lg">
                    <img src="<?php echo e(URL::asset($setting->getFirstMediaUrl('logo_header'))); ?>" alt="" width="50"
                        class="rounded-circle">
                </span>
            </a>
        <?php endif; ?>

        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div class="dropdown sidebar-user m-1 rounded">
        <button type="button" class="btn material-shadow-none" id="page-header-user-dropdown" data-bs-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span class="d-flex align-items-center gap-2">
                <img class="rounded header-profile-user"
                    src="<?php if(Auth::user()->avatar != ''): ?> <?php echo e(URL::asset('images/' . Auth::user()->avatar)); ?><?php else: ?><?php echo e(URL::asset('build/images/users/avatar-1.jpg')); ?> <?php endif; ?>"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text"><?php echo e(Auth::user()->name); ?></span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">En ligne</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Bienvenue <?php echo e(Auth::user()->first_name); ?>!</h6>
            <a class="dropdown-item" href="<?php echo e(route('admin-register.profil', Auth::user()->id)); ?>"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profil</span></a>

            <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Aide</span></a>
            <div class="dropdown-divider"></div>



            <a class="dropdown-item " href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                    key="t-logout"><?php echo app('translator')->get('translation.logout'); ?></span></a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?>
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <?php if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'developpeur'): ?>
            <?php endif; ?>
            <ul class="navbar-nav" id="navbar-nav">
                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-tableau de bord')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link <?php echo e(Route::is('dashboard.*') ? 'active' : ''); ?> "
                            href="<?php echo e(route('dashboard.index')); ?>">
                            <i class="ri-dashboard-2-line"></i> <span>TABLEAU DE BORD</span>
                        </a>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-configuration')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarConfiguration" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarConfiguration">
                            <i class="ri-list-settings-line"></i> <span>CONFIGURATION</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('categorie.*') || Route::is('produit.*') || Route::is('fournisseur.*') || Route::is('admin-register.*') || Route::is('caisse.*') || Route::is('magasin.*') || Route::is('unite.*') || Route::is('format.*') ? 'show' : ''); ?>"
                            id="sidebarConfiguration">
                            <ul class="nav nav-sm flex-column">






                                <li class="nav-item active">
                                    <a href="<?php echo e(route('magasin.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('magasin.*') ? 'active' : ''); ?>">Magasin</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('unite.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('unite.*') ? 'active' : ''); ?>">Unité de mesure</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('format.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('format.*') ? 'active' : ''); ?>">Format /
                                        Emballage</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('caisse.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('caisse.*') ? 'active' : ''); ?>">Caisse
                                    </a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('fournisseur.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('fournisseur.*') ? 'active' : ''); ?>">Fournisseurs
                                    </a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('categorie.create')); ?>"
                                        class="nav-link <?php echo e(Route::is('categorie.*') ? 'active' : ''); ?>">Categories
                                    </a>
                                </li>
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('produit.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('produit.*') ? 'active' : ''); ?>">Produits
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-stock')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarStock" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarStock">
                            <i class="ri ri-box-1-fill"></i> <span>GESTION DE STOCK</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('etat-stock.*') || Route::is('inventaire.*') || Route::is('sortie.*') || Route::is('ajustement.*') || Route::is('achat.*') || Route::is('produit.*') || Route::is('fournisseur.*') ? 'show' : ''); ?>"
                            id="sidebarStock">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('achat.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('achat.*') ? 'active' : ''); ?>">Reception de stock</a>
                                </li>



                                <li class="nav-item active">
                                    <a href="<?php echo e(route('sortie.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('sortie.*') ? 'active' : ''); ?>">Sortie de stock</a>
                                </li>


                                <li class="nav-item active">
                                    <a href="<?php echo e(route('inventaire.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('inventaire.*') ? 'active' : ''); ?>">Inventaire</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('etat-stock.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('etat-stock.*') ? 'active' : ''); ?>">Etat du stock</a>
                                </li>


                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-depense')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDepense" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarDepense">
                            <i class="ri ri-wallet-fill"></i> <span>GESTION DES DEPENSES</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('libelle-depense.*') || Route::is('categorie-depense.*') || Route::is('depense.*') ? 'show' : ''); ?>"
                            id="sidebarDepense">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('categorie-depense.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('categorie-depense.*') ? 'active' : ''); ?>">Categorie
                                        des
                                        depenses</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('libelle-depense.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('libelle-depense.*') ? 'active' : ''); ?>">Libellé des
                                        depenses</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('depense.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('depense.*') ? 'active' : ''); ?>">Depense</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-vente')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideBarVente" data-bs-toggle="collapse" role="button"
                            aria-controls="sideBarVente">
                            <i class="ri ri-file-list-line"></i> <span>GESTION DES VENTES</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('vente.*') || Route::is('commande.*') || Route::is('client.*') ? 'show' : ''); ?>"
                            id="sideBarVente">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('client.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('client.*') ? 'active' : ''); ?>">Clients</a>
                                </li>


                                <li class="nav-item active">
                                    <a href="<?php echo e(route('vente.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('vente.*') ? 'active' : ''); ?>">Ventes</a>
                                </li>

                                

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('commande.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('commande.*') ? 'active' : ''); ?>">Commandes</a>
                                </li>



                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                



                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-site')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarSite" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarSite">
                            <i class="ri ri-global-fill"></i> <span>SITE</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('slide.*') ? 'show' : ''); ?>" id="sidebarSite">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('slide.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('slide.*') ? 'active' : ''); ?>">Slides</a>
                                </li>

                               
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-rapport')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideBarRapport" data-bs-toggle="collapse" role="button"
                            aria-controls="sideBarRapport">
                            <i class="ri ri-file-list-line"></i> <span>RAPPORTS</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('rapport.*') ? 'show' : ''); ?>"
                            id="sideBarRapport">
                            <ul class="nav nav-sm flex-column">

                                

                                
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('rapport.vente')); ?>"
                                        class="nav-link <?php echo e(Route::is('rapport.vente') ? 'active' : ''); ?>">
                                        Ventes</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('rapport.exploitation')); ?>"
                                        class="nav-link <?php echo e(Route::is('rapport.exploitation') ? 'active' : ''); ?>">Exploitation</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>


                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('voir-menu')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideBarMenu" data-bs-toggle="collapse" role="button"
                            aria-controls="sideBarMenu">
                            <i class="ri ri-file-list-line"></i> <span>PLATS & MENU</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('menu.*') || Route::is('plat.*') || Route::is('plat-menu.*') || Route::is('categorie-menu.*') ? 'show' : ''); ?>"
                            id="sideBarMenu">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('categorie-menu.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('categorie-menu') ? 'active' : ''); ?>">
                                        Categories</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('plat-menu.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('plat-menu.*') ? 'active' : ''); ?>">Plats Menu </a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('plat.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('plat.*') ? 'active' : ''); ?>">Plats Quotidiens</a>
                                </li>



                                <li class="nav-item active">
                                    <a href="<?php echo e(route('menu.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('menu.*') ? 'active' : ''); ?>">Menu du jour</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

                <?php if(Auth::user()->role == 'superadmin' || Auth::user()->role == 'developpeur' || Auth::user()->can('voir-permission')): ?>
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarAuth">
                            <i class=" ri-settings-2-fill"></i> <span>PARAMETRE</span>
                        </a>
                        <div class="collapse menu-dropdown <?php echo e(Route::is('setting.*') || Route::is('module.*') || Route::is('role.*') || Route::is('permission.*') ? 'show' : ''); ?>"
                            id="sidebarAuth">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item active">
                                    <a href="<?php echo e(route('admin-register.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('admin-register.*') ? 'active' : ''); ?>">Administrateurs</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="<?php echo e(route('setting.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('setting.*') ? 'active' : ''); ?>">Informations</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('module.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('module.*') ? 'active' : ''); ?>">Modules</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('role.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('role.*') ? 'active' : ''); ?>">Roles</a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('permission.index')); ?>"
                                        class="nav-link <?php echo e(Route::is('permission.*') ? 'active' : ''); ?>">Permissions</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>





            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/layouts/sidebar.blade.php ENDPATH**/ ?>