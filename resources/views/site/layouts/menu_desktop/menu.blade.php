<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="logo">
                    @if ($setting != null)
                        <a href="{{ route('accueil') }}">
                            <img alt="" src="{{ URL::asset($setting->getFirstMediaUrl('logo_header')) }}" alt="" width="50">
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7">
                <div class="main-menu">
                    <nav>
                        <ul class="d-flex justify-content-center">
                            <li><a href="{{ route('accueil') }}">Accueil</a></li>
                            @foreach ($menu_link as $menu)
                                <li><a href="{{ route('produit', $menu->id) }}">
                                    @if ($menu->slug === 'bar')
                                        Nos boissons
                                    @elseif($menu->slug === 'menu')
                                        Nos plats
                                    @else
                                        {{ $menu->name }}
                                    @endif
                                </a></li>
                            @endforeach
                            <li><a href="{{ route('menu') }}">Menu du jour</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <div class="header-middle-right d-flex justify-content-end">
                    <div class="header-login px-3 header-cart">
                        @auth
                            <div class="dropdown">
                                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="icon-user icons text-white"></i>
                                    <span class="text-white">Mon compte</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">Mon profil</a></li>
                                    <li><a class="dropdown-item" href="{{ route('user.commande') }}">Mes commandes</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('user.logout') }}">Se déconnecter</a></li>
                                </ul>
                            </div>
                        @else
                            <a href="{{ route('user.login') }}">
                                <i class="icon-user icons text-white"></i>
                                <span class="text-white">Connexion</span>
                            </a>
                        @endauth
                    </div>
                    <div class="header-cart">
                        <a href="{{ route('panier') }}">
                            <i class="icon-handbag icons text-white"></i>
                            <span style="position: absolute; top: -15px; right: 80px;" class="count-style totalQuantity text-white">{{ session('cart') ? Session::get('totalQuantity') : '0' }}</span>
                            <span style="margin-left: 10px" class="cart-digit-bold totalPrice text-white ">{{ session('cart') ? Session::get('totalPrice') : '0' }} FCFA</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
