@if (session()->has('cartMenu'))
    <div class="row">
        @foreach (session('cartMenu') as $cartKey => $detailsMenu)
            <div class="col-12 col-lg-6 mb-4" id="platDiv_{{ $cartKey }}">
                <div class="card h-100 p-3">
                    <div class="d-flex align-items-center">
                        <!-- Image du produit -->
                        <div class="product-image me-3">
                            <div style="width: 150px; height: 150px; overflow: hidden;">
                                @if ($detailsMenu['image_plat'])
                                    <img src="{{ $detailsMenu['image_plat'] }}" class="img-fluid"
                                        style="object-fit: cover; width: 100%; height: 100%;"
                                        alt="{{ $detailsMenu['title_plat'] }}">
                                @else
                                    <img src="{{ asset('assets/img/logo/logo_Chez-jeanne.jpg') }}" class="img-fluid"
                                        style="object-fit: cover; width: 100%; height: 100%;"
                                        alt="{{ $detailsMenu['title_plat'] }}">
                                @endif
                            </div>
                        </div>
                        <!-- Détails du produit -->
                        <div class="product-info flex-grow-1">
                            <h6 class="card-title text-uppercase"> {{ $detailsMenu['title_plat'] }} </h6>
                            @if ($detailsMenu['title_complement'])
                                <span class="card-title text-uppercase"> <small>Complement:</small>
                                    {{ $detailsMenu['title_complement'] }} </span><br>
                            @endif
                            @if ($detailsMenu['title_garniture'])
                                <span class="card-title text-uppercase">
                                    <small>Garniture:</small>{{ $detailsMenu['title_garniture'] }} </span>
                            @endif

                            <!-- Prix et quantité -->
                            <div class="d-flex justify-content-between col-sm-12">
                                <div>
                                    <p class="font-weight-bold text-danger">
                                        Prix : {{ number_format($detailsMenu['price'], 0, ',', ' ') }} FCFA
                                    </p>
                                    <div class="product-quantity">
                                        <div class="cart-plus-minus">
                                            <div class="dec qtybutton"
                                                onclick="decrementProductQuantity({{ $cartKey }})">-
                                            </div>
                                            <input data-id="{{ $cartKey }}" id="quantityMenu-{{ $cartKey }}"
                                                class="cart-plus-minus-box" type="text" name="quantityMenu"
                                                value="{{ $detailsMenu['quantity'] }}" min="1" readonly>
                                            <div class="inc qtybutton"
                                                onclick="incrementProductQuantity({{ $cartKey }})">+
                                            </div>
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
                            </div>
                        </div>
                    </div>
                    <button data-id="{{ $cartKey }}" class="btn btn-danger btn-sm me-2"
                        onclick="removeProductFromCart({{ $cartKey }})">Supprimer</button>
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
                    // Mettre à jour l'input de quantité
                    $(`#quantityMenu-${cartKey}`).val(newQuantity);
                    // Mettre à jour la quantité totale dans l'icône du panier
                    $('.totalQuantityMenu').html(response.totalQte);
                    // Mettre à jour le montant total du panier
                    $('.totalPriceMenu').html(response.totalPrice.toLocaleString("fr-FR") + ' FCFA');
                    // Mettre à jour le montant total de ce produit
                    $(`.totalPriceQty-${cartKey}`).html(response.totalPriceQty.toLocaleString("fr-FR") +
                        ' FCFA');

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
                        $('.totalPriceMenu').html(response.totalPrice.toLocaleString("fr-FR") + ' FCFA');

                        // Alerte de succès
                        Swal.fire({
                            title: 'Supprimé !',
                            text: 'Le produit a été retiré du panier.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1000,
                            timerProgressBar: true
                        });
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

</script>
