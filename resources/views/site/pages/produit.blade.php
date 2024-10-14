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
                        <a href="#"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                    </div>

                    <div class="grid-list-product-wrapper">
                        <div class="product-grid product-view pb-20">
                            <div class="row">
                                <!-- start si type categorie == bar-->
                                @if ($categorieSelect->famille == 'bar')
                                    @foreach ($produits as $produit)
                                        @foreach ($produit->achats as $item)
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img position-relative">
                                                        <a href="{{ route('produit.detail', $produit->slug) }}">
                                                            <div class="image-container"
                                                                style="width: 326px; height: 326px; overflow: hidden;">
                                                                <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                    alt="{{ $produit->nom }}"
                                                                    style="width: 100%; height: 100%; object-fit: contain;">
                                                            </div>
                                                        </a>
                                                        <span
                                                            class="category-sticker">{{ $produit->categorie->name }}</span>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4>
                                                            <a href="#"> {{ $produit->nom }} </a>
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
                                @if ($categorieSelect->famille != 'bar')
                                    @foreach ($produits as $produit)
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                <div class="product-img position-relative">
                                                    <a href="{{ route('produit.detail', $produit->slug) }}">
                                                        <div class="image-container"
                                                            style="width: 326px; height: 326px; overflow: hidden;">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="{{ $produit->nom }}"
                                                                style="width: 100%; height: 100%; object-fit: contain;">
                                                        </div>
                                                    </a>
                                                    <!-- Sticker de catégorie -->
                                                    <span class="category-sticker">{{ $produit->categorie->name }}</span>

                                                </div>
                                                <div class="product-content">
                                                    <h4>
                                                        <a href="#"> {{ $produit->nom }} </a>
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
                            <nav aria-label="Navigation des pages">
                                {{ $produits->links('pagination::bootstrap-5') }}
                            </nav>
                            <div class="text-center mt-3">
                                <p class="text-muted">
                                    Affichage de {{ $produits->firstItem() }} - {{ $produits->lastItem() }} sur
                                    {{ $produits->total() }} résultats
                                </p>
                            </div>
                        </div>

                    </div>
                </div>






            </div>
        </div>
    </div>
@endsection
