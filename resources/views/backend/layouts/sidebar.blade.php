<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        {{-- <h4 class="text-white"> {{config('app.name')}} </h4> --}}
        <!-- Dark Logo-->
        @php
            $logoUrl = $setting?->getFirstMediaUrl('logo_header') ?: '';
        @endphp

        <a href="{{ url('index') }}" class="logo logo-light">
            <span class="logo-lg">
                <img class="rounded-circle" src="{{ $logoUrl }}" alt="logo" height="70">
            </span>
            <span class="logo-sm">
                <img src="{{ $logoUrl }}" alt="logo" height="50">
            </span>
        </a>


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
                    src="@if (Auth::user()->avatar != '') {{ URL::asset('images/' . Auth::user()->avatar) }}@else{{ URL::asset('assets/img/icon/user-icon.png'), }} @endif"
                    alt="Header Avatar">
                <span class="text-start">
                    <span class="d-block fw-medium sidebar-user-name-text">{{ Auth::user()->name }}</span>
                    <span class="d-block fs-14 sidebar-user-name-sub-text"><i
                            class="ri ri-circle-fill fs-10 text-success align-baseline"></i> <span
                            class="align-middle">En ligne</span></span>
                </span>
            </span>
        </button>
        <div class="dropdown-menu dropdown-menu-end">
            <!-- item-->
            <h6 class="dropdown-header">Bienvenue {{ Auth::user()->first_name }}!</h6>
            <a class="dropdown-item" href="{{ route('admin-register.profil', Auth::user()->id) }}"><i
                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                    class="align-middle">Profil</span></a>

            <a class="dropdown-item" href="#"><i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                <span class="align-middle">Aide</span></a>
            <div class="dropdown-divider"></div>



            <a class="dropdown-item " href="javascript:void();"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                    key="t-logout">@lang('translation.logout')</span></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'developpeur')
            @endif
            <ul class="navbar-nav" id="navbar-nav">
                {{-- <li class="menu-title"><span>@lang('translation.menu')</span></li> --}}

                @can('voir-tableau de bord')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Route::is('dashboard.*') ? 'active' : '' }} "
                            href="{{ route('dashboard.index') }}">
                            <i class="ri-dashboard-2-line"></i> <span>TABLEAU DE BORD</span>
                        </a>
                    </li>
                @endcan


                @can('voir-configuration')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarConfiguration" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarConfiguration">
                            <i class="ri-list-settings-line"></i> <span>CONFIGURATION</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('categorie.*') || Route::is('produit.*') || Route::is('mode_paiement.*') || Route::is('caisse.*') || Route::is('magasin.*') || Route::is('intrant.*') ? 'show' : '' }}"
                            id="sidebarConfiguration">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="{{ route('caisse.index') }}"
                                        class="nav-link {{ Route::is('caisse.*') ? 'active' : '' }}">Caisse
                                    </a>
                                </li>


                                <li class="nav-item active">
                                    <a href="{{ route('mode_paiement.index') }}"
                                        class="nav-link {{ Route::is('mode_paiement.*') ? 'active' : '' }}">Mode de
                                        paiement
                                    </a>
                                </li>



                                <li class="nav-item active">
                                    <a href="{{ route('categorie.create') }}"
                                        class="nav-link {{ Route::is('categorie.*') ? 'active' : '' }}">Categories
                                    </a>
                                </li>
                                @can('voir-produit')
                                    <li class="nav-item active">
                                        <a href="{{ route('produit.index') }}"
                                            class="nav-link {{ Route::is('produit.*') ? 'active' : '' }}">Produits vente
                                        </a>
                                    </li>
                                @endcan


                                @can('voir-produit')
                                    <li class="nav-item active">
                                        <a href="{{ route('intrant.index') }}"
                                            class="nav-link {{ Route::is('intrant.*') ? 'active' : '' }}">Produit intrant
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan


                @can('voir-stock')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarStock" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarStock">
                            <i class="ri ri-box-1-fill"></i> <span>GESTION DE STOCK</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('etat-stock.*') || Route::is('inventaire.*') || Route::is('sortie.*') || Route::is('entree.*') || Route::is('ajustement.*') || Route::is('produit.*') || Route::is('fournisseur.*') ? 'show' : '' }}"
                            id="sidebarStock">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="{{ route('sortie.index') }}"
                                        class="nav-link {{ Route::is('sortie.*') ? 'active' : '' }}">Sortie de stock intrants</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="{{ route('entree.index') }}"
                                        class="nav-link {{ Route::is('entree.*') ? 'active' : '' }}">entree de stock intrants</a>
                                </li>

                               

                                <li class="nav-item active">
                                    <a href="{{ route('etat-stock.index') }}"
                                        class="nav-link {{ Route::is('etat-stock.*') ? 'active' : '' }}">Etat du stock intrants</a>
                                </li>

                                 <li class="nav-item active">
                                    <a href="{{ route('ajustement.index') }}"
                                        class="nav-link {{ Route::is('ajustement.*') ? 'active' : '' }}">Ajustement de
                                        stock produit vente</a>
                                </li>



                                {{-- <li class="nav-item active">
                                    <a href="{{ route('inventaire.index') }}"
                                        class="nav-link {{ Route::is('inventaire.*') ? 'active' : '' }}">Inventaire</a>
                                </li> --}}
                            </ul>
                        </div>
                    </li>
                @endcan

                {{-- @can('voir-depense')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDepense" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarDepense">
                            <i class="ri ri-wallet-fill"></i> <span>GESTION DES DEPENSES</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('libelle-depense.*') || Route::is('categorie-depense.*') || Route::is('depense.*') ? 'show' : '' }}"
                            id="sidebarDepense">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="{{ route('categorie-depense.index') }}"
                                        class="nav-link {{ Route::is('categorie-depense.*') ? 'active' : '' }}">Categorie
                                        des
                                        depenses</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="{{ route('libelle-depense.index') }}"
                                        class="nav-link {{ Route::is('libelle-depense.*') ? 'active' : '' }}">Libellé des
                                        depenses</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="{{ route('depense.index') }}"
                                        class="nav-link {{ Route::is('depense.*') ? 'active' : '' }}">Depense</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan --}}

                {{-- @can('voir-vente')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideBarVente" data-bs-toggle="collapse" role="button"
                            aria-controls="sideBarVente">
                            <i class="ri ri-file-list-line"></i> <span>GESTION DES VENTES</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('vente.*') || Route::is('commande.*') || Route::is('client.*') ? 'show' : '' }}"
                            id="sideBarVente">
                            <ul class="nav nav-sm flex-column">

                                <li class="nav-item active">
                                    <a href="{{ route('client.index') }}"
                                        class="nav-link {{ Route::is('client.*') ? 'active' : '' }}">Clients</a>
                                </li>


                                <li class="nav-item active">
                                    <a href="{{ route('vente.index') }}"
                                        class="nav-link {{ Route::is('vente.*') ? 'active' : '' }}">Ventes</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan --}}

                @can('voir-vente')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ Route::is('vente.*') ? 'active' : '' }} "
                            href="{{ route('vente.index') }}">
                            <i class="ri ri-shopping-basket-2-fill"></i> <span>POINT DE VENTE</span>
                        </a>
                    </li>
                @endcan





                @can('voir-rapport')
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sideBarRapport" data-bs-toggle="collapse" role="button"
                            aria-controls="sideBarRapport">
                            <i class="ri ri-file-list-line"></i> <span>RAPPORTS</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('rapport.*') ? 'show' : '' }}"
                            id="sideBarRapport">
                            <ul class="nav nav-sm flex-column">



                                <li class="nav-item active">
                                    <a href="{{ route('rapport.vente') }}"
                                        class="nav-link {{ Route::is('rapport.vente') ? 'active' : '' }}">
                                        Ventes par catégorie</a>
                                </li>
                                <li class="nav-item active">
                                    <a href="{{ route('rapport.produit') }}"
                                        class="nav-link {{ Route::is('rapport.produit') ? 'active' : '' }}">Ventes par
                                        produits</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endcan




                @if (Auth::user()->role == 'superadmin' || Auth::user()->role == 'developpeur' || Auth::user()->can('voir-parametre'))
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarAuth" data-bs-toggle="collapse" role="button"
                            aria-controls="sidebarAuth">
                            <i class=" ri-settings-2-fill"></i> <span>PARAMETRE</span>
                        </a>
                        <div class="collapse menu-dropdown {{ Route::is('setting.*') || Route::is('module.*') || Route::is('role.*') || Route::is('permission.*') || Route::is('admin-register.*') ? 'show' : '' }}"
                            id="sidebarAuth">
                            <ul class="nav nav-sm flex-column">
                                <li class="nav-item active">
                                    <a href="{{ route('setting.index') }}"
                                        class="nav-link {{ Route::is('setting.*') ? 'active' : '' }}">Informations</a>
                                </li>

                                <li class="nav-item active">
                                    <a href="{{ route('admin-register.index') }}"
                                        class="nav-link {{ Route::is('admin-register.*') ? 'active' : '' }}">Utilisateurs</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('module.index') }}"
                                        class="nav-link {{ Route::is('module.*') ? 'active' : '' }}">Modules</a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('role.index') }}"
                                        class="nav-link {{ Route::is('role.*') ? 'active' : '' }}">Roles</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a href="{{ route('permission.index') }}"
                                        class="nav-link {{ Route::is('permission.*') ? 'active' : '' }}">Permissions/
                                        Roles</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                @endif

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
