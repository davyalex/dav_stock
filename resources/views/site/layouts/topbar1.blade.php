<div class="header-top bg-danger">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12 col-sm-12">
                <div class="welcome-area">
                    <p class="d-flex justify-content-between">
                        <i class="ion-ios-restaurant"> {{ $setting->projet_description ?? 'Bienvenue chez restaurant Jeanne!' }}</i> 
                        <i class="ion-ios-telephone"> {{ $setting->phone1 ?? '' }}</i> 
                        <i class="ion-ios-email"> {{ $setting->email1 ?? '' }}</i> 
                        <i class="ion-ios-location"> {{ $setting->localisation ?? '' }}</i>
                    </p>
                </div>
            </div>
            {{-- <div class="col-lg-8 col-md-8 col-12 col-sm-8">
                <div class="account-curr-lang-wrap f-right">
                    <ul>
                        <li class="top-hover"><a href="#">  <i class=" icon-user"></i> Mon compte <i class="ion-chevron-down"></i></a>
                            <ul>
                                <li><a href="wishlist.html">Mes commandes </a></li>
                                <li><a href="login-register.html">Modifier mes infos</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </div>
</div>