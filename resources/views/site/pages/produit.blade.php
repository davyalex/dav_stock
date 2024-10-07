@extends('site.layouts.app')

@section('title', 'Liste des ' . $categorieSelect->name)

@section('content')

    <style>
        .product-img img {
            width: 100%;
            /* Adapter à la largeur du conteneur */
            height: 250px;
            /* Fixer une hauteur spécifique */
            object-fit: contain;
            /* Maintenir les proportions tout en remplissant la zone */
        }

        .category-sticker {
            position: absolute;
            top: 10px;
            /* Ajuster la position verticale */
            left: 10px;
            /* Ajuster la position horizontale */
            background-color: rgba(0, 0, 0, 0.7);
            /* Fond semi-transparent */
            color: white;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 5px;
            z-index: 10;
        }
    </style>
    <div class="shop-page-area pt-10 pb-100">
        <div class="container">
            <div class="row flex-row">
                <!-- start sidebar categorie-->
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <div class="shop-widget">
                            <h4 class="shop-sidebar-title">Nos {{ $categorieSelect->name }} </h4>
                            <div class="shop-catigory">
                                {{-- @include('site.sections.categorie.categoriechild', [
                                    'categories' => $categories,
                                    'categorieSelect' => $categorieSelect,
                                ]) --}}

                                @include('site.sections.categorie.categorieproduit')

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end sidebar categorie-->
                <div class="col-lg-9">
                    <div class="banner-area pb-30">
                        <a href="product-details.html"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                    </div>

                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                <!-- start si type categorie == bar-->
                                @if ($categorieSelect->type == 'bar')
                                    @foreach ($produits as $produit)
                                        @foreach ($produit->achats as $item)
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img position-relative">
                                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}">
                                                        </a>
                                                        <!-- Sticker de catégorie -->
                                                        <span
                                                            class="category-sticker">{{ $produit->categorie->name }}</span>

                                                        {{-- <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a class="btn btn-danger text-white" title="Add To Cart"
                                                                    href="#">
                                                                    <i class="ion-android-cart text-white"></i>
                                                                    Je
                                                                    commande
                                                                </a>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                    <div class="product-content">
                                                        <h4>
                                                            <a href="product-details.html"> {{ $produit->nom }} </a>
                                                        </h4>
                                                        <div class="product-price-wrapper">
                                                            <span>{{ $item->prix_vente_unitaire }} FCFA</span>
                                                            {{-- <span class="product-price-old">$120.00 </span> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                @endif
                                <!-- end si type categorie == bar-->



                                <!-- start si type categorie != bar-->
                                @if ($categorieSelect->type != 'bar')
                                    @foreach ($produits as $produit)
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                 <div class="product-img position-relative">
                                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}">
                                                        </a>
                                                        <!-- Sticker de catégorie -->
                                                        <span
                                                            class="category-sticker">{{ $produit->categorie->name }}</span>

                                                        {{-- <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a class="btn btn-danger text-white" title="Add To Cart"
                                                                    href="#">
                                                                    <i class="ion-android-cart text-white"></i>
                                                                    Je
                                                                    commande
                                                                </a>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a href="product-details.html"> {{ $produit->nom }} </a>
                                                    </h4>
                                                    <div class="product-price-wrapper">
                                                        <span>{{ $produit->prix }} FCFA</span>
                                                        {{-- <span class="product-price-old">$120.00 </span> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                <!-- end si type categorie != bar-->
                            </div>
                        </div>
                        <div class="pagination-total-pages">
                            <div class="pagination-style">
                                <ul>
                                    <li><a class="prev-next prev" href="#"><i class="ion-ios-arrow-left"></i> Prev</a>
                                    </li>
                                    <li><a class="active" href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">3</a></li>
                                    <li><a href="#">...</a></li>
                                    <li><a href="#">10</a></li>
                                    <li><a class="prev-next next" href="#">Next<i class="ion-ios-arrow-right"></i>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="total-pages">
                                <p>Showing 1 - 20 of 30 results </p>
                            </div>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
@endsection
