
<!-- mobile-menu-area-start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow" id="nav">
                            <li><a href="{{ route('accueil') }}">Accueil</a></li>
                            @foreach ($menu_link as $menu)
                                @include('site.layouts.menu_mobile.menuchild', ['menu' => $menu])
                            @endforeach
                            <li><a href="">Menu du jour</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area-end -->
