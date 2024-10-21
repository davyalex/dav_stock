@extends('backend.layouts.master')
@section('title')
    Vente
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Vente
        @endslot
        @slot('title')
            Point de Vente
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Sélection des produits</h4>
                    <select id="product-select" name="produit_id" class="form-select js-example-basic-single">
                        <option value="">Sélectionnez un produit</option>
                        @foreach ($data_produit as $produit)
                            <option value="{{ $produit->id }}" data-price="{{ $produit->prix }}">
                                {{ $produit->nom }} {{ $produit->valeur_unite ?? '' }} {{ $produit->unite->libelle ?? '' }}
                                {{ $produit->unite ? '(' . $produit->unite->abreviation . ')' : '' }}
                                ({{ $produit->prix }} FCFA)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Panier</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="cart-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix unitaire</th>
                                    <th>Quantité</th>
                                    {{-- <th>Remise (%)</th> --}}
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>


                    <!-- Total geral, remise e montant depois da remise -->
                    <div class="text-end mt-3">
                        <h4>Sous Total : <span id="grand-total">0</span> FCFA</h4>
                        <h4>Total remise : <span id="discount-amount">0</span> FCFA</h4>
                        <h4>Total TTC : <span id="total-after-discount">0</span> FCFA</h4>
                    </div>

                    <!-- Seleção do tipo de remise e remise -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="discount-type">Type de remise</label>
                            <select id="discount-type" class="form-select" name="discount_type">
                                <option selected disabled value="">Selectionner</option>
                                <option value="percentage">Pourcentage</option>
                                <option value="amount">Montant fixe</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="total-discount">Valeur de la remise</label>
                            <input type="number" id="total-discount" name="total_discount" class="form-control"
                                value="0" min="0">
                        </div>
                    </div>


                    <!-- Numéro de table et nombre de couverts -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="table-number">Numéro de table</label>
                            <input type="number" name="numero_table" id="table-number" class="form-control"
                                placeholder="Numéro de table" min="1">
                        </div>

                        <div class="col-md-6">
                            <label for="number-covers">Nombre de couverts</label>
                            <input type="number" name="nombre_couverts" id="number-covers" class="form-control"
                                value="1" min="1">
                        </div>
                    </div>

                    <!-- Informations de<|pad|>glement -->
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="payment-method">Mode du réglement</label>
                            <select id="payment-method" name="mode_reglement" class="form-select" required>
                                <option value="orange money">Orange Money</option>
                                <option value="moov money">Moov Money</option>
                                <option value="mtn money">MTN Money</option>
                                <option value="wave">Wave</option>
                                <option value="visa">Visa</option>
                                <option value="mastercard">MasterCard</option>
                                <option value="espece">Espèce</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="received-amount">Montant réçu</label>
                            <input type="number" name="montant_recu" id="received-amount" class="form-control"
                                value="0" min="0" required>
                        </div>
                    </div>

                    <div class="text-end mt-3">
                        <h4>Montant rendu : <span id="change-amount">0</span> FCFA</h4>
                    </div>

                    <!-- Bouton de validation -->
                    <div class="mt-3">
                        <button type="button" id="validate-sale" class="btn btn-primary">Valider la vente</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let cart = [];
            let totalDiscountType = 'percentage';
            let totalDiscountValue = 0;
            let grandTotal = 0;

            $('#product-select').change(function() {
                let productId = $(this).val();
                let productName = $(this).find('option:selected').text();
                let productPrice = $(this).find('option:selected').data('price');

                if (productId) {
                    addToCart(productId, productName, productPrice);
                    updateCartTable();
                    updateGrandTotal();
                }
            });

            $('#discount-type').change(function() {
                totalDiscountType = $(this).val() || 0;
                updateGrandTotal();
            });

            $('#total-discount').on('input', function() {
                totalDiscountValue = parseFloat($(this).val() || 0);
                updateGrandTotal();
            });

            $('#received-amount').on('input', function() {
                updateChangeAmount();
            });

            function addToCart(id, name, price) {
                let existingItem = cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1,
                        discount: 0
                    });
                }
            }

            function updateCartTable() {
                let tbody = $('#cart-table tbody');
                tbody.empty();
                cart.forEach((item, index) => {
                    tbody.append(`
                        <tr>
                            <td>${item.name}</td>
                            <td>${item.price} FCFA</td>
                            <td>
                                <button class="btn btn-secondary btn-sm decrease-qty" data-index="${index}">-</button>
                                <input readonly type="number" class="form-control quantity-input d-inline-block text-center" value="${item.quantity}" min="1" style="width: 60px;" data-index="${index}">
                                <button class="btn btn-secondary btn-sm increase-qty" data-index="${index}">+</button>
                            </td>
                            <td class="d-none">
                                <input type="number" class="form-control discount-input" value="${item.discount}" min="0" max="100" data-index="${index}">
                            </td>
                            <td>${calculateTotal(item)} FCFA</td>
                            <td><button class="btn btn-danger btn-sm remove-item" data-index="${index}">Supprimer</button></td>
                        </tr>
                    `);
                });
            }
            // Calculate total au niveau ligne produit (prix * quantité - remise)
            function calculateTotal(item) {
                let discountAmount = (item.price * item.quantity) * (item.discount / 100);
                return (item.price * item.quantity) - discountAmount;
            }


            //calculate grand total
            function updateGrandTotal() {
                grandTotal = cart.reduce((sum, item) => sum + calculateTotal(item), 0);
                let discountAmount = 0;
                libellePourcentage = ''; // libelle FCFA OU Pourcentage
                if (totalDiscountType === 'percentage') {
                    discountAmount = (grandTotal * totalDiscountValue) / 100;
                    // libellePourcentage = '%';
                } else if (totalDiscountType === 'amount') {
                    discountAmount = totalDiscountValue;
                    // libellePourcentage = 'FCFA';
                }

                //total apres la remise
                let totalAfterDiscount = grandTotal - discountAmount;
                totalAfterDiscount = totalAfterDiscount < 0 ? 0 : totalAfterDiscount;

                $('#grand-total').text(grandTotal); // total avant la remise
                $('#discount-amount').text(discountAmount); // remise
                $('#total-after-discount').text(totalAfterDiscount); // total apres la remise

                updateChangeAmount(); // pour la monnaie rendu
            }

            // calcul pour la monnaie rendu
            function updateChangeAmount() {
                let receivedAmount = parseFloat($('#received-amount').val() || 0);
                let totalAfterDiscount = parseFloat($('#total-after-discount').text());
                let changeAmount = receivedAmount - totalAfterDiscount;

                $('#change-amount').text(changeAmount < 0 ? 0 : changeAmount);
            }

            $(document).on('click', '.increase-qty', function() {
                let index = $(this).data('index');
                cart[index].quantity += 1;
                updateCartTable();
                updateGrandTotal();
            });

            $(document).on('click', '.decrease-qty', function() {
                let index = $(this).data('index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity -= 1;
                    updateCartTable();
                    updateGrandTotal();
                }
            });

            $(document).on('change', '.quantity-input', function() {
                let index = $(this).data('index');
                let newQuantity = parseInt($(this).val());
                if (newQuantity >= 1) {
                    cart[index].quantity = newQuantity;
                    updateCartTable();
                    updateGrandTotal();
                }
            });

            // remise sur la ligne produit
            $(document).on('change', '.discount-input', function() {
                let index = $(this).data('index');
                let newDiscount = parseInt($(this).val());
                cart[index].discount = newDiscount;
                updateCartTable();
                updateGrandTotal();
            });

            $(document).on('click', '.remove-item', function() {
                let index = $(this).data('index');
                cart.splice(index, 1);
                updateCartTable();
                updateGrandTotal();
            });


            $('#validate-sale').click(function(e) {
                let montantAvantRemise = parseFloat($('#grand-total').text() || 0);
                let montantApresRemise = parseFloat($('#total-after-discount').text() || 0);
                let montantRemise = parseFloat($('#discount-amount').text() || 0);
                let typeRemise = $('#discount-type').val();
                let valeurRemise = $('#total-discount').val();

                let modePaiement = $('#payment-method').val(); // mode de paiement²
                let montantRecu = parseFloat($('#received-amount').val() || 0); // montant recu
                let montantRendu = parseFloat($('#change-amount').text() || 0);

                let numeroDeTable = $('#table-number').val();
                let nombreDeCouverts = $('#number-covers').val();



                if (cart.length === 0) {

                    Swal.fire({
                        title: 'Erreur',
                        text: 'Aucun produit n\'a été ajouté au panier',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                } else if (montantRecu === 0 || montantRecu < montantApresRemise) {

                    Swal.fire({
                        title: 'Erreur',
                        text: 'Veuillez verifier le montant reçu',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    // Données à envoyer au contrôleur
                    let data = {
                        cart: cart,
                        montantAvantRemise: montantAvantRemise,
                        montantApresRemise: montantApresRemise,
                        montantRemise: montantRemise,
                        typeRemise: typeRemise,
                        valeurRemise: valeurRemise,
                        modePaiement: modePaiement,
                        montantRecu: montantRecu,
                        montantRendu: montantRendu,
                        numeroDeTable: numeroDeTable,
                        nombreDeCouverts: nombreDeCouverts,

                        _token: '{{ csrf_token() }}' // N'oubliez pas d'ajouter le token CSRF
                    };

                    // Envoi des données au contrôleur via AJAX
                    $.ajax({
                        url: '{{ route('vente.store') }}', // Remplacez par votre route
                        method: 'POST',
                        data: data,
                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: 'Vente validée avec succès !',
                                });


                                cart = []; // Réinitialiser le panier après validation
                                updateCartTable();
                                updateGrandTotal();
                                $('#received-amount').val(0); // Réinitialiser les champs
                                $('#table-number').val('');
                                $('#number-covers').val(1);

                                window.location.href = '{{ route('vente.show', ':idVente') }}'
                                    .replace(':idVente', response.idVente);

                            }


                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Erreur lors de la validation de la vente. Veuillez réessayer.',
                            });
                        }
                    });
                }
            });



        });
    </script>
@endsection
