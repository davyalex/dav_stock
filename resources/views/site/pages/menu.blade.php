@extends('site.layouts.app')

@section('title', 'Liste du menu')

@section('content')
    <div class="shop-page-area pt-10 pb-100">
        <div class="container">
            <div class="row flex-row">
                <!-- start sidebar categorie-->
                <div class="col-lg-3">
                    <div class="shop-sidebar-wrapper gray-bg-7 shop-sidebar-mrg">
                        <div class="shop-widget">
                            <h4 class="shop-sidebar-title"> {{ $menu->libelle }} </h4>
                            <div class="shop-catigory">
                                {{-- @include('site.sections.categorie.categoriemenu', [
                                    'categories' => $categories,
                                    'categorieSelect' => $categorieSelect,
                                ]) --}}

                                @include('site.sections.categorie.categoriemenu')

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
                                <!-- start produits menu-->

                               
                                @foreach ($menu->produits as $produit)
                                    @if ($produit->categorie->getPrincipalCategory()->type == 'boissons')
                                        @foreach ($produit->achats as $achat)
                                            <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                                <div class="product-wrapper">
                                                    <div class="product-img">
                                                        <a href="product-de tails.html">
                                                            <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                                alt="">
                                                        </a>
                                                        <div class="product-action">
                                                            <div class="pro-action-left">
                                                                <a title="Add Tto Cart" href="#"
                                                                    class="btn btn-danger text-white"><i
                                                                        class="ion-android-cart"></i>Je commande</a>
                                                            </div>
                                                            <div class="pro-action-right">
                                                                <a title="Wishlist" href="wishlist.html"><i
                                                                        class="ion-ios-heart-outline"></i></a>
                                                                <a title="Quick View" data-bs-toggle="modal"
                                                                    data-bs-target="#exampleModal" href="#"><i
                                                                        class="ion-android-open"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content">
                                                        <h4>
                                                            <a href="product-details.html"> {{ $produit->nom }} </a>
                                                        </h4>
                                                        <div class="product-price-wrapper">
                                                            <span>{{$achat->prix_vente_unitaire }} FCFA</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach





                                    @else
                                        <div class="product-width col-xl-4 col-lg-4 col-md-4 col-sm-6 col-12 mb-30">
                                            <div class="product-wrapper">
                                                <div class="product-img">
                                                    <a href="product-details.html">
                                                        <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}"
                                                            alt="">
                                                    </a>
                                                    <div class="product-action">
                                                        <div class="pro-action-left">
                                                            <a title="Add Tto Cart" href="#"
                                                                class="btn btn-danger text-white"><i
                                                                    class="ion-android-cart"></i>Je commande</a>
                                                        </div>
                                                        <div class="pro-action-right">
                                                            <a title="Wishlist" href="wishlist.html"><i
                                                                    class="ion-ios-heart-outline"></i></a>
                                                            <a title="Quick View" data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal" href="#"><i
                                                                    class="ion-android-open"></i></a>
                                                        </div>
                                                    </div>
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
                                    @endif
                                @endforeach
                                <!-- end produits menu-->

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
