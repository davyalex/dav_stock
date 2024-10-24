@extends('site.layouts.app')

@section('title', 'Produit detail /' . $produit->nom)

@section('content')

    <style>
        .addCart {
            display: flex;
            /* Pour aligner l'icône et le texte horizontalement */
            align-items: center;
            font-size: 16px;
            color: #333;
            /* Ajuste la couleur selon tes préférences */
            text-decoration: none;
        }

        .addCart i {
            margin-right: 8px;
            /* Espace entre l'icône et le texte */
            font-size: 20px;
            /* Taille de l'icône */
        }

        .addCart:hover {
            color: #ff0000;
            /* Couleur au survol */
        }


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

    <div class="product-details pt-100 pb-90">
        <div class="container">


            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <div class="product-images-slider position-relative">
                        <div class="main-image-container ratio ratio-4x3">
                            <img id="mainImage" src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="Image principale"
                                class="product-image img-fluid w-100 h-100 object-fit-cover">
                        </div>

                        <div class="thumbnail-slider mt-3">
                            <div class="thumbnails-container d-flex flex-wrap justify-content-start">
                                <div class="thumbnail-wrapper ratio ratio-1x1 m-1" style="width: 80px;">
                                    <img src="{{ $produit->getFirstMediaUrl('ProduitImage') }}" alt="Image principale"
                                        class="thumbnail active img-fluid w-100 h-100 object-fit-cover"
                                        onclick="changeImage('{{ $produit->getFirstMediaUrl('ProduitImage') }}')">
                                </div>

                                @foreach ($produit->getMedia('galleryProduit') as $media)
                                    <div class="thumbnail-wrapper ratio ratio-1x1 m-1" style="width: 80px;">
                                        <img src="{{ $media->getUrl() }}" alt="{{ $media->name }}"
                                            class="thumbnail img-fluid w-100 h-100 object-fit-cover"
                                            onclick="changeImage('{{ $media->getUrl() }}')">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="product-details-content">
                        <h4 class="text-uppercase">{{ $produit->nom }} </h4>

                        <span id="price" data-price={{ $produit->prix }}>
                            {{ $produit->prix }}
                            FCFA </span>

                        {{-- @if ($produit->achats->isNotEmpty())
                            <div class="in-stock">
                                <p>En stock: <span>
                                        {{ $produit->achats->isNotEmpty() ? $produit->achats[0]->quantite_stocke : '' }}
                                    </span></p>
                            </div>
                        @endif --}}

                        <p> {!! $produit->description !!} </p>

                        @if ($produit->stock == 0 && $produit->categorie->famille == 'bar')
                            <span class="text-danger fw-bold">Rupture de stock</span>
                        @else
                            <div class="pro-details-cart-wrap d-flex">
                                <div class="product-quantity">
                                    <div class="cart-plus-minus">
                                        <input id="quantity" class="cart-plus-minus-box" type="text" name="quantity"
                                            value="1" readonly>
                                    </div>
                                </div>

                                <div class="mx-3">
                                    <button type="button" class="btn btn-danger addCart text-white"
                                        data-id="{{ $produit->id }}"
                                        style="padding-top:18px; padding-bottom:20px ; border-radius: 10px">
                                        Ajouter au panier
                                    </button>
                                </div>
                            </div>
                        @endif
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


    @if ($produit->description)
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
    @endif
    
    <div class="product-area pb-95">
        @if ($produitsRelateds->count() > 0)

            <div class="container">
                <div class="product-top-bar section-border mb-25">
                    <div class="section-title-wrap">
                        <h3 class="section-title section-bg-white">Produits similaires</h3>
                    </div>
                </div>
                <div class="related-product-active owl-carousel product-nav">
                  @foreach ($produitsRelateds as $produit)
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
                            <a href="#"> {{ $produit->nom }} </a>
                        </h4>
                        <div class="product-price-wrapper">
                            <span>{{ $produit->prix }} FCFA</span>
                            {{-- <span class="product-price-old">$120.00 </span> --}}
                        </div>
                    </div>
                </div>
                  @endforeach

                </div>
            </div>
        @endif

    </div>



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
