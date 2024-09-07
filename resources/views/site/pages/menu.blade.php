@extends('site.layouts.app')

@section('title', 'Liste du menu')

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
                            <h4 class="shop-sidebar-title"> {{ $menu->libelle }} </h4>
                            <div class="shop-catigory">

                                <div class="shop-catigory">
                                    <ul id="faq">
                                        @foreach ($categories as $parentId => $categorieGroup)
                                            @php
                                                $parentCategory = \App\Models\Categorie::find($parentId);
                                            @endphp

                                            <li>
                                                <a data-bs-toggle="collapse" data-bs-parent="#faq"
                                                    href="#category-{{ $parentCategory->id }}">
                                                    {{ $parentCategory->name }}
                                                    <i class="ion-ios-arrow-down"></i>
                                                </a>
                                                <ul id="category-{{ $parentCategory->id }}"
                                                    class="panel-collapse collapse show">
                                                    @foreach ($categorieGroup as $categorie)
                                                        @include('site.sections.categorie.categoriemenu', [
                                                            'categorie' => $categorie,
                                                        ])
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>






                            </div>
                        </div>
                    </div>
                </div>
                <!-- end sidebar categorie-->
                <div class="col-lg-9">
                    <div class="banner-area pb-30">
                        <a href="product-details.html"><img alt="" src="assets/img/banner/banner-49.jpg"></a>
                    </div>

                    <div class="product-area pt-95 pb-70">
                        <div class="custom-container">
                            <div class="product-tab-list-wrap text-center mb-40 yellow-color">
                                <div class="product-tab-list nav">
                                    <!-- Onglet pour tous les produits -->
                                    <a class="active" href="#tab_all" data-bs-toggle="tab">
                                        <h4>Tous les produits</h4>
                                    </a>
                                    <!-- Onglets pour chaque catégorie principale -->
                                    @foreach ($produitsFiltres as $categoriePrincipale => $produits)
                                        <a href="#tab_{{ Str::slug($categoriePrincipale) }}" data-bs-toggle="tab">
                                            <h4>{{ $categoriePrincipale }}</h4>
                                        </a>
                                    @endforeach
                                </div>
                                <p>Typi non habent claritatem insitam est usus legentis in qui facit eorum claritatem.</p>
                            </div>

                            <div class="tab-content jump yellow-color">
                                <!-- Onglet Tous les produits -->
                                <div id="tab_all" class="tab-pane active">
                                    <div class="row">
                                        @foreach ($menu->produits as $produit)
                                            @if ($produit->categorie->getPrincipalCategory()->type == 'boissons')
                                                @foreach ($produit->achats as $achat)
                                                    <div class="col-4">
                                                        <div class="product-wrapper mb-25">
                                                            <div class="product-img position-relative">
                                                                <a href="{{ route('produit.detail', $produit->slug) }}">
                                                                    <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                        alt="{{ $produit->nom }}">
                                                                </a>
                                                                <!-- Sticker de catégorie -->
                                                                <span
                                                                    class="category-sticker">{{ $produit->categorie->name }}</span>

                                                                <div class="product-action">
                                                                    <div class="pro-action-left">
                                                                        <a class="btn btn-danger text-white"
                                                                            title="Add To Cart" href="#">
                                                                            <i class="ion-android-cart text-white"></i> Je
                                                                            commande
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-content">
                                                                <h4><a
                                                                        href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                                </h4>
                                                                <div class="product-price-wrapper">
                                                                    <span>${{ $achat->prix_achat_unitaire }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="col-4">
                                                    <div class="product-wrapper mb-25">
                                                        <div class="product-img position-relative">
                                                            <a href="{{ route('produit.detail', $produit->slug) }}">
                                                                <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                    alt="{{ $produit->nom }}">
                                                            </a>
                                                            <!-- Sticker de catégorie -->
                                                            <span
                                                                class="category-sticker">{{ $produit->categorie->name }}</span>

                                                            <div class="product-action">
                                                                <div class="pro-action-left">
                                                                    <a class="btn btn-danger text-white" title="Add To Cart"
                                                                        href="#">
                                                                        <i class="ion-android-cart text-white"></i> Je
                                                                        commande
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="product-content">
                                                            <h4>
                                                                <a
                                                                    href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                            </h4>
                                                            <div class="product-price-wrapper">
                                                                <span>${{ $produit->prix }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Onglets pour chaque catégorie principale -->
                                @foreach ($produitsFiltres as $categoriePrincipale => $produits)
                                    <div id="tab_{{ Str::slug($categoriePrincipale) }}" class="tab-pane">
                                        <div class="row">
                                            @foreach ($produits as $produit)
                                                @if ($produit->categorie->getPrincipalCategory()->type == 'boissons')
                                                    @foreach ($produit->achats as $achat)
                                                        <div class="col-5">
                                                            <div class="product-wrapper mb-25">
                                                                <div class="product-img">
                                                                    <a
                                                                        href="{{ route('produit.detail', $produit->slug) }}">
                                                                        <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                            alt="{{ $produit->nom }}">
                                                                    </a>
                                                                    <div class="product-action">
                                                                        <div class="pro-action-left">
                                                                            <a title="Add To Cart" href="#"><i
                                                                                    class="ion-android-cart"></i> Add To
                                                                                Cart</a>
                                                                        </div>
                                                                        <div class="pro-action-right">
                                                                            <a title="Wishlist" href="wishlist.html"><i
                                                                                    class="ion-ios-heart-outline"></i></a>
                                                                            <a title="Quick View" data-bs-toggle="modal"
                                                                                data-bs-target="#exampleModal"
                                                                                href="#">
                                                                                <i class="ion-android-open"></i>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="product-content">
                                                                    <h4><a
                                                                            href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                                    </h4>
                                                                    <div class="product-price-wrapper">
                                                                        <span>${{ $achat->prix_achat_unitaire }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="col-5">
                                                        <div class="product-wrapper mb-25">
                                                            <div class="product-img position-relative">
                                                                <a href="{{ route('produit.detail', $produit->slug) }}">
                                                                    <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                        alt="{{ $produit->nom }}">
                                                                </a>
                                                                <!-- Sticker de catégorie -->
                                                                <span
                                                                    class="category-sticker">{{ $produit->categorie->name }}</span>

                                                                <div class="product-action">
                                                                    <div class="pro-action-left">
                                                                        <a class="btn btn-danger text-white"
                                                                            title="Add To Cart" href="#">
                                                                            <i class="ion-android-cart text-white"></i> Je
                                                                            commande
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="product-content">
                                                                <h4><a
                                                                        href="{{ route('produit.detail', $produit->slug) }}">{{ $produit->nom }}</a>
                                                                </h4>
                                                                <div class="product-price-wrapper">
                                                                    <span>${{ $produit->prix }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>



                </div>






            </div>
        </div>
    </div>
@endsection
