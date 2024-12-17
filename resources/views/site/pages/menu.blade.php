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
                                                            <div
                                                                class="{{ $plat->garnitures->isNotEmpty() ? 'col-6' : 'col-12' }}">
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
                                                                                            min="1" readonly>
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
                                                            <div
                                                                class="{{ $plat->complements->isNotEmpty() ? 'col-6' : 'col-12' }}">
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
                                                                                            min="1" readonly>
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

                <button type="button" class="btn btn-danger addCart text-white w-100 mt-3"
                    style="border-radius: 5px; font-size: 20px;">
                    <i class="fa fa-shopping-cart"></i> Commander
                </button>
            @endif
        </div>
        @include('site.components.ajouter-au-panier-menu')
    </div>



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

            if (garnitureQuantities >= platQuantity) {
                adjustGarnitureQuantities(parent, platQuantity);
            } else {

                // Permettre de cocher d'autres options si platQuantity est inférieur
                parent.querySelectorAll('.garniture-checkbox').forEach((checkbox) => {
                    checkbox.disabled = false;
                });
            }


            // Gestion des quantités des compléments
            const complementQuantities = Array.from(
                parent.querySelectorAll('.quantityComplement')
            ).reduce((sum, input) => sum + (parseInt(input.value) || 0), 0);

            if (complementQuantities >= platQuantity) {
                adjustComplementQuantities(parent, platQuantity);
            } else {
                // Permettre de cocher d'autres options si platQuantity est inférieur
                parent.querySelectorAll('.complement-checkbox').forEach((checkbox) => {
                    checkbox.disabled = false;
                });
            }

            // Mise à jour des prix
            // updateTotalPrice(parent);
        }


        // Fonction pour ajuster les quantités des compléments
        // function adjustComplementQuantities(parent, maxQuantity) {
        //     const complementInputs = parent.querySelectorAll('.quantityComplement');
        //     let remainingQuantity = maxQuantity;

        //     complementInputs.forEach((input) => {
        //         const value = parseInt(input.value) || 0;
        //         if (value > remainingQuantity) {
        //             input.value = remainingQuantity;
        //             remainingQuantity = 0;
        //         } else {
        //             remainingQuantity -= value;
        //         }
        //     });
        // }




        // Fonction pour ajuster les quantités des garnitures
        // function adjustGarnitureQuantities(parent, maxQuantity) {
        //     const garnitureInputs = parent.querySelectorAll('.quantityGarniture');
        //     let remainingQuantity = maxQuantity;

        //     garnitureInputs.forEach((input) => {
        //         const value = parseInt(input.value) || 0;
        //         if (value > remainingQuantity) {
        //             input.value = remainingQuantity;
        //             remainingQuantity = 0;
        //         } else {
        //             remainingQuantity -= value;
        //         }
        //     });
        // }


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

                // Si la quantité tombe à 0 , décocher, désactiver et cacher
                if (parseInt(input.value) === 0) {
                    const checkbox = input.closest('.form-check').querySelector('.complement-checkbox');
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                        toggleQuantityVisibility(checkbox, false);
                    }
                }
            });
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

                // Si la quantité tombe à 0  , décocher, désactiver et cacher
                if (parseInt(input.value) === 0) {
                    const checkbox = input.closest('.form-check').querySelector('.garniture-checkbox');
                    if (checkbox) {
                        checkbox.checked = false;
                        checkbox.disabled = true;
                        toggleQuantityVisibility(checkbox, false);
                    }
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
        // function toggleQuantityVisibility(checkbox, isVisible) {
        //     const parent = checkbox.closest(".form-check");
        //     const quantityWrapper = parent.querySelector(".product-quantity");
        //     if (quantityWrapper) {
        //         quantityWrapper.style.display = isVisible ? "block" : "none";

        //         // Réinitialisation de la quantité à 0 si l'élément est décoché et la quantité est cachée
        //         // a 1 si l'élément est sélectionné et la quantité est visible
        //         if (!isVisible && !checkbox.checked) {
        //             const quantityInput = parent.querySelector(".cart-plus-minus-box");
        //             if (quantityInput) {
        //                 quantityInput.value = 0;
        //             }
        //         } else {
        //             const quantityInput = parent.querySelector(".cart-plus-minus-box");
        //             if (quantityInput) {
        //                 quantityInput.value = 1;
        //             }
        //         }
        //     }
        // }



        function toggleQuantityVisibility(checkbox, isVisible) {
            const parent = checkbox.closest(".form-check");
            const quantityWrapper = parent.querySelector(".product-quantity");
            const quantityInput = parent.querySelector(".cart-plus-minus-box");

            if (quantityWrapper && quantityInput) {
                // Afficher ou masquer la section quantité
                quantityWrapper.style.display = isVisible ? "block" : "none";

                if (checkbox.checked) {
                    // Si l'élément est coché et que la quantité est vide, initialiser à 1
                    if (!quantityInput.value || quantityInput.value == 0) {
                        quantityInput.value = 1;
                    }
                } else {
                    // Si l'élément est décoché, la quantité devient 0
                    quantityInput.value = 0;
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
