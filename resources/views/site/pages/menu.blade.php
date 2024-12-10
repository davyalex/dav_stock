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
                                                                                    data-max-quantity="1"
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
                                                                                            onchange="updateAvailableSelections(this)"
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
                                                                                    data-max-quantity="1"
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
                                                                                            onchange="updateAvailableSelections(this)"
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
    </script> --}}

    {{-- 
    <script>
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            input.value = currentValue + 1;

            updateComplementGarnitureLimits(input);
        }

        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }

            updateComplementGarnitureLimits(input);
        }

        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox").value;
            const quantity = parseInt(input.value);

            // Update complements
            const complementCheckboxes = document.querySelectorAll(
                `.complement-checkbox[data-plat-id="${platId}"]`
            );
            manageSelectionLimits(complementCheckboxes, quantity);

            // Update garnitures
            const garnitureCheckboxes = document.querySelectorAll(
                `.garniture-checkbox[data-plat-id="${platId}"]`
            );
            manageSelectionLimits(garnitureCheckboxes, quantity);
        }

        function manageSelectionLimits(checkboxes, limit) {
            let selectedCount = 0;

            checkboxes.forEach((checkbox) => {
                checkbox.disabled = selectedCount >= limit && !checkbox.checked;

                checkbox.addEventListener("change", function() {
                    selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                    checkboxes.forEach((box) => {
                        box.disabled = selectedCount >= limit && !box.checked;
                    });
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
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
                const platId = checkbox.getAttribute("data-plat-id");
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
                    } else {
                        const input = checkbox.closest(".form-check").querySelector(
                            ".cart-plus-minus-box");
                        updateComplementGarnitureLimits(input);
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
    </script> --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            /**
             * Augmente la valeur de la quantité d'un plat.
             * @param {HTMLElement} button - Bouton d'augmentation.
             */
            function increaseValue(button) {
                const input = button.parentElement.querySelector(".cart-plus-minus-box");
                if (!input) return;

                let currentValue = parseInt(input.value, 10) || 0;
                input.value = currentValue + 1;

                updateComplementGarnitureLimits(input);
            }

            /**
             * Diminue la valeur de la quantité d'un plat.
             * @param {HTMLElement} button - Bouton de diminution.
             */
            function decreaseValue(button) {
                const input = button.parentElement.querySelector(".cart-plus-minus-box");
                if (!input) return;

                let currentValue = parseInt(input.value, 10) || 0;
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    updateComplementGarnitureLimits(input);
                }
            }

            /**
             * Met à jour les limites des compléments et garnitures.
             * @param {HTMLInputElement} input - Champ de quantité du plat.
             */
            function updateComplementGarnitureLimits(input) {
                const formCheck = input.closest(".form-check");
                if (!formCheck) return;

                const platId = formCheck.querySelector(".plat-checkbox")?.value;
                const quantity = parseInt(input.value, 10) || 0;

                if (!platId) return;

                // Mise à jour des limites pour les compléments
                const complementCheckboxes = document.querySelectorAll(
                    `.complement-checkbox[data-plat-id="${platId}"]`
                );
                manageComplementGarnitureSelection(complementCheckboxes, quantity);

                // Mise à jour des limites pour les garnitures
                const garnitureCheckboxes = document.querySelectorAll(
                    `.garniture-checkbox[data-plat-id="${platId}"]`
                );
                manageComplementGarnitureSelection(garnitureCheckboxes, quantity);
            }

            /**
             * Gère la sélection et les limites pour les compléments ou garnitures.
             * @param {NodeList} checkboxes - Liste des cases à cocher.
             * @param {number} limit - Quantité totale autorisée.
             */
            function manageComplementGarnitureSelection(checkboxes, limit) {
                let selectedTotal = 0;

                checkboxes.forEach((checkbox) => {
                    const associatedQuantity = checkbox.closest(".form-check").querySelector(
                        ".cart-plus-minus-box");

                    // Mise à jour de l'état des checkboxes en fonction du total sélectionné
                    checkbox.disabled = selectedTotal >= limit && !checkbox.checked;

                    checkbox.addEventListener("change", function() {
                        selectedTotal = 0;
                        checkboxes.forEach((box) => {
                            const quantityInput = box.closest(".form-check").querySelector(
                                ".cart-plus-minus-box");
                            const currentQuantity = parseInt(quantityInput?.value || 0, 10);

                            if (box.checked) {
                                selectedTotal += currentQuantity;
                            }
                        });

                        // Désactive les checkboxes si la limite est atteinte
                        checkboxes.forEach((box) => {
                            box.disabled = selectedTotal >= limit && !box.checked;
                        });
                    });

                    // Gestion des quantités associées
                    associatedQuantity?.addEventListener("change", function() {
                        const newQuantity = parseInt(this.value, 10) || 0;

                        selectedTotal = 0;
                        checkboxes.forEach((box) => {
                            const quantityInput = box.closest(".form-check").querySelector(
                                ".cart-plus-minus-box");
                            const currentQuantity = parseInt(quantityInput?.value || 0, 10);

                            if (box.checked) {
                                selectedTotal += currentQuantity;
                            }
                        });

                        // Désactive les checkboxes si la limite est atteinte
                        checkboxes.forEach((box) => {
                            box.disabled = selectedTotal >= limit && !box.checked;
                        });
                    });
                });
            }

            /**
             * Masque ou affiche la quantité associée à un plat.
             * @param {HTMLElement} checkbox - Checkbox du plat.
             * @param {boolean} isVisible - Affiche si true, sinon masque.
             */
            function toggleQuantityVisibility(checkbox, isVisible) {
                const parent = checkbox.closest(".form-check");
                const quantityWrapper = parent.querySelector(".product-quantity");
                if (quantityWrapper) {
                    quantityWrapper.style.display = isVisible ? "block" : "none";
                }
            }

            // Initialisation des événements
            document.querySelectorAll(".plat-checkbox").forEach((checkbox) => {
                checkbox.addEventListener("change", function() {
                    const platId = checkbox.value;
                    toggleQuantityVisibility(checkbox, checkbox.checked);

                    if (checkbox.checked) {
                        const input = checkbox.closest(".form-check").querySelector(
                            ".cart-plus-minus-box");
                        updateComplementGarnitureLimits(input);
                    }
                });

                // Masquer la quantité par défaut
                toggleQuantityVisibility(checkbox, false);
            });

            // Masquer toutes les quantités au chargement initial
            document.querySelectorAll(".product-quantity").forEach((quantityWrapper) => {
                quantityWrapper.style.display = "none";
            });
        });
    </script> --}}


    {{-- ############# 10-12-2024--16h23  ########### --}}

    {{-- <script>
                        // Fonction pour augmenter la quantité du plat
                        function increaseValue(button) {
                            const input = button.parentElement.querySelector(".cart-plus-minus-box");
                            let currentValue = parseInt(input.value, 10) || 0;
                            input.value = currentValue + 1;

                            updateComplementGarnitureLimits(input);
                        }

                        // Fonction pour diminuer la quantité du plat
                        function decreaseValue(button) {
                            const input = button.parentElement.querySelector(".cart-plus-minus-box");
                            let currentValue = parseInt(input.value, 10) || 0;
                            if (currentValue > 1) {
                                input.value = currentValue - 1;
                                updateComplementGarnitureLimits(input);
                            }
                        }

                        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
                        function updateComplementGarnitureLimits(input) {
                            const platId = input.closest(".form-check").querySelector(".plat-checkbox").value;
                            const quantity = parseInt(input.value);

                            // Mettre à jour les compléments
                            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
                            manageSelectionLimits(complementCheckboxes, quantity);

                            // Mettre à jour les garnitures
                            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
                            manageSelectionLimits(garnitureCheckboxes, quantity);
                        }

                        // Fonction pour gérer la limite de sélection des compléments et garnitures
                        function manageSelectionLimits(checkboxes, limit) {
                            let selectedCount = 0;

                            checkboxes.forEach((checkbox) => {
                                checkbox.disabled = selectedCount >= limit && !checkbox.checked;

                                checkbox.addEventListener("change", function() {
                                    selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                                    checkboxes.forEach((box) => {
                                        box.disabled = selectedCount >= limit && !box.checked;
                                    });
                                });
                            });
                        }

                        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
                        function toggleQuantityVisibility(checkbox, isVisible) {
                            const parent = checkbox.closest(".form-check");
                            const quantityWrapper = parent.querySelector(".product-quantity");
                            if (quantityWrapper) {
                                quantityWrapper.style.display = isVisible ? "block" : "none";
                            }
                        }

                        // Fonction pour vérifier si un plat est sélectionné et afficher la quantité
                        function checkPlat(checkbox) {
                            const platId = checkbox.getAttribute("data-plat-id");
                            const platCheckbox = document.getElementById(`plat_${platId}`);
                            if (platCheckbox) {
                                platCheckbox.checked = true;
                                toggleQuantityVisibility(platCheckbox, true);
                            }
                        }

                        // Fonction pour décocher les compléments et garnitures associés à un plat
                        function uncheckPlatSelections(platId) {
                            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
                            complementCheckboxes.forEach(function(checkbox) {
                                checkbox.checked = false;
                                toggleQuantityVisibility(checkbox, false);
                            });

                            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
                            garnitureCheckboxes.forEach(function(checkbox) {
                                checkbox.checked = false;
                                toggleQuantityVisibility(checkbox, false);
                            });
                        }

                        // Initialisation des événements lors du chargement du document
                        document.addEventListener("DOMContentLoaded", function() {
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
                                    } else {
                                        const input = checkbox.closest(".form-check").querySelector(
                                            ".cart-plus-minus-box");
                                        updateComplementGarnitureLimits(input);
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
                    </script> --}}


    {{-- ############# 10-12-2024--16h23  ########### --}}


    {{-- <script>
        // Fonction pour augmenter la quantité du plat
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;
            input.value = currentValue + 1;

            updateComplementGarnitureLimits(input);
        }

        // Fonction pour diminuer la quantité du plat
        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateComplementGarnitureLimits(input);
            }
        }

        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

            // Vérifier si platId est valide
            if (!platId) {
                console.error("Plat ID introuvable");
                return;
            }

            const quantity = parseInt(input.value, 10);

            // Mettre à jour les compléments
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            manageSelectionLimits(complementCheckboxes, quantity);

            // Mettre à jour les garnitures
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            manageSelectionLimits(garnitureCheckboxes, quantity);
        }

        // Fonction pour gérer la limite de sélection des compléments et garnitures
        function manageSelectionLimits(checkboxes, limit) {
            let selectedCount = 0;

            checkboxes.forEach((checkbox) => {
                checkbox.disabled = selectedCount >= limit && !checkbox.checked;

                checkbox.addEventListener("change", function() {
                    selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                    checkboxes.forEach((box) => {
                        box.disabled = selectedCount >= limit && !box.checked;
                    });
                });
            });
        }

        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";
            }
        }

        // Fonction pour vérifier si un plat est sélectionné et afficher la quantité
        function checkPlat(checkbox) {
            const platId = checkbox.getAttribute("data-plat-id");
            const platCheckbox = document.getElementById(`plat_${platId}`);
            if (platCheckbox) {
                platCheckbox.checked = true;
                toggleQuantityVisibility(platCheckbox, true);
            }
        }

        // Fonction pour décocher les compléments et garnitures associés à un plat
        function uncheckPlatSelections(platId) {
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                toggleQuantityVisibility(checkbox, false);
            });

            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                toggleQuantityVisibility(checkbox, false);
            });
        }

        // Initialisation des événements lors du chargement du document
        document.addEventListener("DOMContentLoaded", function() {
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
                    } else {
                        const input = checkbox.closest(".form-check").querySelector(
                            ".cart-plus-minus-box");
                        updateComplementGarnitureLimits(input);
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
    </script> --}}


    {{-- <script>
        // Fonction pour augmenter la quantité du plat
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;
            input.value = currentValue + 1;

            updateComplementGarnitureLimits(input);
        }

        // Fonction pour diminuer la quantité du plat
        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateComplementGarnitureLimits(input);
            }
        }

        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

            // Vérifier si platId est valide
            if (!platId) {
                console.error("Plat ID introuvable");
                return;
            }

            const quantity = parseInt(input.value, 10);

            // Mettre à jour les compléments
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            manageSelectionLimits(complementCheckboxes, quantity);

            // Mettre à jour les garnitures
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            manageSelectionLimits(garnitureCheckboxes, quantity);
        }

        // Fonction pour gérer la limite de sélection des compléments et garnitures
        function manageSelectionLimits(checkboxes, limit) {
            let selectedCount = 0;

            checkboxes.forEach((checkbox) => {
                // Si le plat est sélectionné, activer les compléments et garnitures
                checkbox.disabled = selectedCount >= limit && !checkbox.checked;

                checkbox.addEventListener("change", function() {
                    selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                    checkboxes.forEach((box) => {
                        box.disabled = selectedCount >= limit && !box.checked;
                    });
                });
            });
        }

        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";
            }
        }

        // Fonction pour vérifier si un plat est sélectionné et afficher la quantité
        function checkPlat(checkbox) {
            const platId = checkbox.getAttribute("data-plat-id");
            const platCheckbox = document.getElementById(`plat_${platId}`);
            if (platCheckbox) {
                platCheckbox.checked = true;
                toggleQuantityVisibility(platCheckbox, true);
            }
        }

        // Fonction pour décocher les compléments et garnitures associés à un plat
        function uncheckPlatSelections(platId) {
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                checkbox.disabled = true; // Désactiver le complément
                toggleQuantityVisibility(checkbox, false);
            });

            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.checked = false;
                checkbox.disabled = true; // Désactiver la garniture
                toggleQuantityVisibility(checkbox, false);
            });
        }

        // Fonction pour activer/désactiver les garnitures et compléments en fonction de la sélection du plat
        function handlePlatSelection(checkbox) {
            const platId = checkbox.value;

            // Si le plat est sélectionné, activer les compléments et garnitures
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);

            if (checkbox.checked) {
                // Activer les compléments et garnitures
                complementCheckboxes.forEach(checkbox => checkbox.disabled = false);
                garnitureCheckboxes.forEach(checkbox => checkbox.disabled = false);
                // Mettre à jour les limites des compléments et garnitures
                const input = checkbox.closest(".form-check").querySelector(".cart-plus-minus-box");
                updateComplementGarnitureLimits(input);
            } else {
                // Désactiver les compléments et garnitures
                complementCheckboxes.forEach(checkbox => {
                    checkbox.disabled = true;
                    checkbox.checked = false; // Décocher également les cases
                });
                garnitureCheckboxes.forEach(checkbox => {
                    checkbox.disabled = true;
                    checkbox.checked = false; // Décocher également les cases
                });
            }

            toggleQuantityVisibility(checkbox, checkbox.checked);
        }

        // Initialisation des événements lors du chargement du document
        document.addEventListener("DOMContentLoaded", function() {
            // Gestion des événements sur les compléments
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            complementCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = true; // Désactiver les compléments par défaut
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les garnitures
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            garnitureCheckboxes.forEach(function(checkbox) {
                checkbox.disabled = true; // Désactiver les garnitures par défaut
                checkbox.addEventListener("change", function() {
                    checkPlat(this);
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            // Gestion des événements sur les plats
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");
            platCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    handlePlatSelection(
                        checkbox); // Gérer l'activation/désactivation des compléments et garnitures
                    if (!checkbox.checked) {
                        const platId = checkbox.value;
                        uncheckPlatSelections(
                            platId
                            ); // Décocher les compléments et garnitures lorsque le plat est décoché
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
    </script> --}}

  {{-- ############# 10-12-2024--19h  ########### --}}
  {{-- <script>
    // Fonction pour augmenter la quantité du plat
    function increaseValue(button) {
        const input = button.parentElement.querySelector(".cart-plus-minus-box");
        let currentValue = parseInt(input.value, 10) || 0;
        input.value = currentValue + 1;

        updateComplementGarnitureLimits(input);
    }

    // Fonction pour diminuer la quantité du plat
    function decreaseValue(button) {
        const input = button.parentElement.querySelector(".cart-plus-minus-box");
        let currentValue = parseInt(input.value, 10) || 0;
        if (currentValue > 1) {
            input.value = currentValue - 1;

            // Mise à jour des compléments et garnitures lorsque la quantité est diminuée
            updateComplementGarnitureLimits(input);

            // Décoche et grise le dernier élément sélectionné parmi les compléments et garnitures
            uncheckAndDisableLastSelected(input);
        }
    }

    // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
    function updateComplementGarnitureLimits(input) {
        const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

        // Vérifier si platId est valide
        if (!platId) {
            console.error("Plat ID introuvable");
            return;
        }

        const quantity = parseInt(input.value, 10);

        // Mettre à jour les compléments
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        manageSelectionLimits(complementCheckboxes, quantity);

        // Mettre à jour les garnitures
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
        manageSelectionLimits(garnitureCheckboxes, quantity);
    }

    // Fonction pour gérer la limite de sélection des compléments et garnitures
    function manageSelectionLimits(checkboxes, limit) {
        let selectedCount = 0;

        checkboxes.forEach((checkbox) => {
            // Si le plat est sélectionné, activer les compléments et garnitures
            checkbox.disabled = selectedCount >= limit && !checkbox.checked;

            checkbox.addEventListener("change", function() {
                selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                checkboxes.forEach((box) => {
                    box.disabled = selectedCount >= limit && !box.checked;
                });
            });
        });
    }

    // Fonction pour décocher et griser le dernier élément sélectionné parmi les compléments et garnitures
    function uncheckAndDisableLastSelected(input) {
        const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

        if (!platId) {
            return;
        }

        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);

        // Récupérer tous les éléments sélectionnés parmi les compléments et garnitures
        const selectedComplementCheckboxes = Array.from(complementCheckboxes).filter((checkbox) => checkbox.checked);
        const selectedGarnitureCheckboxes = Array.from(garnitureCheckboxes).filter((checkbox) => checkbox.checked);

        // Décoche et désactive le dernier élément sélectionné
        if (selectedComplementCheckboxes.length > 0) {
            const lastSelectedComplement = selectedComplementCheckboxes[selectedComplementCheckboxes.length - 1];
            lastSelectedComplement.checked = false;
            lastSelectedComplement.disabled = true;
            toggleQuantityVisibility(lastSelectedComplement, false); // Masquer la quantité
        }

        if (selectedGarnitureCheckboxes.length > 0) {
            const lastSelectedGarniture = selectedGarnitureCheckboxes[selectedGarnitureCheckboxes.length - 1];
            lastSelectedGarniture.checked = false;
            lastSelectedGarniture.disabled = true;
            toggleQuantityVisibility(lastSelectedGarniture, false); // Masquer la quantité
        }
    }

    // Fonction pour afficher ou masquer la quantité en fonction de la sélection
    function toggleQuantityVisibility(checkbox, isVisible) {
        const parent = checkbox.closest(".form-check");
        const quantityWrapper = parent.querySelector(".product-quantity");
        if (quantityWrapper) {
            quantityWrapper.style.display = isVisible ? "block" : "none";
        }
    }

    // Fonction pour vérifier si un plat est sélectionné et afficher la quantité
    function checkPlat(checkbox) {
        const platId = checkbox.getAttribute("data-plat-id");
        const platCheckbox = document.getElementById(`plat_${platId}`);
        if (platCheckbox) {
            platCheckbox.checked = true;
            toggleQuantityVisibility(platCheckbox, true);
        }
    }

    // Fonction pour décocher les compléments et garnitures associés à un plat
    function uncheckPlatSelections(platId) {
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        complementCheckboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            checkbox.disabled = true; // Désactiver le complément
            toggleQuantityVisibility(checkbox, false);
        });

        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
        garnitureCheckboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            checkbox.disabled = true; // Désactiver la garniture
            toggleQuantityVisibility(checkbox, false);
        });
    }

    // Fonction pour activer/désactiver les garnitures et compléments en fonction de la sélection du plat
    function handlePlatSelection(checkbox) {
        const platId = checkbox.value;

        // Si le plat est sélectionné, activer les compléments et garnitures
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);

        if (checkbox.checked) {
            // Activer les compléments et garnitures
            complementCheckboxes.forEach(checkbox => checkbox.disabled = false);
            garnitureCheckboxes.forEach(checkbox => checkbox.disabled = false);
            // Mettre à jour les limites des compléments et garnitures
            const input = checkbox.closest(".form-check").querySelector(".cart-plus-minus-box");
            updateComplementGarnitureLimits(input);
        } else {
            // Désactiver les compléments et garnitures
            complementCheckboxes.forEach(checkbox => {
                checkbox.disabled = true;
                checkbox.checked = false; // Décocher également les cases
            });
            garnitureCheckboxes.forEach(checkbox => {
                checkbox.disabled = true;
                checkbox.checked = false; // Décocher également les cases
            });
        }

        toggleQuantityVisibility(checkbox, checkbox.checked);
    }

    // Initialisation des événements lors du chargement du document
    document.addEventListener("DOMContentLoaded", function() {
        // Gestion des événements sur les compléments
        const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
        complementCheckboxes.forEach(function(checkbox) {
            checkbox.disabled = true; // Désactiver les compléments par défaut
            checkbox.addEventListener("change", function() {
                checkPlat(this);
                toggleQuantityVisibility(this, this.checked);
            });
        });

        // Gestion des événements sur les garnitures
        const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
        garnitureCheckboxes.forEach(function(checkbox) {
            checkbox.disabled = true; // Désactiver les garnitures par défaut
            checkbox.addEventListener("change", function() {
                checkPlat(this);
                toggleQuantityVisibility(this, this.checked);
            });
        });

        // Gestion des événements sur les plats
        const platCheckboxes = document.querySelectorAll(".plat-checkbox");
        platCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                handlePlatSelection(
                checkbox); // Gérer l'activation/désactivation des compléments et garnitures
                if (!checkbox.checked) {
                    const platId = checkbox.value;
                    uncheckPlatSelections(
                    platId); // Décocher les compléments et garnitures lorsque le plat est décoché
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
</script> --}}
{{-- ############# 10-12-2024--19h  ########### --}}
  

<script>
    // Fonction pour augmenter la quantité du plat
    function increaseValue(button) {
        const input = button.parentElement.querySelector(".cart-plus-minus-box");
        let currentValue = parseInt(input.value, 10) || 0;
        input.value = currentValue + 1;

        updateComplementGarnitureLimits(input);
    }

    // Fonction pour diminuer la quantité du plat
    function decreaseValue(button) {
        const input = button.parentElement.querySelector(".cart-plus-minus-box");
        let currentValue = parseInt(input.value, 10) || 0;
        if (currentValue > 1) {
            input.value = currentValue - 1;

            // Mise à jour des compléments et garnitures lorsque la quantité est diminuée
            updateComplementGarnitureLimits(input);

            // Décoche le dernier élément sélectionné parmi les compléments et garnitures
            uncheckLastSelected(input);
        }
    }

    // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
    function updateComplementGarnitureLimits(input) {
        const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

        // Vérifier si platId est valide
        if (!platId) {
            console.error("Plat ID introuvable");
            return;
        }

        const quantity = parseInt(input.value, 10);

        // Mettre à jour les compléments
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        manageSelectionLimits(complementCheckboxes, quantity);

        // Mettre à jour les garnitures
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
        manageSelectionLimits(garnitureCheckboxes, quantity);
    }

    // Fonction pour gérer la limite de sélection des compléments et garnitures
    function manageSelectionLimits(checkboxes, limit) {
        let selectedCount = 0;

        checkboxes.forEach((checkbox) => {
            // Si le plat est sélectionné, activer les compléments et garnitures
            checkbox.disabled = selectedCount >= limit && !checkbox.checked;

            checkbox.addEventListener("change", function() {
                selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                checkboxes.forEach((box) => {
                    box.disabled = selectedCount >= limit && !box.checked;
                });
            });
        });
    }

    // Fonction pour décocher le dernier élément sélectionné parmi les compléments et garnitures
    function uncheckLastSelected(input) {
        const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

        if (!platId) {
            return;
        }

        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);

        // Récupérer tous les éléments sélectionnés parmi les compléments et garnitures
        const selectedComplementCheckboxes = Array.from(complementCheckboxes).filter((checkbox) => checkbox.checked);
        const selectedGarnitureCheckboxes = Array.from(garnitureCheckboxes).filter((checkbox) => checkbox.checked);

        // Décoche le dernier élément sélectionné parmi les compléments
        if (selectedComplementCheckboxes.length > 0) {
            const lastSelectedComplement = selectedComplementCheckboxes[selectedComplementCheckboxes.length - 1];
            lastSelectedComplement.checked = false;
            toggleQuantityVisibility(lastSelectedComplement, false); // Masquer la quantité
        }

        // Décoche le dernier élément sélectionné parmi les garnitures
        if (selectedGarnitureCheckboxes.length > 0) {
            const lastSelectedGarniture = selectedGarnitureCheckboxes[selectedGarnitureCheckboxes.length - 1];
            lastSelectedGarniture.checked = false;
            toggleQuantityVisibility(lastSelectedGarniture, false); // Masquer la quantité
        }
    }

    // Fonction pour afficher ou masquer la quantité en fonction de la sélection
    function toggleQuantityVisibility(checkbox, isVisible) {
        const parent = checkbox.closest(".form-check");
        const quantityWrapper = parent.querySelector(".product-quantity");
        if (quantityWrapper) {
            quantityWrapper.style.display = isVisible ? "block" : "none";
        }
    }

    // Fonction pour vérifier si un plat est sélectionné et afficher la quantité
    function checkPlat(checkbox) {
        const platId = checkbox.getAttribute("data-plat-id");
        const platCheckbox = document.getElementById(`plat_${platId}`);
        if (platCheckbox) {
            platCheckbox.checked = true;
            toggleQuantityVisibility(platCheckbox, true);
        }
    }

    // Fonction pour décocher les compléments et garnitures associés à un plat
    function uncheckPlatSelections(platId) {
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        complementCheckboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            toggleQuantityVisibility(checkbox, false);
        });

        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
        garnitureCheckboxes.forEach(function(checkbox) {
            checkbox.checked = false;
            toggleQuantityVisibility(checkbox, false);
        });
    }

    // Fonction pour activer/désactiver les garnitures et compléments en fonction de la sélection du plat
    function handlePlatSelection(checkbox) {
        const platId = checkbox.value;

        // Si le plat est sélectionné, activer les compléments et garnitures
        const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
        const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);

        if (checkbox.checked) {
            // Activer les compléments et garnitures
            complementCheckboxes.forEach(checkbox => checkbox.disabled = false);
            garnitureCheckboxes.forEach(checkbox => checkbox.disabled = false);
            // Mettre à jour les limites des compléments et garnitures
            const input = checkbox.closest(".form-check").querySelector(".cart-plus-minus-box");
            updateComplementGarnitureLimits(input);
        } else {
            // Désactiver les compléments et garnitures
            complementCheckboxes.forEach(checkbox => {
                checkbox.checked = false; // Décocher également les cases
            });
            garnitureCheckboxes.forEach(checkbox => {
                checkbox.checked = false; // Décocher également les cases
            });
        }

        toggleQuantityVisibility(checkbox, checkbox.checked);
    }

    // Initialisation des événements lors du chargement du document
    document.addEventListener("DOMContentLoaded", function() {
        // Gestion des événements sur les compléments
        const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
        complementCheckboxes.forEach(function(checkbox) {
            checkbox.disabled = true; // Désactiver les compléments par défaut
            checkbox.addEventListener("change", function() {
                checkPlat(this);
                toggleQuantityVisibility(this, this.checked);
            });
        });

        // Gestion des événements sur les garnitures
        const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
        garnitureCheckboxes.forEach(function(checkbox) {
            checkbox.disabled = true; // Désactiver les garnitures par défaut
            checkbox.addEventListener("change", function() {
                checkPlat(this);
                toggleQuantityVisibility(this, this.checked);
            });
        });

        // Gestion des événements sur les plats
        const platCheckboxes = document.querySelectorAll(".plat-checkbox");
        platCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener("change", function() {
                handlePlatSelection(checkbox); // Gérer l'activation/désactivation des compléments et garnitures
                if (!checkbox.checked) {
                    const platId = checkbox.value;
                    uncheckPlatSelections(platId); // Décocher les compléments et garnitures lorsque le plat est décoché
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
