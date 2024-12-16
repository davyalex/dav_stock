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

                <?php $cartMenu = Session::get('cartMenu', []); ?>
                <div class="d-flex mt-4 ol-sm-12 col-md-12 col-lg-12 col-xl-12 m-auto">
                    <div class="col-12 col-md-12 col-lg-12 col-xl-8">
                        @foreach ($categories as $categorie => $plats)
                            <div class="card shadow col-12">
                                <div class="card-header bg-danger text-white">
                                    <h5 class="m-0 text-white">{{ $categorie }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($plats as $platKey => $plat)
                                            <?php
                                            $cartItem = collect($cartMenu)->firstWhere('plat_id', $plat->id);
                                            $isPlatChecked = !is_null($cartItem);
                                            $platQuantity = $isPlatChecked ? $cartItem['quantity'] : 1;
                                            ?>
                                            <div class="col-md-6 mb-3">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between mt-2">
                                                            <div class="form-check">
                                                                <input type="checkbox" data-price="{{ $plat->prix }}"
                                                                    id="plat_{{ $plat->id }}"
                                                                    class="form-check-input plat-checkbox" name="plats[]"
                                                                    value="{{ $plat->id }}"
                                                                    {{ $isPlatChecked ? 'checked' : '' }}>
                                                                <label for="plat_{{ $plat->id }}"
                                                                    class="form-check-label fw-bold text-capitalize fs-6">
                                                                    {{ $plat->nom }}
                                                                </label>
                                                                @if ($plat->complements->isNotEmpty() || $plat->garnitures->isNotEmpty())
                                                                    <i class="fa fa-info-circle text-warning fs-6"
                                                                        data-bs-toggle="popover" data-bs-placement="top"
                                                                        data-bs-trigger="hover"
                                                                        data-bs-content="Choisir les garnitures et complements en fonction de la quantité du plat ."></i>
                                                                @endif
                                                                <div class="product-quantity mb-0"
                                                                    data-product-id="{{ $plat->id }}">
                                                                    <div class="cart-plus-minus">
                                                                        <div class="dec qtybutton"
                                                                            onclick="decreaseValue(this)">-</div>
                                                                        <input id="quantity"
                                                                            class="cart-plus-minus-box quantityPlat text-danger"
                                                                            type="text" name="quantity"
                                                                            value="{{ $platQuantity }}" min="1"
                                                                            readonly>
                                                                        <div class="inc qtybutton"
                                                                            onclick="increaseValue(this)">+</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <strong data-price="{{ $plat->prix }}"
                                                                class="price text-danger">
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
                                                                            <?php
                                                                            $complementChecked = $isPlatChecked && collect($cartItem['complements'])->contains('id', $complement->id);
                                                                            $complementQuantity = $complementChecked ? collect($cartItem['complements'])->firstWhere('id', $complement->id)['quantity'] : 1;
                                                                            ?>
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    id="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    name="complements_{{ $platKey }}[]"
                                                                                    class="form-check-input complement-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $complement->id }}"
                                                                                    {{ $complementChecked ? 'checked' : '' }}>
                                                                                <label
                                                                                    for="complement_{{ $platKey }}_{{ $complementKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $complement->nom }}
                                                                                </label>

                                                                                <div class="product-quantity mb-0"
                                                                                    data-product-id="{{ $complement->id }}">
                                                                                    <div class="cart-plus-minus">
                                                                                        <div class="dec qtybutton"
                                                                                            onclick="decreaseValue(this)">-
                                                                                        </div>
                                                                                        <input id="quantity"
                                                                                            class="cart-plus-minus-box quantityComplement text-danger"
                                                                                            type="text" name="quantity"
                                                                                            value="{{ $complementQuantity }}"
                                                                                            min="0" readonly>
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
                                                                    <p class="card-text fw-bold mt-3">Choisir des
                                                                        garnitures :</p>
                                                                    <form class="garniture-form">
                                                                        @foreach ($plat->garnitures as $garnitureKey => $garniture)
                                                                            <?php
                                                                            $garnitureChecked = $isPlatChecked && collect($cartItem['garnitures'])->contains('id', $garniture->id);
                                                                            $garnitureQuantity = $garnitureChecked ? collect($cartItem['garnitures'])->firstWhere('id', $garniture->id)['quantity'] : 1;
                                                                            ?>
                                                                            <div class="form-check">
                                                                                <input type="checkbox"
                                                                                    id="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    name="garnitures_{{ $platKey }}[]"
                                                                                    class="form-check-input garniture-checkbox"
                                                                                    data-plat-id="{{ $plat->id }}"
                                                                                    value="{{ $garniture->id }}"
                                                                                    {{ $garnitureChecked ? 'checked' : '' }}>
                                                                                <label
                                                                                    for="garniture_{{ $platKey }}_{{ $garnitureKey }}"
                                                                                    class="form-check-label">
                                                                                    {{ $garniture->nom }}
                                                                                </label>

                                                                                <div class="product-quantity mb-0"
                                                                                    data-product-id="{{ $garniture->id }}">
                                                                                    <div class="cart-plus-minus">
                                                                                        <div class="dec qtybutton"
                                                                                            onclick="decreaseValue(this)">-
                                                                                        </div>
                                                                                        <input id="quantity"
                                                                                            class="cart-plus-minus-box quantityGarniture text-danger"
                                                                                            type="text" name="quantity"
                                                                                            value="{{ $garnitureQuantity }}"
                                                                                            min="0" readonly>
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

                <button type="button" class="btn btn-danger addCart text-white w-100"
                    style="border-radius: 5px; font-size: 20px;">
                    <i class="fa fa-shopping-cart"></i> Commander
                </button>
            @endif
        </div>
        @include('site.components.ajouter-au-panier-menu')
    </div>




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
                input.value = currentValue - 1; // Réduit la quantité
            }

            // Décocher les compléments et garnitures en excès si nécessaire
            ensureSelectionWithinLimits(input);
            updateComplementGarnitureLimits(input);
        }

        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

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
            let selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;

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

        // Fonction pour s'assurer que les sélections restent dans les limites
        function ensureSelectionWithinLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

            if (!platId) {
                return;
            }

            const quantity = parseInt(input.value, 10);

            // Décocher les compléments en excès
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(complementCheckboxes, quantity);

            // Décocher les garnitures en excès
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(garnitureCheckboxes, quantity);
        }

        // Fonction pour décocher les éléments en excès
        function deselectExcessItems(checkboxes, limit) {
            let selectedCount = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedCount++;
                    if (selectedCount > limit) {
                        checkbox.checked = false;
                        toggleQuantityVisibility(checkbox, false); // Masquer la quantité associée
                    }
                }
            });
        }

        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";

                // Réinitialisation de la quantité à 1 si l'élément est décoché et la quantité est cachée
                if (!isVisible && !checkbox.checked) {
                    const quantityInput = parent.querySelector(".cart-plus-minus-box");
                    if (quantityInput) {
                        quantityInput.value = 1; // Réinitialiser à 1 lorsque l'élément est décoché
                    }
                }
            }
        }

        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";

                // Réinitialisation de la quantité à 1 si l'élément est décoché et la quantité est cachée
                if (!isVisible && !checkbox.checked) {
                    const quantityInput = parent.querySelector(".cart-plus-minus-box");
                    if (quantityInput) {
                        quantityInput.value = 1; // Réinitialiser à 1 lorsque l'élément est décoché
                    }
                }
            }
        }

        // Initialisation des événements lors du chargement du document
        document.addEventListener("DOMContentLoaded", function() {
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");

            // Vérifier l'état initial des cases à cocher et ajuster les champs de quantité
            complementCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function() {
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            garnitureCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function() {
                    toggleQuantityVisibility(this, this.checked);
                });
            });

            platCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function() {
                    // Gérer l'affichage des quantités pour les plats
                    const platId = this.value;
                    const complementCheckboxes = document.querySelectorAll(
                        `.complement-checkbox[data-plat-id="${platId}"]`);
                    const garnitureCheckboxes = document.querySelectorAll(
                        `.garniture-checkbox[data-plat-id="${platId}"]`);

                    if (this.checked) {
                        complementCheckboxes.forEach((box) => {
                            box.disabled = false;
                            toggleQuantityVisibility(box, box.checked);
                        });
                        garnitureCheckboxes.forEach((box) => {
                            box.disabled = false;
                            toggleQuantityVisibility(box, box.checked);
                        });
                    } else {
                        complementCheckboxes.forEach((box) => {
                            box.disabled = true;
                            box.checked = false;
                            toggleQuantityVisibility(box, false);
                        });
                        garnitureCheckboxes.forEach((box) => {
                            box.disabled = true;
                            box.checked = false;
                            toggleQuantityVisibility(box, false);
                        });
                    }
                });

                // Gérer les compléments et garnitures si un plat est déjà coché au chargement
                if (checkbox.checked) {
                    const platId = checkbox.value;
                    const complementCheckboxes = document.querySelectorAll(
                        `.complement-checkbox[data-plat-id="${platId}"]`);
                    const garnitureCheckboxes = document.querySelectorAll(
                        `.garniture-checkbox[data-plat-id="${platId}"]`);

                    complementCheckboxes.forEach((box) => {
                        box.disabled = false;
                        toggleQuantityVisibility(box, box.checked);
                    });
                    garnitureCheckboxes.forEach((box) => {
                        box.disabled = false;
                        toggleQuantityVisibility(box, box.checked);
                    });
                }
            });
        });
    </script> --}}



    {{-- bon code mais ne cache pas la quantité du plat au coche et decoche --}}
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
            }
    
            ensureSelectionWithinLimits(input);
            updateComplementGarnitureLimits(input);
        }
    
        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;
    
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
            let selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
    
            checkboxes.forEach((checkbox) => {
                checkbox.disabled = selectedCount >= limit && !checkbox.checked;
    
                checkbox.addEventListener("change", function () {
                    selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;
                    checkboxes.forEach((box) => {
                        box.disabled = selectedCount >= limit && !box.checked;
                    });
                });
            });
        }
    
        // Fonction pour s'assurer que les sélections restent dans les limites
        function ensureSelectionWithinLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;
    
            if (!platId) {
                return;
            }
    
            const quantity = parseInt(input.value, 10);
    
            // Décocher les compléments en excès
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(complementCheckboxes, quantity);
    
            // Décocher les garnitures en excès
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(garnitureCheckboxes, quantity);
        }
    
        // Fonction pour décocher les éléments en excès
        function deselectExcessItems(checkboxes, limit) {
            let selectedCount = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedCount++;
                    if (selectedCount > limit) {
                        checkbox.checked = false;
                        toggleQuantityVisibility(checkbox, false); // Masquer la quantité associée
                    }
                }
            });
        }
    
        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";
    
                // Réinitialisation de la quantité à 1 si l'élément est décoché et la quantité est cachée
                if (!isVisible && !checkbox.checked) {
                    const quantityInput = parent.querySelector(".cart-plus-minus-box");
                    if (quantityInput) {
                        quantityInput.value = 1;
                    }
                }
            }
        }
    
        // Initialisation des événements lors du chargement du document
        document.addEventListener("DOMContentLoaded", function () {
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            const platInputs = document.querySelectorAll(".cart-plus-minus-box");
    
            // Mettre à jour les limites dès le chargement pour chaque plat
            platInputs.forEach((input) => {
                updateComplementGarnitureLimits(input);
            });
    
            // Vérifier l'état initial des cases à cocher et ajuster les champs de quantité
            complementCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function () {
                    toggleQuantityVisibility(this, this.checked);
                    // Coche automatiquement le plat correspondant si une garniture ou un complément est coché
                    const platId = this.dataset.platId;
                    const platCheckbox = document.querySelector(`.plat-checkbox[value="${platId}"]`);
                    if (this.checked && platCheckbox && !platCheckbox.checked) {
                        platCheckbox.checked = true;
                        platCheckbox.dispatchEvent(new Event("change")); // Déclencher l'événement pour gérer l'état du plat
                    }
                });
            });
    
            garnitureCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function () {
                    toggleQuantityVisibility(this, this.checked);
                    // Coche automatiquement le plat correspondant si une garniture ou un complément est coché
                    const platId = this.dataset.platId;
                    const platCheckbox = document.querySelector(`.plat-checkbox[value="${platId}"]`);
                    if (this.checked && platCheckbox && !platCheckbox.checked) {
                        platCheckbox.checked = true;
                        platCheckbox.dispatchEvent(new Event("change")); // Déclencher l'événement pour gérer l'état du plat
                    }
                });
            });
    
            // Gérer la désélection des garnitures et compléments lorsque le plat est décoché
            platCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    const platId = this.value;
                    const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
                    const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
    
                    if (!this.checked) {
                        // Décocher et désactiver les garnitures et compléments associés
                        complementCheckboxes.forEach((box) => {
                            box.checked = false;
                            toggleQuantityVisibility(box, false); // Masquer la quantité
                        });
    
                        garnitureCheckboxes.forEach((box) => {
                            box.checked = false;
                            toggleQuantityVisibility(box, false); // Masquer la quantité
                        });
                    }
                });
            });
        });
    </script> --}}



    {{-- Bon code gestion des somme quantite --}}

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour augmenter la quantité
            function increaseValue(button) {
                const input = button.previousElementSibling;
                const currentValue = parseInt(input.value) || 0;
                input.value = currentValue + 1;
                triggerChange(input);
            }

            // Fonction pour diminuer la quantité
            function decreaseValue(button) {
                const input = button.nextElementSibling;
                const currentValue = parseInt(input.value) || 0;
                if (currentValue > 0) {
                    input.value = currentValue - 1;
                    triggerChange(input);
                }
            }

            // Fonction déclenchée lors de tout changement de quantité
            function triggerChange(input) {
                const parent = input.closest('.card-body');
                const platQuantityInput = parent.querySelector('.quantityPlat');
                const platQuantity = parseInt(platQuantityInput.value) || 0;

                // Gestion des quantités des garnitures
                const garnitureQuantities = Array.from(
                    parent.querySelectorAll('.quantityGarniture')
                ).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

                if (garnitureQuantities > platQuantity) {
                    adjustGarnitureQuantities(parent, platQuantity);
                }

                // Gestion des quantités des compléments
                const complementQuantities = Array.from(
                    parent.querySelectorAll('.quantityComplement')
                ).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

                if (complementQuantities > platQuantity) {
                    adjustComplementQuantities(parent, platQuantity);
                }

                // Mise à jour des prix
                updateTotalPrice(parent);
            }

            // Fonction pour ajuster les quantités des garnitures
            function adjustGarnitureQuantities(parent, maxQuantity) {
                const garnitureInputs = parent.querySelectorAll('.quantityGarniture');
                let remainingQuantity = maxQuantity;

                garnitureInputs.forEach((input) => {
                    const value = parseInt(input.value) || 0;
                    if (value > remainingQuantity) {
                        input.value = remainingQuantity;
                        remainingQuantity = 0;
                    } else {
                        remainingQuantity -= value;
                    }
                });
            }

            // Fonction pour ajuster les quantités des compléments
            function adjustComplementQuantities(parent, maxQuantity) {
                const complementInputs = parent.querySelectorAll('.quantityComplement');
                let remainingQuantity = maxQuantity;

                complementInputs.forEach((input) => {
                    const value = parseInt(input.value) || 0;
                    if (value > remainingQuantity) {
                        input.value = remainingQuantity;
                        remainingQuantity = 0;
                    } else {
                        remainingQuantity -= value;
                    }
                });
            }

            // Fonction pour mettre à jour le prix total
            function updateTotalPrice(parent) {
                const platPrice = parseFloat(parent.querySelector('.price').getAttribute('data-price')) || 0;
                const platQuantity = parseInt(parent.querySelector('.quantityPlat').value) || 0;

                const complementPrice = Array.from(parent.querySelectorAll('.complement-checkbox'))
                    .filter((checkbox) => checkbox.checked)
                    .reduce((sum, checkbox) => {
                        const quantity = parseInt(
                            parent.querySelector(`.quantityComplement[data-product-id="${checkbox.value}"]`)
                            .value
                        ) || 0;
                        const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                        return sum + quantity * price;
                    }, 0);

                const garniturePrice = Array.from(parent.querySelectorAll('.garniture-checkbox'))
                    .filter((checkbox) => checkbox.checked)
                    .reduce((sum, checkbox) => {
                        const quantity = parseInt(
                            parent.querySelector(`.quantityGarniture[data-product-id="${checkbox.value}"]`)
                            .value
                        ) || 0;
                        const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
                        return sum + quantity * price;
                    }, 0);

                const totalPrice = platQuantity * platPrice + complementPrice + garniturePrice;
                parent.querySelector('.price').textContent =
                    `${totalPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ' ')} FCFA`;
            }

            // Attacher les événements pour les boutons + et -
            document.querySelectorAll('.inc').forEach((button) => {
                button.addEventListener('click', function() {
                    increaseValue(this);
                });
            });

            document.querySelectorAll('.dec').forEach((button) => {
                button.addEventListener('click', function() {
                    decreaseValue(this);
                });
            });

            // Attacher les événements pour les checkbox (plat, garniture, complément)
            document.querySelectorAll('.plat-checkbox').forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    const parent = this.closest('.card-body');
                    const garnitureCheckboxes = parent.querySelectorAll('.garniture-checkbox');
                    const complementCheckboxes = parent.querySelectorAll('.complement-checkbox');

                    // Si le plat est coché, cocher les garnitures et compléments associés
                    if (this.checked) {
                        garnitureCheckboxes.forEach((garniture) => {
                            garniture.checked = true;
                            const input = parent.querySelector(
                                `.quantityGarniture[data-product-id="${garniture.value}"]`
                            );
                            input.style.display =
                                'inline-block'; // Afficher le champ de quantité
                            input.value = input.getAttribute(
                                'data-default-quantity'); // Utilise la valeur par défaut
                        });

                        complementCheckboxes.forEach((complement) => {
                            complement.checked = true;
                            const input = parent.querySelector(
                                `.quantityComplement[data-product-id="${complement.value}"]`
                            );
                            input.style.display =
                                'inline-block'; // Afficher le champ de quantité
                            input.value = input.getAttribute(
                                'data-default-quantity'); // Utilise la valeur par défaut
                        });
                    } else {
                        // Si le plat est décoché, décocher toutes les garnitures et compléments
                        garnitureCheckboxes.forEach((garniture) => {
                            garniture.checked = false;
                            const input = parent.querySelector(
                                `.quantityGarniture[data-product-id="${garniture.value}"]`
                            );
                            input.style.display = 'none'; // Cacher le champ de quantité
                            input.value = 0; // Réinitialiser la quantité
                        });

                        complementCheckboxes.forEach((complement) => {
                            complement.checked = false;
                            const input = parent.querySelector(
                                `.quantityComplement[data-product-id="${complement.value}"]`
                            );
                            input.style.display = 'none'; // Cacher le champ de quantité
                            input.value = 0; // Réinitialiser la quantité
                        });
                    }

                    updateTotalPrice(parent);
                });
            });

            // Attacher les événements pour les checkbox de garniture et complément
            document.querySelectorAll('.garniture-checkbox, .complement-checkbox').forEach((checkbox) => {
                checkbox.addEventListener('change', function() {
                    const parent = this.closest('.card-body');
                    const platCheckbox = parent.querySelector('.plat-checkbox');

                    // Si une garniture ou un complément est coché, cocher le plat associé et afficher les quantités
                    if (this.checked) {
                        platCheckbox.checked = true;
                        const input = parent.querySelector(
                            `.quantityGarniture[data-product-id="${this.value}"], .quantityComplement[data-product-id="${this.value}"]`
                        );
                        input.style.display = 'inline-block'; // Afficher le champ de quantité
                    }

                    // Si décoché, cacher le champ de quantité associé
                    if (!this.checked) {
                        const input = parent.querySelector(
                            `.quantityGarniture[data-product-id="${this.value}"], .quantityComplement[data-product-id="${this.value}"]`
                        );
                        input.style.display = 'none'; // Cacher le champ de quantité
                        input.value = 0; // Réinitialiser la quantité
                    }

                    updateTotalPrice(parent);
                });
            });
        });
    </script> --}}

    {{-- code fusionné ajusté --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
        const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl);
        });
        // Fonction pour augmenter la quantité du plat
        function increaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;
            input.value = currentValue + 1;
            triggerChange(input);

            updateComplementGarnitureLimits(input);
        }

        // Fonction pour diminuer la quantité du plat
        function decreaseValue(button) {
            const input = button.parentElement.querySelector(".cart-plus-minus-box");
            let currentValue = parseInt(input.value, 10) || 0;

            if (currentValue > 1) {
                input.value = currentValue - 1;
                triggerChange(input);
            }

            ensureSelectionWithinLimits(input);
            updateComplementGarnitureLimits(input);
        }

        // Fonction pour mettre à jour les limites de sélection des compléments et garnitures
        function updateComplementGarnitureLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

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


        // Fonction déclenchée lors de tout changement de quantité
        function triggerChange(input) {
            const parent = input.closest('.card-body');
            const platQuantityInput = parent.querySelector('.quantityPlat');
            const platQuantity = parseInt(platQuantityInput.value) || 0;

            // Gestion des quantités des garnitures
            const garnitureQuantities = Array.from(
                parent.querySelectorAll('.quantityGarniture')
            ).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

            if (garnitureQuantities > platQuantity) {
                adjustGarnitureQuantities(parent, platQuantity);
            }

            // Gestion des quantités des compléments
            const complementQuantities = Array.from(
                parent.querySelectorAll('.quantityComplement')
            ).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

            if (complementQuantities > platQuantity) {
                adjustComplementQuantities(parent, platQuantity);
            }

            // Mise à jour des prix
            // updateTotalPrice(parent);
        }


        // Fonction pour ajuster les quantités des compléments
        function adjustComplementQuantities(parent, maxQuantity) {
            const complementInputs = parent.querySelectorAll('.quantityComplement');
            let remainingQuantity = maxQuantity;

            complementInputs.forEach((input) => {
                const value = parseInt(input.value) || 0;
                if (value > remainingQuantity) {
                    input.value = remainingQuantity;
                    remainingQuantity = 0;
                } else {
                    remainingQuantity -= value;
                }
            });
        }

        // Fonction pour mettre à jour le prix total
        // function updateTotalPrice(parent) {
        //     const platPrice = parseFloat(parent.querySelector('.price').getAttribute('data-price')) || 0;
        //     const platQuantity = parseInt(parent.querySelector('.quantityPlat').value) || 0;

        //     const complementPrice = Array.from(parent.querySelectorAll('.complement-checkbox'))
        //         .filter((checkbox) => checkbox.checked)
        //         .reduce((sum, checkbox) => {
        //             const quantity = parseInt(
        //                 parent.querySelector(`.quantityComplement[data-product-id="${checkbox.value}"]`)
        //                 .value
        //             ) || 0;
        //             const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
        //             return sum + quantity * price;
        //         }, 0);

        //     const garniturePrice = Array.from(parent.querySelectorAll('.garniture-checkbox'))
        //         .filter((checkbox) => checkbox.checked)
        //         .reduce((sum, checkbox) => {
        //             const quantity = parseInt(
        //                 parent.querySelector(`.quantityGarniture[data-product-id="${checkbox.value}"]`)
        //                 .value
        //             ) || 0;
        //             const price = parseFloat(checkbox.getAttribute('data-price')) || 0;
        //             return sum + quantity * price;
        //         }, 0);

        //     const totalPrice = platQuantity * platPrice + complementPrice + garniturePrice;
        //     parent.querySelector('.price').textContent =
        //         `${totalPrice.toFixed(0).replace(/\B(?=(\d{3})+(?!\d))/g, ' ')} FCFA`;
        // }

        // Attacher les événements pour les boutons + et -
        document.querySelectorAll('.inc').forEach((button) => {
            button.addEventListener('click', function() {
                increaseValue(this);
            });
        });

        document.querySelectorAll('.dec').forEach((button) => {
            button.addEventListener('click', function() {
                decreaseValue(this);
            });
        });

        // Fonction pour ajuster les quantités des garnitures
        function adjustGarnitureQuantities(parent, maxQuantity) {
            const garnitureInputs = parent.querySelectorAll('.quantityGarniture');
            let remainingQuantity = maxQuantity;

            garnitureInputs.forEach((input) => {
                const value = parseInt(input.value) || 0;
                if (value > remainingQuantity) {
                    input.value = remainingQuantity;
                    remainingQuantity = 0;
                } else {
                    remainingQuantity -= value;
                }
            });
        }

        // Fonction pour gérer la limite de sélection des compléments et garnitures
        function manageSelectionLimits(checkboxes, limit) {
            let selectedCount = Array.from(checkboxes).filter((box) => box.checked).length;

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

        // Fonction pour s'assurer que les sélections restent dans les limites
        function ensureSelectionWithinLimits(input) {
            const platId = input.closest(".form-check").querySelector(".plat-checkbox")?.value;

            if (!platId) {
                return;
            }

            const quantity = parseInt(input.value, 10);

            // Décocher les compléments en excès
            const complementCheckboxes = document.querySelectorAll(`.complement-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(complementCheckboxes, quantity);

            // Décocher les garnitures en excès
            const garnitureCheckboxes = document.querySelectorAll(`.garniture-checkbox[data-plat-id="${platId}"]`);
            deselectExcessItems(garnitureCheckboxes, quantity);
        }

        // Fonction pour décocher les éléments en excès
        function deselectExcessItems(checkboxes, limit) {
            let selectedCount = 0;
            checkboxes.forEach((checkbox) => {
                if (checkbox.checked) {
                    selectedCount++;
                    if (selectedCount > limit) {
                        checkbox.checked = false;
                        toggleQuantityVisibility(checkbox, false); // Masquer la quantité associée
                    }
                }
            });
        }

        // Fonction pour afficher ou masquer la quantité en fonction de la sélection
        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            if (quantityWrapper) {
                quantityWrapper.style.display = isVisible ? "block" : "none";

                // Réinitialisation de la quantité à 0 si l'élément est décoché et la quantité est cachée
                if (!isVisible && !checkbox.checked) {
                    const quantityInput = parent.querySelector(".cart-plus-minus-box");
                    if (quantityInput) {
                        quantityInput.value = 0;
                    }
                }
            }
        }

        // Initialisation des événements lors du chargement du document
        document.addEventListener("DOMContentLoaded", function() {
            const platCheckboxes = document.querySelectorAll(".plat-checkbox");
            const complementCheckboxes = document.querySelectorAll(".complement-checkbox");
            const garnitureCheckboxes = document.querySelectorAll(".garniture-checkbox");
            const platInputs = document.querySelectorAll(".cart-plus-minus-box");

            // Mettre à jour les limites dès le chargement pour chaque plat
            platInputs.forEach((input) => {
                updateComplementGarnitureLimits(input);
            });

            // Vérifier l'état initial des cases à cocher et ajuster les champs de quantité
            complementCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function() {
                    toggleQuantityVisibility(this, this.checked);
                    // Coche automatiquement le plat correspondant si une garniture ou un complément est coché
                    const platId = this.dataset.platId;
                    const platCheckbox = document.querySelector(
                        `.plat-checkbox[value="${platId}"]`);
                    if (this.checked && platCheckbox && !platCheckbox.checked) {
                        platCheckbox.checked = true;
                        platCheckbox.dispatchEvent(new Event(
                            "change")); // Déclencher l'événement pour gérer l'état du plat
                    }
                });
            });

            garnitureCheckboxes.forEach((checkbox) => {
                toggleQuantityVisibility(checkbox, checkbox.checked); // Afficher si coché
                checkbox.addEventListener("change", function() {
                    toggleQuantityVisibility(this, this.checked);
                    // Coche automatiquement le plat correspondant si une garniture ou un complément est coché
                    const platId = this.dataset.platId;
                    const platCheckbox = document.querySelector(
                        `.plat-checkbox[value="${platId}"]`);
                    if (this.checked && platCheckbox && !platCheckbox.checked) {
                        platCheckbox.checked = true;
                        platCheckbox.dispatchEvent(new Event(
                            "change")); // Déclencher l'événement pour gérer l'état du plat
                    }
                });
            });

            // Gérer la désélection des garnitures et compléments lorsque le plat est décoché
            platCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener("change", function() {
                    const platId = this.value;
                    const complementCheckboxes = document.querySelectorAll(
                        `.complement-checkbox[data-plat-id="${platId}"]`);
                    const garnitureCheckboxes = document.querySelectorAll(
                        `.garniture-checkbox[data-plat-id="${platId}"]`);

                    if (!this.checked) {
                        // Décocher et désactiver les garnitures et compléments associés
                        complementCheckboxes.forEach((box) => {
                            box.checked = false;
                            toggleQuantityVisibility(box, false); // Masquer la quantité
                        });

                        garnitureCheckboxes.forEach((box) => {
                            box.checked = false;
                            toggleQuantityVisibility(box, false); // Masquer la quantité
                        });
                    }
                });
            });
        });
    </script>


@endsection
