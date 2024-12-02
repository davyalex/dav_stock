@extends('site.layouts.app')

@section('title', 'Accueil')

@section('content')


    <!-- ========== Start slider carousel ========== -->
    @include('site.sections.slider')
    <!-- ========== End slider carousel ========== -->
    <style>
        .produit-image-container {
            position: relative;
            display: inline-block;
        }

        .produit-image-container img {
            width: 100%;
            /* Ajuste la taille selon tes besoins */
        }

        .rupture-stock-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 0, 0, 0.7);
            /* Fond rouge avec opacité */
            color: white;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
        }

        .product-content {
            text-align: center;
            text-transform: uppercase;
        }

        .product-price-wrapper span {
            font-weight: bold;
            color: rgba(255, 0, 0, 0.641)
        }
    </style>


    <div class="container ">
        <div class="row flex-row">
            {{-- <div class="col-lg-3 pt-95 pb-70">
                <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                    <div class="shop-widget">
                        <h4 class="shop-sidebar-title">MENU</h4>
                        <div class="shop-catigory">
                            @include('site.sections.categorie.categorieproduit')
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-12 col-md-12 col-sm-12 col-lg-12">
                <!-- ========== Start product with category ========== -->
                <div class="product-area pt-95 pb-70">
                    <div class="custom-container">
                        <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                            <div class="product-tab-list nav">
                                {{-- <a class="active" href="#tab1" data-bs-toggle="tab">
                    <h4>Tous</h4>
                </a> --}}
                                <a class="active" href="#tab3" data-bs-toggle="tab">
                                    <h4>Nos plats</h4>
                                </a>
                                <a href="#tab2" data-bs-toggle="tab">
                                    <h4>Nos boissons</h4>
                                </a>
                            </div>
                            <p>Découvrez notre sélection de produits pour les boissons et les plats.</p>
                        </div>
                        <div class="tab-content jump yellow-color">
                            <div id="tab1" class="tab-pane">
                                <div class="row">
                                    @foreach ($produitsMenu->concat($produitsBar) as $produit)
                                        <div class="custom-col-5 mb-4">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="{{ route('produit.detail', $produit->slug) }}">
                                                        <div class="produit-image-container">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}">

                                                            @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                                <div class="rupture-stock-overlay">Rupture de stock</div>
                                                            @endif
                                                        </div>
                                                    </a>

                                                </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a
                                                            href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>

                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        <span id="price" data-price={{ $produit->prix }}>
                                                            {{-- @if ($produit->categorie->famille == 'bar' && $produit->achats->isNotEmpty())
                                                {{ $produit->achats->first()->prix_vente_unitaire }}
                                            @else
                                               
                                            @endif --}}
                                                            {{ number_format($produit->prix, 0, ',', ' ') }}
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
                                    @foreach ($produitsBar as $produit)
                                        <div class="col-lg-3 col-md-3 col-6 ">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="{{ route('produit.detail', $produit->slug) }}">
                                                        <div class="produit-image-container">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}">

                                                            @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                                <div class="rupture-stock-overlay">Rupture de stock</div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a
                                                            href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        <span id="price" data-price={{ $produit->prix }}>
                                                            {{-- @if ($produit->achats->isNotEmpty())
                                                {{ $produit->achats->first()->prix_vente_unitaire }}
                                            @else
                                               
                                            @endif --}}
                                                            {{ number_format($produit->prix, 0, ',', ' ') }}
                                                            FCFA
                                                        </span>
                                                    </div>

                                                    @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                        <span><span style="color: red" class="text-danger">Produit en
                                                                rupture</span>
                                                        @else
                                                            <div class="mt-3">
                                                                <button type="button"
                                                                    class="btn btn-danger addCart text-white"
                                                                    data-id="{{ $produit->id }}"
                                                                    style="border-radius: 10px">
                                                                    <i class="fa fa-shopping-cart"></i> Commander
                                                                </button>
                                                            </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                @php
                                    $idCatBoisson = app\Models\Categorie::whereSlug('bar')->first();
                                @endphp
                                <div class="col-12 col-md-6 col-lg-6  m-auto text-center mt-5">
                                    <a href="{{ route('produit', $idCatBoisson->id) }}"
                                        class="btn btn-dark w-auto text-white fw-bolder" style=" border-radius: 10px ; ">
                                        Affichez plus de boissons <i class="fa fa-caret-right"></i>
                                    </a>

                                </div>
                            </div>


                            <div id="tab3" class="tab-pane active">
                                <div class="row">
                                    @foreach ($produitsMenu as $produit)
                                        <div class="col-lg-3 col-md-3 col-6">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="{{ route('produit.detail', $produit->slug) }}">
                                                        <div class="produit-image-container">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}">

                                                            @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                                <div class="rupture-stock-overlay">Rupture de stock</div>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a
                                                            href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        <span id="price" data-price={{ $produit->prix }}>
                                                            {{ number_format($produit->prix, 0, ',', ' ') }} FCFA</span>
                                                    </div>

                                                    @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                        <span><span style="color: red" class="text-danger">Produit en
                                                                rupture</span>
                                                        @else
                                                            <div class="mt-2 mb-3">
                                                                <button type="button"
                                                                    class="btn btn-danger addCart text-white"
                                                                    data-id="{{ $produit->id }}"
                                                                    style="border-radius: 10px">
                                                                    <i class="fa fa-shopping-cart"></i> Commander
                                                                </button>
                                                            </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @php
                                    $idCatPlat = app\Models\Categorie::whereSlug('bar')->first();
                                @endphp
                                <div class="col-12 col-md-6 col-lg-6  m-auto text-center mt-4">
                                    <a href="{{ route('produit', $idCatPlat->id) }}"
                                        class="btn btn-dark w-auto text-white fw-bolder" style="border-radius: 10px;">
                                        Affichez plus de Plats <i class="fa fa-caret-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== End product with category ========== -->

            </div>
        </div>


        <!-- ========== Start banner card ========== -->
        <div class="banner-area row-col-decrease pb-75 clearfix">
            <div class="container">
                <div class="row">
                    @foreach ($data_slide->where('type', 'petite-banniere') as $item)
                        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                            <div class="single-banner mb-30">
                                <div class="hover-style">
                                    <a href="#">
                                        <img src="{{ $item->getFirstMediaUrl('petite-banniere') }}" alt="bannière">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- ========== End banner card ========== -->
    </div>


    <!-- ========== Start best seller ========== -->
    <div class="best-food-area pb-95">
        <div class="custom-container">
            <div class="row">
                {{-- <div class="best-food-width-1">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-5.jpg" alt=""></a>
                        </div>
                    </div>
                </div> --}}
                <div class="col-12">
                    <div class="product-top-bar section-border mb-25 yellow-color">
                        <div class="section-title-wrap">
                            <h3 class="section-title section-bg-white">Produits recommandés</h3>
                        </div>
                    </div>
                    <div class="tab-content jump yellow-color">
                        <div id="tab4" class="tab-pane active">
                            <div class="product-slider-active owl-carousel product-nav">
                                @foreach ($produitsLesPlusCommandes as $produit)
                                    <div class="product-wrapper">
                                        <div class="product-img">
                                            <a href="{{ route('produit.detail', $produit->slug) }}">
                                                <div>
                                                    <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                        alt="{{ $produit->nom }}">
                                                </div>
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <h4>
                                                <a
                                                    href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                            </h4>
                                            <div class="product-price-wrapper">
                                                {{-- @if ($produit->categorie->famille == 'bar' && $produit->achats->isNotEmpty())
                                                    <span>{{ $produit->achats->first()->prix_vente_unitaire }} FCFA</span>
                                                @else
                                                  
                                                @endif --}}
                                                <span id="price"
                                                    data-price={{ $produit->prix }}>{{ number_format($produit->prix, 0, ',', ' ') }}
                                                    FCFA</span>
                                            </div>

                                            @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                                                <span><span style="color: red" class="text-danger">Produit en
                                                        rupture</span>
                                                @else
                                                    <div class="my-2">
                                                        <button type="button" class="btn btn-danger addCart text-white"
                                                            data-id="{{ $produit->id }}" style="border-radius: 10px">
                                                            <i class="fa fa-shopping-cart"></i> Commander
                                                        </button>
                                                    </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="best-food-width-1 mrg-small-35">
                    <div class="single-banner">
                        <div class="hover-style">
                            <a href="#"><img src="assets/img/banner/banner-6.jpg" alt=""></a>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- ========== End best seller ========== -->



    <!-- ========== Start banner ========== -->
    <div class="banner-area mb-3">
        <div class="container">
            @foreach ($data_slide->where('type', 'grande-banniere') as $item)
                @foreach ($item->getMedia('grande-banniere') as $media)
                    <div class="discount-overlay bg-img pt-130 pb-130"
                        style="background-image:url('{{ $media->getUrl() }}');">
                        <div class="discount-content text-center">
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->subtitle }}</p>
                            @if ($item->btn_url && $item->btn_name)
                                <div class="banner-btn">
                                    <a href="{{ $item->btn_url }}">{{ $item->btn_name }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>
    <!-- ========== End banner ========== -->
    @include('site.components.ajouter-au-panier')

@endsection
