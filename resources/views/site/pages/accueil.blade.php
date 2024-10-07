@extends('site.layouts.app')

@section('title' , 'Accueil')

@section('content')


<!-- ========== Start slider carousel ========== -->
@include('site.sections.slider')
<!-- ========== End slider carousel ========== -->

    
    <!-- ========== Start product with category ========== -->
    <div class="product-area pt-95 pb-70">
        <div class="custom-container">
            <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                <div class="product-tab-list nav">
                    <a class="active" href="#tab1" data-bs-toggle="tab">
                        <h4>Tous</h4>
                    </a>
                    <a href="#tab2" data-bs-toggle="tab">
                        <h4>Nos boissons</h4>
                    </a>
                    <a href="#tab3" data-bs-toggle="tab">
                        <h4>Nos plats</h4>
                    </a>
                </div>
                <p>Découvrez notre sélection de produits pour le bar et les plats.</p>
            </div>
            <div class="tab-content jump yellow-color">
                <div id="tab1" class="tab-pane active">
                    <div class="row">
                        @foreach($produitsBar->concat($produitsMenu) as $produit)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="{{ $produit->nom }}">
                                        </a>
                                       
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>
                                                @if($produit->categorie->famille == 'bar' && $produit->achats->isNotEmpty())
                                                    {{ $produit->achats->first()->prix_vente_unitaire }}
                                                @else
                                                    {{ $produit->prix }}
                                                @endif
                                                FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="tab2" class="tab-pane">
                    <div class="row">
                        @foreach($produitsBar as $produit)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="{{ $produit->nom }}">
                                        </a>
                                      
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>
                                                @if($produit->achats->isNotEmpty())
                                                    {{ $produit->achats->first()->prix_vente_unitaire }}
                                                @else
                                                    {{ $produit->prix }}
                                                @endif
                                                FCFA
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="tab3" class="tab-pane">
                    <div class="row">
                        @foreach($produitsMenu as $produit)
                            <div class="custom-col-5">
                                <div class="product-wrapper mb-25">
                                    <div class="product-img">
                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="{{ $produit->nom }}">
                                        </a>
                                       
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            <span>{{ $produit->prix }} FCFA</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== End product with category ========== -->



    <!-- ========== Start banner card ========== -->
    <div class="banner-area row-col-decrease pb-75 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="single-banner mb-30">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-7.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="single-banner mb-30">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-8.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== End banner card ========== -->


    <!-- ========== Start best seller ========== -->
    <div class="best-food-area pb-95">
        <div class="custom-container">
            <div class="row">
                <div class="best-food-width-1">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-5.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="best-food-width-2">
                    <div class="product-top-bar section-border mb-25 yellow-color">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">Produits les plus commandés</h3>
                        </div>
                    </div>
                    <div class="tab-content jump yellow-color">
                        <div id="tab4" class="tab-pane active">
                            <div class="product-slider-active owl-carousel product-nav">
                                @foreach($produitsLesPlusCommandes as $produit)
                                <div class="product-wrapper">
                                    <div class="product-img">
                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="{{ $produit->nom }}">
                                        </a>
                                       
                                    </div>
                                    <div class="product-content">
                                        <h4>
                                            <a href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                        </h4>
                                        <div class="product-price-wrapper">
                                            @if($produit->categorie->famille == 'bar' && $produit->achats->isNotEmpty())
                                                <span>{{ $produit->achats->first()->prix_vente_unitaire }} FCFA</span>
                                            @else
                                                <span>{{ $produit->prix }} FCFA</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="best-food-width-1 mrg-small-35">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-6.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== End best seller ========== -->



    <!-- ========== Start banner ========== -->
    <div class="banner-area mb-3">
        <div class="container">
            <div class="discount-overlay bg-img pt-130 pb-130"
                style="background-image:url(assets/img/banner/banner-4.jpg);">
                <div class="discount-content text-center">
                    <h3>It’s Time To Start <br>Your Own Revolution By Laurent</h3>
                    <p>Exclusive Offer -10% Off This Week</p>
                    <div class="banner-btn">
                        <a href="#">Order Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ========== End banner ========== -->
        @include('site.components.ajouter-au-panier')

@endsection
