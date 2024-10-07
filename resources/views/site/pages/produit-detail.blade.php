@extends('site.layouts.app')

@section('title', 'Produit detail /' . $produit->nom)

@section('content')

    <div class="product-details pt-100 pb-90">
        <div class="container">


            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="product-images-slider position-relative">
                        <div class="main-image-container">
                            <img id="mainImage" src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="Image principale"
                                class="product-image" width="570" height="470">
                        </div>

                        <div class="thumbnail-slider">
                            <div class="thumbnails-container d-flex">
                                <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="Image principale"
                                    class="thumbnail active"
                                    onclick="changeImage('{{ $produit->getFirstMediaUrl('ProduitImage') }}')" width="100"
                                    height="100">

                                @foreach ($produit->getMedia('galleryProduit') as $media)
                                    <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}"
                                        class="thumbnail" onclick="changeImage('{{ $media->getUrl() }}')" width="100"
                                        height="100">
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h4>{{ $produit->nom }} </h4>

                        <span id="price"
                            data-price={{ $produit->achats->isNotEmpty() ? $produit->achats[0]->prix_vente_unitaire : $produit->prix }}>
                            {{ $produit->achats->isNotEmpty() ? $produit->achats[0]->prix_vente_unitaire : $produit->prix }}
                            FCFA </span>

                        @if ($produit->achats->isNotEmpty())
                            <div class="in-stock">
                                <p>En stock: <span>
                                        {{ $produit->achats->isNotEmpty() ? $produit->achats[0]->quantite_stocke : '' }}
                                    </span></p>
                            </div>
                        @endif

                        <p> {!! $produit->description !!} </p>

                        <div class="pro-details-cart-wrap d-flex">

                            <div class="product-quantity">
                                <div class="cart-plus-minus">
                                    <input id="quantity" class="cart-plus-minus-box" type="text" name="quantity"
                                        value="1" readonly>
                                </div>
                            </div>
                            <div class="shop-list-cart-wishlist mx-3">
                                <a title="Ajouter au panier" href="#" class="addCart" data-id="{{ $produit->id }}">
                                    <i class="ion-android-cart"></i>
                                </a>

                            </div>

                        </div>
                        <div class="pro-dec-categories">
                            <ul>
                                <li class="categories-title">Categories:</li>
                                <li><a href="#">{{ $produit->categorie->getPrincipalCategory()->name }} ,</a></li>
                                <li><a href="#"> {{ $produit->categorie->name }} </a></li>

                            </ul>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-100">
        <div class="container">
            <div class="description-review-wrapper">
                <div class="description-review-topbar nav text-center">
                    <a class="active" data-bs-toggle="tab" href="#des-details1">Description</a>
                    {{-- <a data-bs-toggle="tab" href="#des-details2">Tags</a>
                        <a data-bs-toggle="tab" href="#des-details3">Review</a> --}}
                </div>
                <div class="tab-content description-review-bottom">
                    <div id="des-details1" class="tab-pane active">
                        <div class="product-description-wrapper">
                            {!! $produit->description !!}
                        </div>
                    </div>
                    <div id="des-details2" class="tab-pane">
                        <div class="product-anotherinfo-wrapper">
                            <ul>
                                <li><span>Tags:</span></li>
                                <li><a href="#"> All,</a></li>
                                <li><a href="#"> Cheesy,</a></li>
                                <li><a href="#"> Fast Food,</a></li>
                                <li><a href="#"> French Fries,</a></li>
                                <li><a href="#"> Hamburger,</a></li>
                                <li><a href="#"> Pizza</a></li>
                            </ul>
                        </div>
                    </div>
                    <div id="des-details3" class="tab-pane">
                        <div class="rattings-wrapper">
                            <div class="sin-rattings">
                                <div class="star-author-all">
                                    <div class="ratting-star f-left">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3>tayeb rayed</h3>
                                        <span>12:24</span>
                                        <span>9 March 2022</span>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor
                                    sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                            </div>
                            <div class="sin-rattings">
                                <div class="star-author-all">
                                    <div class="ratting-star f-left">
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <i class="ion-star theme-color"></i>
                                        <span>(5)</span>
                                    </div>
                                    <div class="ratting-author f-right">
                                        <h3>farhana shuvo</h3>
                                        <span>12:24</span>
                                        <span>9 March 2022</span>
                                    </div>
                                </div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Utenim ad minim veniam, quis nost rud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor
                                    sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                                    dolore magna aliqua. Utenim ad minim veniam, quis nost.</p>
                            </div>
                        </div>
                        <div class="ratting-form-wrapper">
                            <h3>Add your Comments :</h3>
                            <div class="ratting-form">
                                <form action="#">
                                    <div class="star-box">
                                        <h2>Rating:</h2>
                                        <div class="ratting-star">
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star theme-color"></i>
                                            <i class="ion-star"></i>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="rating-form-style mb-20">
                                                <input placeholder="Name" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="rating-form-style mb-20">
                                                <input placeholder="Email" type="text">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="rating-form-style form-submit">
                                                <textarea name="message" placeholder="Message"></textarea>
                                                <input type="submit" value="add review">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="product-area pb-95">
            <div class="container">
                <div class="product-top-bar section-border mb-25">
                    <div class="section-title-wrap">
                        <h3 class="section-title section-bg-white">Related Products</h3>
                    </div>
                </div>
                <div class="related-product-active owl-carousel product-nav">
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img src="assets/img/product/product-1.jpg" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Add Tto Cart" href="#"><i class="ion-android-cart"></i> Add Tto Cart</a>
                                </div>
                                <div class="pro-action-right">
                                    <a title="Wishlist" href="wishlist.html"><i class="ion-ios-heart-outline"></i></a>
                                    <a title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="ion-android-open"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html">PRODUCTS NAME HERE </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>$100.00</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img src="assets/img/product/product-2.jpg" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Add Tto Cart" href="#"><i class="ion-android-cart"></i> Add Tto Cart</a>
                                </div>
                                <div class="pro-action-right">
                                    <a title="Wishlist" href="wishlist.html"><i class="ion-ios-heart-outline"></i></a>
                                    <a title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="ion-android-open"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html">PRODUCTS NAME HERE </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>$200.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img src="assets/img/product/product-3.jpg" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Add Tto Cart" href="#"><i class="ion-android-cart"></i> Add Tto Cart</a>
                                </div>
                                <div class="pro-action-right">
                                    <a title="Wishlist" href="wishlist.html"><i class="ion-ios-heart-outline"></i></a>
                                    <a title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="ion-android-open"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html">PRODUCTS NAME HERE </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>$90.00</span>
                                <span class="product-price-old">$100.00 </span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img src="assets/img/product/product-4.jpg" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Add Tto Cart" href="#"><i class="ion-android-cart"></i> Add Tto Cart</a>
                                </div>
                                <div class="pro-action-right">
                                    <a title="Wishlist" href="wishlist.html"><i class="ion-ios-heart-outline"></i></a>
                                    <a title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="ion-android-open"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html">PRODUCTS NAME HERE </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>$50.00</span>
                            </div>
                        </div>
                    </div>
                    <div class="product-wrapper">
                        <div class="product-img">
                            <a href="product-details.html">
                                <img src="assets/img/product/product-7.jpg" alt="">
                            </a>
                            <div class="product-action">
                                <div class="pro-action-left">
                                    <a title="Add Tto Cart" href="#"><i class="ion-android-cart"></i> Add Tto Cart</a>
                                </div>
                                <div class="pro-action-right">
                                    <a title="Wishlist" href="wishlist.html"><i class="ion-ios-heart-outline"></i></a>
                                    <a title="Quick View" data-bs-toggle="modal" data-bs-target="#exampleModal" href="#"><i class="ion-android-open"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="product-content">
                            <h4>
                                <a href="product-details.html">PRODUCTS NAME HERE </a>
                            </h4>
                            <div class="product-price-wrapper">
                                <span>$100.00</span>
                                <span class="product-price-old">$120.00 </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}



    @include('site.components.ajouter-au-panier')

    <script>
        var CartPlusMinus = $('.cart-plus-minus');

        // Ajouter les boutons - et +
        CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
        CartPlusMinus.append('<div class="inc qtybutton">+</div>');

        // Gestion de l'incrémentation et de la décrémentation
        $(".qtybutton").on("click", function() {
            var $button = $(this);
            var $input = $button.parent().find("input");
            var oldValue = parseFloat($input.val());
            var maxQuantity =
            {{ $produit->achats->isNotEmpty() ? $produit->stock : 0 }}; // S'assurer que maxQuantity est bien défini

            // Incrémentation
            if ($button.text() === "+") {
                var newVal = oldValue + 1;
                if ('{{ $produit->categorie->famille }}' === 'bar') {
                    if (newVal > maxQuantity) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Attention',
                            text: 'La quantité demandée dépasse le stock disponible.',
                            confirmButtonText: 'OK'
                        });
                        newVal = maxQuantity;
                        $('.addCart').prop('disabled', true); // Désactiver le bouton si max atteint
                    } else {
                        $('.addCart').prop('disabled', false); // Activer le bouton si la quantité est valide
                    }
                }
            }
            // Décrémentation
            else {
                if (oldValue > 1) {
                    var newVal = oldValue - 1;
                } else {
                    newVal = 1; // Ne pas aller en dessous de 1
                }
                $('.addCart').prop('disabled', false); // Activer le bouton si la quantité est valide
            }

            // Mettre à jour la valeur de l'input
            $input.val(newVal);
        });



        $(document).ready(function() {
            $(".thumbnail-carousel").owlCarousel({
                items: 4, // Nombre de miniatures visibles
                margin: 10,
                loop: true,
                nav: false,
                dots: false,
                responsive: {
                    0: {
                        items: 2
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });
        });

        function changeImage(imageSrc) {
            document.getElementById("mainImage").src = imageSrc;
        }
    </script>


@endsection
