@if (session()->has('cartMenu'))
    <div class="row">
        @foreach (session('cartMenu') as $cartKey => $detailsMenu)
            {{-- <div class="col-12 col-lg-6 mb-4" id="platDiv_{{ $cartKey }}">
                <div class="card h-100 p-3">
                    <div class="d-flex flex-column">
                        <!-- Catégorie -->
                        <div>
                            <h6 class="text-italic text-danger fs-8">Catégorie : {{ $detailsMenu['categorie_menu'] }}
                            </h6>
                        </div>

                        <!-- Nom du plat -->
                        <div>
                            <h5 class="card-title text-uppercase">Plat : {{ $detailsMenu['plat_name'] }}</h5>
                        </div>

                        <!-- Compléments -->
                        @if (!empty($detailsMenu['complements']))
                            <div>
                                <h6 class="card-title text-capitalize"><small>Compléments :</small></h6>
                                <ul>
                                    @foreach ($detailsMenu['complements'] as $item)
                                        <li>
                                            {{ $item['nom'] }} (Quantité : {{ $item['quantity'] }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Garnitures -->
                        @if (!empty($detailsMenu['garnitures']))
                            <div>
                                <h6 class="card-title text-capitalize"><small>Garnitures :</small></h6>
                                <ul>
                                    @foreach ($detailsMenu['garnitures'] as $item)
                                        <li>
                                            {{ $item['nom'] }} (Quantité : {{ $item['quantity'] }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Prix et quantité -->
                        <div>
                            <p class="font-weight-bold text-danger">
                                Prix : {{ number_format($detailsMenu['price'], 0, ',', ' ') }} FCFA
                            </p>
                            <div class="product-quantity">
                                <div class="cart-plus-minus">
                                    <div class="dec qtybutton" onclick="decrementProductQuantity({{ $cartKey }})">-
                                    </div>
                                    <input data-id="{{ $cartKey }}" id="quantityMenu-{{ $cartKey }}"
                                        class="cart-plus-minus-box" type="text" name="quantityMenu"
                                        value="{{ $detailsMenu['quantity'] }}" min="1" readonly>
                                    <div class="inc qtybutton" onclick="incrementProductQuantity({{ $cartKey }})">
                                        +</div>
                                </div>
                            </div>
                            <p class="font-weight-bold text-danger">
                                Total :
                                <span class="totalPriceQty-{{ $cartKey }}">
                                    {{ number_format($detailsMenu['price'] * $detailsMenu['quantity'], 0, ',', ' ') }}
                                    FCFA
                                </span>
                            </p>
                        </div>

                        <!-- Bouton supprimer -->
                        <button data-id="{{ $cartKey }}" class="btn btn-danger btn-sm mt-2"
                            onclick="removeProductFromCart({{ $cartKey }})">Supprimer</button>
                    </div>
                </div>
            </div> --}}


            <div class="col-12 col-lg-6 mb-4" id="platDiv_{{ $cartKey }}">
                <div class="card h-100 p-3">
                    <!-- Bouton supprimer (icône en haut à droite) -->
                    <div class="d-flex justify-content-end position-absolute top-0 end-0 m-2">
                        <button data-id="{{ $cartKey }}" class="btn btn-danger btn-sm me-2"
                            onclick="removeProductFromCart({{ $cartKey }})">
                            <i class=" fa fa-trash"></i>
                        </button>
                        <a href="{{route('menu')}}" class="btn btn-primary btn-sm">
                            <i class=" fa fa-plus"></i>
                        </a>
                    </div>

                    <div class="d-flex flex-column">
                        <!-- Catégorie -->
                        <div>
                            <h6 class="text-italic text-danger fs-8">Catégorie : {{ $detailsMenu['categorie_menu'] }}
                            </h6>
                        </div>

                        <!-- Nom du plat -->
                        <div>
                            <h5 class="card-title text-uppercase">{{ $detailsMenu['plat_name'] }} * <span
                                    class="text-danger">{{ $detailsMenu['quantity'] }}</span></h5>
                        </div>

                        <!-- Compléments -->
                        @if (!empty($detailsMenu['complements']))
                            <div class="ms-3">
                                <h6 class="card-title text-capitalize fw-bold"><small>Compléments :</small></h6>
                                <ul class="ms-4">
                                    @foreach ($detailsMenu['complements'] as $item)
                                        <li>
                                            {{ $item['nom'] }} (Qté : {{ $item['quantity'] }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Garnitures -->
                        @if (!empty($detailsMenu['garnitures']))
                            <div class="ms-3 mt-3">
                                <h6 class="card-title text-capitalize fw-bold"><small>Garnitures :</small></h6>
                                <ul class="ms-4">
                                    @foreach ($detailsMenu['garnitures'] as $item)
                                        <li>
                                            {{ $item['nom'] }} (Qté : {{ $item['quantity'] }})
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <!-- Prix et quantité -->
                        <div>
                            <p class="font-weight-bold text-danger mt-3">
                                Prix : {{ number_format($detailsMenu['price'], 0, ',', ' ') }} FCFA *
                                {{ $detailsMenu['quantity'] }}
                            </p>
                            {{-- <div class="product-quantity" style="width: 80px">
                                <div class="cart-plus-minus">
                                    <div class="dec qtybutton" onclick="decrementProductQuantity({{ $cartKey }})">
                                        -</div>
                                    <input data-id="{{ $cartKey }}" id="quantityMenu-{{ $cartKey }}"
                                        class="cart-plus-minus-box" type="text" name="quantityMenu"
                                        value="{{ $detailsMenu['quantity'] }}" min="1" readonly>
                                    <div class="inc qtybutton" onclick="incrementProductQuantity({{ $cartKey }})">
                                        +</div>
                                </div>
                            </div> --}}
                            <p class="font-weight-bold text-danger fs-6">
                                TOTAL :
                                <span class="totalPriceQty-{{ $cartKey }}">
                                    {{ number_format($detailsMenu['price'] * $detailsMenu['quantity'], 0, ',', ' ') }}
                                    FCFA
                                </span>
                            </p>

                            {{-- <div class="text-center">
                                <a href="{{route('menu')}}" class="btn btn-dark btn-sm">
                                    Completer ma selection <i class=" fa fa-plus"></i>
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif




<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css
" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>


<script type="text/javascript">
    // Gestion du panier
    // Fonction pour augmenter la quantité
    function incrementProductQuantity(cartKey) {

        let quantityInput = $(`#quantityMenu-${cartKey}`);
        let currentQuantity = parseInt(quantityInput.val());

        if (currentQuantity >= 1) {
            let newQuantity = currentQuantity + 1;
            updateProductCartQuantity(cartKey, newQuantity);
        }
    }

    // Fonction pour diminuer la quantité
    function decrementProductQuantity(cartKey) {
        let quantityInput = $(`#quantityMenu-${cartKey}`);
        let currentQuantity = parseInt(quantityInput.val());

        if (currentQuantity > 1) {
            let newQuantity = currentQuantity - 1;
            updateProductCartQuantity(cartKey, newQuantity);
        }
    }

    // Fonction pour mettre à jour la quantité dans le panier
    function updateProductCartQuantity(cartKey, newQuantity) {
        $.ajax({
            url: "{{ route('cart.update-menu') }}", // La route pour la mise à jour du panier
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cart_key: cartKey, // Passer la clé unique du plat
                quantityMenu: newQuantity
            },
            success: function(response) {
                if (response.status === 'success') {
                    console.log(response);

                    // Mettre à jour l'input de quantité
                    $(`#quantityMenu-${cartKey}`).val(newQuantity);
                    // Mettre à jour la quantité totale dans l'icône du panier
                    $('.totalQuantityMenu').html(response.totalQte);
                    // Mettre à jour le montant total du panier
                    $('.totalPriceMenu').html(response.totalPrice.toLocaleString("fr-FR") + ' FCFA');
                    // Mettre à jour le montant total de ce produit
                    $(`.totalPriceQty-${cartKey}`).html(response.totalPriceQty.toLocaleString("fr-FR") +
                        ' FCFA');


                    // // mise des infos du topBr 2
                    $('.totalQuantityTop').html(response.qteNet);
                    // Mettre à jour le montant total du panier
                    $('.totalPriceTop').html(response.priceNet.toLocaleString("fr-FR") + ' FCFA');


                    // Mise a jour total global
                    $('.totalNet').html(response.priceNet.toLocaleString("fr-FR") + ' FCFA');


                    // Alerte de succès
                    Swal.fire({
                        title: 'Mise à jour !',
                        text: 'Quantité modifiée avec succès.',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1000,
                        timerProgressBar: true
                    });
                } else {
                    alert("Erreur lors de la mise à jour du panier.");
                }
            },
            error: function() {
                alert("Une erreur s'est produite lors de la mise à jour.");
            }
        });
    }


    // function incrementProductQuantity(button) {
    //     // Récupérer le parent le plus proche contenant le champ input
    //     const input = button.parentElement.querySelector(".cart-plus-minus-box");
    //     let currentValue = parseInt(input.value);
    //     input.value = currentValue + 1;
    // }

    // function decrementProductQuantity(button) {
    //     // Récupérer le parent le plus proche contenant le champ input
    //     const input = button.parentElement.querySelector(".cart-plus-minus-box");
    //     let currentValue = parseInt(input.value);
    //     if (currentValue > 1) {
    //         input.value = currentValue - 1;
    //     }
    // }



    //Fonction pour supprimer un produit du panier
    function removeProductFromCart(cartKey) {
        // Demande de confirmation avant suppression
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            text: "Voulez-vous supprimer ce produit du panier ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Oui, supprimer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('cart.remove-menu') }}", // Route Laravel pour supprimer un produit
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        cart_key: cartKey // Identifiant unique du produit dans le panier
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Supprimer le produit de l'interface
                            $(`#platDiv_${cartKey}`).remove();
                            // Mettre à jour la quantité totale
                            $('.totalQuantityMenu').html(response.totalQte);
                            // Mettre à jour le prix total
                            $('.totalPriceMenu').html(response.totalPrice.toLocaleString("fr-FR") +
                                ' FCFA');


                            // // mise des infos du topBr 2
                            $('.totalQuantityTop').html(response.qteNet);
                            // Mettre à jour le montant total du panier
                            $('.totalPriceTop').html(response.priceNet.toLocaleString("fr-FR") +
                                ' FCFA');
                            // Mise a jour total global
                            $('.totalNet').html(response.priceNet.toLocaleString("fr-FR") +
                                ' FCFA');

                            // Alerte de succès
                            Swal.fire({
                                title: 'Supprimé !',
                                text: 'Le produit a été retiré du panier.',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000,
                                timerProgressBar: true
                            });


                            //rafraichir la page si panier vide
                            if (response.totalQte == 0) {
                                window.location.href = "{{ route('panier') }}";
                            }

                        } else {
                            alert("Erreur lors de la suppression du produit.");
                        }
                    },
                    error: function() {
                        alert("Une erreur s'est produite lors de la suppression.");
                    }
                });
            }
        });
    }



    // recuperer les nfos panier menu
    function updateCartInfo() {
        $.ajax({
            url: '{{ route('cart.getInfo-menu') }}',
            method: 'GET',
            success: function(data) {
                $('.totalQuantityMenu').text(data.totalQte);
                $('.totalPriceMenu').html(
                    new Intl.NumberFormat('fr-FR', {
                        minimumFractionDigits: 0
                    }).format(data.totalPrice) + ' FCFA'
                );
                // Optionnel : Mettre à jour l'affichage des items du panier
                // updateCartItems(data.cartMenu);
            },
            error: function() {
                console.error('Erreur lors de la récupération des données du panier.');
            }
        });
    }

    // Appeler cette fonction lorsque nécessaire, par exemple après un ajout au panier
    updateCartInfo();
</script>
