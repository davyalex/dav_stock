<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li><a href="{{ route('accueil') }}">Accueil</a></li>
                            {{-- @foreach ($menu_link as $menu)
                                @include('site.layouts.menu_desktop.menuchild', ['menu' => $menu])
                            @endforeach --}}
                            @foreach ($menu_link as $menu)
                                <li><a href="{{ route('produit', $menu->slug) }}">
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
        </div>
    </div>
</div>
<!-- mobile-menu-area-start -->
{{-- @include('site.layouts.menu_mobile.menu') --}}

<!-- mobile-menu-area-end -->
