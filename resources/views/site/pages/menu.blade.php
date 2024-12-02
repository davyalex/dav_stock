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
                        <div class="col-sm-6 col-md-8 col-lg-8 col-xl-8 mb-4">
                            <div class="card shadow">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="m-0 text-white">{{ $categorie }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($plats as $platKey => $plat)
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <!-- Case à cocher pour le plat -->

                                                        <div class="d-flex justify-content-between mt-2">


                                                            <div class="form-check ">
                                                                <input type="checkbox" id="plat_{{ $plat->id }}"
                                                                    class="form-check-input plat-checkbox" name="plats[]"
                                                                    value="{{ $plat->id }}">
                                                                <label for="plat_{{ $plat->id }}"
                                                                    class="form-check-label fw-bold text-capitalize fs-6">
                                                                    {{ $plat->nom }}
                                                                </label>
                                                            </div>

                                                            <strong class="price" data-price="{{$plat->prix}}" class="text-danger">
                                                                {{ number_format($plat->prix, 0, ',', ' ') }} FCFA
                                                            </strong>
                                                        </div>


                                                        <div class="row ">
                                                            <div class="col-6">
                                                                <!-- Compléments -->
                                                                @if ($plat->complements->isNotEmpty())
                                                                    <p class="card-text fw-bold mt-3">Choisir un complément
                                                                        :
                                                                    </p>
                                                                    <form class="complement-form">
                                                                        @foreach ($plat->complements as $complementKey => $complement)
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    id="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    name="complement_{{ $platKey }}"
                                                                                    class="form-check-input complement-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $complement->id }}">
                                                                                <label
                                                                                    for="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $complement->nom }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </form>
                                                                @endif

                                                            </div>

                                                            <div class="col-6">
                                                                <!-- Garnitures -->
                                                                @if ($plat->garnitures->isNotEmpty())
                                                                    <p class="card-text fw-bold mt-3">Choisir une garniture
                                                                        :
                                                                    </p>
                                                                    <form class="garniture-form">
                                                                        @foreach ($plat->garnitures as $garnitureKey => $garniture)
                                                                            <div class="form-check">
                                                                                <input type="radio"
                                                                                    id="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    name="garniture_{{ $platKey }}"
                                                                                    class="form-check-input garniture-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $garniture->id }}">
                                                                                <label
                                                                                    for="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $garniture->nom }}
                                                                                </label>
                                                                            </div>
                                                                        @endforeach
                                                                    </form>
                                                                @endif
                                                            </div>

                                                            <style>
                                                                .dec,
                                                                .inc,
                                                                .cart-plus-minus-box {
                                                                    border: none;
                                                                    background-color: rgb(255, 254, 254);

                                                                }
                                                            </style>



                                                            <div class="product-quantity mb-0"
                                                                data-product-id="{{ $plat->id }}">
                                                                <div class="cart-plus-minus " style="float:right">
                                                                    <div class="dec qtybutton"
                                                                        onclick="decreaseValue(this)">-
                                                                    </div>
                                                                    <input id="quantity" class="cart-plus-minus-box"
                                                                        type="text" name="quantity" value="1"
                                                                        min="1" readonly>
                                                                    <div class="inc qtybutton"
                                                                        onclick="increaseValue(this)">+
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="card-footer text-end d-none  py-0">
                                                        <div class="d-flex justify-content-between align-items-center">

                                                            <!-- Gestion de la quantité -->
                                                            <div class="product-quantity py-4"
                                                                data-product-id="{{ $plat->id }}">
                                                                <div class="cart-plus-minus">
                                                                    <div class="dec qtybutton"
                                                                        onclick="decreaseValue(this)">-
                                                                    </div>
                                                                    <input id="quantity" class="cart-plus-minus-box"
                                                                        type="text" name="quantity" value="1"
                                                                        min="1" readonly>
                                                                    <div class="inc qtybutton"
                                                                        onclick="increaseValue(this)">+
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            {{-- <div class="d-flex justify-content-between mt-2">
                                                            <strong id="price" class="text-danger">
                                                                {{ number_format($plat->prix, 0, ',', ' ') }} FCFA
                                                            </strong>
                                                        </div> --}}

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

                    <div class="col-4">
                        <div>
                            @if ($menu && $menu->hasMedia('images'))
                                <img src="{{ $menu->getFirstMediaUrl('images') }}" alt="Menu Image" class="img-fluid "
                                    style="margin-top: -300px">
                            @endif
                        </div>
                    </div>




                </div>


                <button type="button" class="btn btn-danger addCart text-white w-100" data-id="{{ $plat->id }}"
                    data-price="{{ $plat->prix }}" style="border-radius: 5px; font-size: 20px;">
                    <i class="fa fa-shopping-cart"></i> Commander
                </button>





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


            document.addEventListener('DOMContentLoaded', function() {
                // Fonction pour cocher la case du plat
                function checkPlat(checkbox) {
                    const platId = checkbox.getAttribute('data-plat-id');
                    const platCheckbox = document.getElementById(`plat_${platId}`);

                    if (platCheckbox) {
                        platCheckbox.checked = true; // Coche la case du plat
                    }
                }

                // Fonction pour décocher les garnitures et compléments associés
                function uncheckPlatSelections(platId) {
                    // Décoche tous les compléments associés à ce plat
                    const complementCheckboxes = document.querySelectorAll(
                        `.complement-checkbox[data-plat-id="${platId}"]`);
                    complementCheckboxes.forEach(function(complementCheckbox) {
                        complementCheckbox.checked = false;
                    });

                    // Décoche toutes les garnitures associées à ce plat
                    const garnitureCheckboxes = document.querySelectorAll(
                        `.garniture-checkbox[data-plat-id="${platId}"]`);
                    garnitureCheckboxes.forEach(function(garnitureCheckbox) {
                        garnitureCheckbox.checked = false;
                    });
                }

                // Ajoute un événement de sélection aux compléments
                const complementCheckboxes = document.querySelectorAll('.complement-checkbox');
                complementCheckboxes.forEach(function(complementCheckbox) {
                    complementCheckbox.addEventListener('change', function() {
                        checkPlat(this); // Coche la case du plat lors de la sélection du complément
                    });
                });

                // Ajoute un événement de sélection aux garnitures
                const garnitureCheckboxes = document.querySelectorAll('.garniture-checkbox');
                garnitureCheckboxes.forEach(function(garnitureCheckbox) {
                    garnitureCheckbox.addEventListener('change', function() {
                        checkPlat(this); // Coche la case du plat lors de la sélection de la garniture
                    });
                });

                // Ajoute un événement de décochement à la case du plat
                const platCheckboxes = document.querySelectorAll('.plat-checkbox');
                platCheckboxes.forEach(function(platCheckbox) {
                    platCheckbox.addEventListener('change', function() {
                        const platId = platCheckbox.value; // Récupère l'ID du plat
                        if (!platCheckbox.checked) {
                            uncheckPlatSelections(
                                platId
                            ); // Si la case du plat est décochée, on décocher les garnitures et compléments associés
                        }
                    });
                });
            });
        </script>



    </div>
@endsection
