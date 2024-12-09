@extends('site.layouts.app')

@section('title', 'Liste du menu')

@section('content')

    {{-- <style>
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
    </style> --}}


@section('content')
    <style>
        .menu-image {
            max-width: 100%;
            /* Adapte l'image à la largeur de la colonne */
            height: auto;
            /* Garde les proportions */
            border-radius: 8px;
            /* Ajoute des coins arrondis (optionnel) */


        }

        .product-quantity {
            width: 50px;
        }
    </style>

    <div class="shop-page-area pt-10 pb-100">
        <div class="container-fluid">
            @if (!$menu)
                <p class="text-center">Aucun menu disponible pour aujourd'hui.</p>
            @else
                <h1 class="text-center my-4">Menu du <span>{{ \Carbon\Carbon::parse($menu->date)->format('d/m/Y') }}</span>
                </h1>
                <div class="d-flex mt-4 ol-sm-12 col-md-12 col-lg-12 col-xl-12 m-auto">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-8">
                        @foreach ($categories as $categorie => $plats)
                            <div class="card shadow col-12 ">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="m-0 text-white">{{ $categorie }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($plats as $platKey => $plat)
                                            <div class="col-md-6 mb-3 ">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <div class="form-check">
                                                                <input type="checkbox" id="plat_{{ $plat->id }}"
                                                                    class="form-check-input plat-checkbox" name="plats[]"
                                                                    value="{{ $plat->id }}">
                                                                <label for="plat_{{ $plat->id }}"
                                                                    class="form-check-label fw-bold text-capitalize fs-6">
                                                                    {{ $plat->nom }}
                                                                </label>

                                                                <div class="product-quantity mb-0"
                                                                    data-product-id="{{ $plat->id }}">
                                                                    <div class="cart-plus-minus">
                                                                        <div class="dec qtybutton"
                                                                            onclick="decreaseValue(this)">-
                                                                        </div>
                                                                        <input id="quantity"
                                                                            class="cart-plus-minus-box text-danger"
                                                                            type="text" name="quantity" value="1"
                                                                            min="1" readonly>
                                                                        <div class="inc qtybutton"
                                                                            onclick="increaseValue(this)">+
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <strong class="price" data-price="{{ $plat->prix }}"
                                                                class="text-danger">
                                                                {{ number_format($plat->prix, 0, ',', ' ') }} FCFA
                                                            </strong>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                @if ($plat->complements->isNotEmpty())
                                                                    <p class="card-text fw-bold mt-3">Choisir des
                                                                        compléments :</p>
                                                                    <form class="complement-form">
                                                                        @foreach ($plat->complements as $complementKey => $complement)
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    id="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    name="complements_{{ $platKey }}[]"
                                                                                    class="form-check-input complement-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $complement->id }}">
                                                                                <label
                                                                                    for="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $complement->nom }}
                                                                                </label>

                                                                                <div class="product-quantity mb-0"
                                                                                    data-product-id="{{ $plat->id }}">
                                                                                    <div class="cart-plus-minus">
                                                                                        <div class="dec qtybutton"
                                                                                            onclick="decreaseValue(this)">-
                                                                                        </div>
                                                                                        <input id="quantity"
                                                                                            class="cart-plus-minus-box text-danger"
                                                                                            type="text" name="quantity"
                                                                                            value="1" min="1"
                                                                                            readonly>
                                                                                        <div class="inc qtybutton"
                                                                                            onclick="increaseValue(this)">+
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </form>
                                                                @endif
                                                            </div>
                                                            <div class="col-6">
                                                                @if ($plat->garnitures->isNotEmpty())
                                                                    <p class="card-text fw-bold mt-3">Choisir des garnitures
                                                                        :</p>
                                                                    <form class="garniture-form">
                                                                        @foreach ($plat->garnitures as $garnitureKey => $garniture)
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    id="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    name="garnitures_{{ $platKey }}[]"
                                                                                    class="form-check-input garniture-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $garniture->id }}">
                                                                                <label
                                                                                    for="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $garniture->nom }}
                                                                                </label>

                                                                                <div class="product-quantity mb-0"
                                                                                    data-product-id="{{ $plat->id }}">
                                                                                    <div class="cart-plus-minus">
                                                                                        <div class="dec qtybutton"
                                                                                            onclick="decreaseValue(this)">-
                                                                                        </div>
                                                                                        <input id="quantity"
                                                                                            class="cart-plus-minus-box text-danger"
                                                                                            type="text" name="quantity"
                                                                                            value="1" min="1"
                                                                                            readonly>
                                                                                        <div class="inc qtybutton"
                                                                                            onclick="increaseValue(this)">+
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        {{-- <div class="product-quantity mb-0"
                                                            data-product-id="{{ $plat->id }}">
                                                            <div class="cart-plus-minus" style="float:right">
                                                                <div class="dec qtybutton" onclick="decreaseValue(this)">-
                                                                </div>
                                                                <input id="quantity" class="cart-plus-minus-box"
                                                                    type="text" name="quantity" value="1"
                                                                    min="1" readonly>
                                                                <div class="inc qtybutton" onclick="increaseValue(this)">+
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="image-container d-none d-lg-block d-md-block col-4">
                        @if ($menu && $menu->hasMedia('images'))
                            <img src="{{ $menu->getFirstMediaUrl('images') }}" alt="Menu Image"
                                class="img-fluid menu-image">
                        @endif
                    </div>
                </div>
                <button type="button" class="btn btn-danger addCart text-white w-100" data-id="{{ $plat->id }}"
                    data-price="{{ $plat->prix }}" style="border-radius: 5px; font-size: 20px;">
                    <i class="fa fa-shopping-cart"></i> Commander
                </button>
            @endif
        </div>
        @include('site.components.ajouter-au-panier-menu')
    </div>


    {{-- <script>
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
            // Coche automatiquement le plat si un complément ou une garniture est sélectionné
            function checkPlat(checkbox) {
                const platId = checkbox.getAttribute('data-plat-id');
                const platCheckbox = document.getElementById(`plat_${platId}`);
                if (platCheckbox) {
                    platCheckbox.checked = true;
                }
            }

            // Décoche les compléments et garnitures associés si un plat est décoché
            function uncheckPlatSelections(platId) {
                const complementCheckboxes = document.querySelectorAll(
                    `.complement-checkbox[data-plat-id="${platId}"]`);
                complementCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
                const garnitureCheckboxes = document.querySelectorAll(
                    `.garniture-checkbox[data-plat-id="${platId}"]`);
                garnitureCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                });
            }

            const complementCheckboxes = document.querySelectorAll('.complement-checkbox');
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    checkPlat(this);
                });
            });

            const garnitureCheckboxes = document.querySelectorAll('.garniture-checkbox');
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    checkPlat(this);
                });
            });

            const platCheckboxes = document.querySelectorAll('.plat-checkbox');
            platCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const platId = checkbox.value;
                    if (!checkbox.checked) {
                        uncheckPlatSelections(platId);
                    }
                });
            });
        });
    </script> --}}

    {{-- <script>
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        }

        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Coche automatiquement le plat si un complément ou une garniture est sélectionné
            function checkPlat(checkbox) {
                const platId = checkbox.getAttribute('data-plat-id');
                const platCheckbox = document.getElementById(`plat_${platId}`);
                if (platCheckbox) {
                    platCheckbox.checked = true;
                    toggleQuantityVisibility(platCheckbox, true);
                }
            }

            // Décoche les compléments et garnitures associés si un plat est décoché
            function uncheckPlatSelections(platId) {
                const complementCheckboxes = document.querySelectorAll(
                    `.complement-checkbox[data-plat-id="${platId}"]`
                );
                complementCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    toggleQuantityVisibility(checkbox, false);
                });

                const garnitureCheckboxes = document.querySelectorAll(
                    `.garniture-checkbox[data-plat-id="${platId}"]`
                );
                garnitureCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    toggleQuantityVisibility(checkbox, false);
                });
            }

            // Affiche ou masque l'input de quantité selon la sélection
            function toggleQuantityVisibility(checkbox, isVisible) {
                const parent = checkbox.closest(".form-check");
                const quantityWrapper = parent.querySelector(".product-quantity");
                if (quantityWrapper) {
                    quantityWrapper.style.display = isVisible ? "block" : "none";
                }
            }

            // Gestion des événements sur les compléments
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les garnitures
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les plats
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");
            platCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    const platId = checkbox.value;
                    toggleQuantityVisibility(checkbox, checkbox.checked);
                    if (!checkbox.checked) {
                        uncheckPlatSelections(platId);
                    }
                });
                // Masquer les quantités par défaut
                toggleQuantityVisibility(checkbox, false);
            });
        });
    </script> --}}


    <script>
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        }

        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Masque ou affiche le champ de quantité selon la sélection
            function toggleQuantityVisibility(checkbox, isVisible) {
                const parent = checkbox.closest(".form-check");
                const quantityWrapper = parent.querySelector(".product-quantity");
                if (quantityWrapper) {
                    quantityWrapper.style.display = isVisible ? "block" : "none";
                }
            }

            // Gère l'état des compléments et garnitures lorsque leur checkbox est cochée
            function checkPlat(checkbox) {
                const platId = checkbox.getAttribute('data-plat-id');
                const platCheckbox = document.getElementById(`plat_${platId}`);
                if (platCheckbox) {
                    platCheckbox.checked = true;
                    toggleQuantityVisibility(platCheckbox, true);
                }
            }

            // Décoche les compléments et garnitures associés si un plat est décoché
            function uncheckPlatSelections(platId) {
                const complementCheckboxes = document.querySelectorAll(
                    `.complement-checkbox[data-plat-id="${platId}"]`
                );
                complementCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    toggleQuantityVisibility(checkbox, false);
                });

                const garnitureCheckboxes = document.querySelectorAll(
                    `.garniture-checkbox[data-plat-id="${platId}"]`
                );
                garnitureCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = false;
                    toggleQuantityVisibility(checkbox, false);
                });
            }

            // Gestion des événements sur les compléments
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les garnitures
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les plats
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");
            platCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    const platId = checkbox.value;
                    toggleQuantityVisibility(checkbox, checkbox.checked);
                    if (!checkbox.checked) {
                        uncheckPlatSelections(platId);
                    }
                });
                // Masquer les quantités par défaut
                toggleQuantityVisibility(checkbox, false);
            });

            // Masquer toutes les quantités au chargement initial
            document.querySelectorAll(".product-quantity").forEach(function(quantityWrapper) {
                quantityWrapper.style.display = "none";
            });
        });
    </script>


@endsection
