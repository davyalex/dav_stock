<div class="header-middle">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12 col-sm-4">
                <div class="logo">
                    @if ($setting !=null)
                    <a href="{{route('accueil')}}">
                        <img alt="" src="{{ URL::asset($setting->getFirstMediaUrl('logo_header')) }}" alt=""  width="50">
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-lg-9 col-md-8 col-12 col-sm-8">
                <div class="header-middle-right f-right">
                    {{-- <div class="header-login">
                        <a href="login-register.html">
                            <div class="header-icon-style">
                                <i class="icon-user icons"></i>
                            </div>
                            <div class="login-text-content">
                                <p>S'inscrire <br> or <span>Sign in</span></p>
                            </div>
                        </a>
                    </div> --}}
                    {{-- <div class="header-wishlist">
                        <a href="wishlist.html">
                            <div class="header-icon-style">
                                <i class="icon-heart icons"></i>
                            </div>
                            <div class="wishlist-text">
                                <p>Your <br> <span>Wishlist</span></p>
                            </div>
                        </a>
                    </div> --}}
                    <div class="header-cart">
                        <a href="#">
                            <div class="header-icon-style">
                                <i class="icon-handbag icons"></i>
                                <span class="count-style">02</span>
                            </div>
                            <div class="cart-text">
                                <span class="digit">Mon panier</span>
                                <span class="cart-digit-bold">$209.00</span>
                            </div>
                        </a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>