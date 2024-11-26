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

        /* Couleur par défaut */
        .form-check-input {
            accent-color: black;
            /* Mettre la couleur par défaut en noir */
        }

        /* Couleur rouge lorsqu'un bouton radio est sélectionné */
        .form-check-input:checked {
            accent-color: red;
            /* Couleur rouge lorsqu'il est coché */
        }



        /*  Style for increment decrement*/

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            font-size: 16px;
        }

        button.btn {
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }

        button.btn:disabled {
            background-color: #ccc;
            cursor: not-allowed;
            opacity: 0.6;
        }
    </style>
    <div class="shop-page-area pt-10 pb-100">

    @section('content')
        <div class="container">

            @if (!$menu)
                <p class="text-center">Aucun menu disponible pour aujourd'hui.</p>
            @else
                <h1 class="text-center my-4">Menu du <span>{{ \Carbon\carbon::parse($menu->date)->format('d/m/Y') }}</span>
                </h1>

                <div class="row mt-4">
                    @foreach ($categories as $categorie => $plats)
                        <div class="col-12 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-danger text-white">
                                    <h3 class="m-0 text-white">{{ $categorie }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($plats as $plat)
                                            <div class="col-md-4 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between">
                                                            <h5 class="card-title text-capitalize">{{ $plat->nom }}</h5>
                                                            <strong id="price" 
                                                                class="text-danger">{{ number_format($plat->prix, 0, ',', ' ') }}
                                                                FCFA</strong>
                                                        </div>
                                                        <!-- Compléments -->
                                                        @if ($plat->complements->isNotEmpty())
                                                            <p class="card-text fw-bold">Choisissez un complément :</p>
                                                            <form class="complement-form">
                                                                <select id="complement"
                                                                    name="complement_{{ $plat->id }}"
                                                                    class="form-select">
                                                                    <option selected disabled value="">Choisir
                                                                    </option>
                                                                    @foreach ($plat->complements as $complement)
                                                                        <option value="{{ $complement->id }}">
                                                                            {{ $complement->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </form>
                                                        @endif


                                                        @if ($plat->garnitures->isNotEmpty())
                                                            <p class="card-text fw-bold">Choisissez une garniture :</p>
                                                            <form class="garniture-form">
                                                                <select id="garniture" name="garniture_{{ $plat->id }}"
                                                                    class="form-select">
                                                                    <option selected disabled value="">Choisir
                                                                    </option>
                                                                    @foreach ($plat->garnitures as $garniture)
                                                                        <option value="{{ $garniture->id }}">
                                                                            {{ $garniture->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </form>
                                                        @endif


                                                    </div>
                                                    <div class="card-footer text-end">
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <!-- Gestion de la quantité -->

                                                            <div class="product-quantity" data-product-id="1">
                                                                <div class="cart-plus-minus">
                                                                    <div class="dec qtybutton"
                                                                        onclick="decreaseValue(this)">-</div>
                                                                    <input id="quantity" class="cart-plus-minus-box" type="text"
                                                                        name="quantity" value="1" min="1"
                                                                        readonly>
                                                                    <div class="inc qtybutton"
                                                                        onclick="increaseValue(this)">+</div>
                                                                </div>
                                                            </div>

                                                            <button type="button" class="btn btn-danger addCart text-white"
                                                                data-id="{{ $plat->id }}" data-price={{ $plat->prix }} style="border-radius: 10px">
                                                                <i class="fa fa-shopping-cart"></i> Commander
                                                            </button>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @include('site.components.ajouter-au-panier-menu')


        <script>
            function increaseValue(button) {
                // Récupérer le parent le plus proche contenant le champ input
                const input = button.parentElement.querySelector(".cart-plus-minus-box");
                let currentValue = parseInt(input.value);
                input.value = currentValue + 1;
            }

            function decreaseValue(button) {
                // Récupérer le parent le plus proche contenant le champ input
                const input = button.parentElement.querySelector(".cart-plus-minus-box");
                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            }
        </script>



    </div>
@endsection
