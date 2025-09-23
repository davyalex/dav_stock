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

    <div class="row g-4">
        <!-- Colonne Produits + Panier -->
        <div class="col-lg-7 col-md-12">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-3 fw-bold text-primary">
                        <i class="ri-store-2-line me-2"></i> Produits disponibles
                    </h5>
                    <div class="mb-4">
                        <select name="produit_id" class="form-select js-example-basic-single product-select">
                            <option value="">Sélectionnez un produit</option>
                            @foreach ($data_produit as $produit)
                                <option value="{{ $produit->id }}" data-price="{{ $produit->prix }}"
                                    data-stock="{{ $produit->stock }}" {{ $produit->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $produit->nom }} {{ $produit->stock <= 0 ? '- (Stock épuisé)' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover align-middle" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Stock</th>
                                    <th>Qté</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamique JS -->
                            </tbody>
                        </table>
                        <div class="alert alert-danger d-none mt-2" role="alert">
                            <span id="errorMessage"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne Totaux + Paiement -->
        <div class="col-lg-5 col-md-12">
            <div class="card mb-4 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="mb-3 fw-bold text-success">
                        <i class="ri-calculator-line me-2"></i> Récapitulatif & Paiement
                    </h5>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>Total ordinaire :</span>
                            <span id="grand-total">0</span> FCFA
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Remise :</span>
                            <span id="discount-amount">0</span> FCFA
                        </div>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total à payer :</span>
                            <span id="total-after-discount">0</span> FCFA
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="discount-type" class="form-label">Type de remise</label>
                            <select id="discount-type" class="form-select" name="discount_type">
                                <option value="percentage">Pourcentage</option>
                                <option value="amount">Montant fixe</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="total-discount" class="form-label">Valeur de la remise</label>
                            <input type="number" id="total-discount" name="total_discount" class="form-control"
                                value="0" min="0">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="payment-method" class="form-label">Mode de paiement</label>
                        <select id="payment-method" name="mode_paiement" class="form-select" required>
                            @foreach ($data_mode_paiement as $item)
                                <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="received-amount" class="form-label">Montant reçu</label>
                        <input type="number" name="montant_recu" id="received-amount" class="form-control" min="0"
                            required>
                    </div>
                    <div class="mb-3">
                        <h5>Monnaie rendu : <span id="change-amount">0</span> FCFA</h5>
                    </div>
                    <button type="button" id="validate-sale" class="btn btn-primary w-100 fw-bold">
                        <i class="ri-check-line me-1"></i> Valider la vente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal confirmation -->
    <div class="modal fade" id="confirmSaleModal" tabindex="-1" aria-labelledby="confirmSaleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmSaleModalLabel">Confirmer la vente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p>Voulez-vous vraiment valider cette vente ?</p>
                    <ul id="recap-list"></ul>
                    <div class="d-flex justify-content-between fw-bold mt-3">
                        <span>Total à payer :</span>
                        <span id="recap-total"></span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Montant reçu :</span>
                        <span id="recap-received"></span>
                    </div>
                    <div class="d-flex justify-content-between mt-2">
                        <span>Monnaie rendu :</span>
                        <span id="recap-change"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-success" id="confirm-sale-btn">Confirmer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            let cart = [];
            let totalDiscountType = 'percentage';
            let totalDiscountValue = 0;

            // Ajout produit au panier
            $('.product-select').change(function() {
                let productId = $(this).val();
                let productName = $(this).find('option:selected').text();
                let productPrice = $(this).find('option:selected').data('price');
                let productStock = $(this).find('option:selected').data('stock');
                if (productId) {
                    let existing = cart.find(item => item.id == productId);
                    if (existing) {
                        if (existing.quantity < productStock) existing.quantity++;
                    } else {
                        cart.push({
                            id: productId,
                            name: productName,
                            price: productPrice,
                            stock: productStock,
                            quantity: 1
                        });
                    }
                    updateCartTable();
                    updateTotals();
                    $(this).val(null).trigger('change');
                }
            });

            // Mise à jour du panier
            function updateCartTable() {
                let tbody = $('#cart-table tbody');
                tbody.empty();
                cart.forEach((item, i) => {
                    tbody.append(`
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.price} FCFA</td>
                        <td>${item.stock}</td>
                        <td>
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary minus-btn" data-index="${i}">-</button>
                                <input type="number" min="1" max="${item.stock}" value="${item.quantity}" class="form-control quantity-input" data-index="${i}" style="width:60px;">
                                <button class="btn btn-outline-secondary plus-btn" data-index="${i}">+</button>
                            </div>
                        </td>
                        <td>${item.price * item.quantity} FCFA</td>
                        <td><button class="btn btn-danger btn-sm remove-btn" data-index="${i}"><i class="ri-delete-bin-2-line"></i></button></td>
                    </tr>
                `);
                });
                $('.alert').addClass('d-none');
            }

            // Boutons +/-
            $(document).on('click', '.plus-btn', function() {
                let i = $(this).data('index');
                if (cart[i].quantity < cart[i].stock) cart[i].quantity++;
                updateCartTable();
                updateTotals();
            });
            $(document).on('click', '.minus-btn', function() {
                let i = $(this).data('index');
                if (cart[i].quantity > 1) cart[i].quantity--;
                updateCartTable();
                updateTotals();
            });
            $(document).on('input', '.quantity-input', function() {
                let i = $(this).data('index');
                let val = parseInt($(this).val());
                if (val > 0 && val <= cart[i].stock) cart[i].quantity = val;
                else $(this).val(cart[i].quantity);
                updateCartTable();
                updateTotals();
            });
            $(document).on('click', '.remove-btn', function() {
                let i = $(this).data('index');
                cart.splice(i, 1);
                updateCartTable();
                updateTotals();
            });

            // Remise
            $('#discount-type').change(function() {
                totalDiscountType = $(this).val();
                if (totalDiscountType === 'percentage' && totalDiscountValue > 100) {
                    totalDiscountValue = 100;
                    $('#total-discount').val(100);
                }
                updateTotals();
            });
            $('#total-discount').on('input', function() {
                totalDiscountValue = parseFloat($(this).val() || 0);
                if (totalDiscountType === 'percentage' && totalDiscountValue > 100) {
                    totalDiscountValue = 100;
                    $(this).val(100);
                }
                updateTotals();
            });

            // Calcul total/remise/monnaie
            function updateTotals() {
                let grandTotal = cart.reduce((sum, item) => sum + item.price * item.quantity, 0);
                let discount = 0;
                if (totalDiscountType === 'percentage') {
                    if (totalDiscountValue > 100) totalDiscountValue = 100;
                    discount = grandTotal * totalDiscountValue / 100;
                } else if (totalDiscountType === 'amount') {
                    discount = totalDiscountValue;
                }
                let totalNet = grandTotal - discount;
                if (totalNet < 0) totalNet = 0;
                $('#grand-total').text(grandTotal);
                $('#discount-amount').text(discount);
                $('#total-after-discount').text(totalNet);
                updateChange();
            }

            // Monnaie
            $('#received-amount').on('input', updateChange);

            function updateChange() {
                let received = parseFloat($('#received-amount').val() || 0);
                let toPay = parseFloat($('#total-after-discount').text() || 0);
                let change = received - toPay;
                $('#change-amount').text(change < 0 ? 0 : change);
            }

            // Validation vente avec confirmation
            $('#validate-sale').click(function() {
                if (cart.length === 0) {
                    $('#errorMessage').text('Ajoutez au moins un produit au panier.');
                    $('.alert').removeClass('d-none');
                    return;
                }
                let received = parseFloat($('#received-amount').val() || 0);
                let toPay = parseFloat($('#total-after-discount').text() || 0);
                if (received < toPay) {
                    $('#errorMessage').text('Le montant reçu est inférieur au montant à payer.');
                    $('.alert').removeClass('d-none');
                    return;
                }
                // Remplir le récapitulatif du modal
                let recapList = '';
                cart.forEach(item => {
                    recapList +=
                        `<li>${item.name} x ${item.quantity} = <strong>${item.price * item.quantity} FCFA</strong></li>`;
                });
                $('#recap-list').html(recapList);
                $('#recap-total').text(toPay + ' FCFA');
                $('#recap-received').text(received + ' FCFA');
                $('#recap-change').text((received - toPay) + ' FCFA');
                $('#confirmSaleModal').modal('show');
            });

            // Confirmation finale
            $('#confirm-sale-btn').click(function() {
                // Préparation des données à envoyer
                let received = parseFloat($('#received-amount').val() || 0);
                let beforePay = parseFloat($('#grand-total').text() || 0);
                let toPay = parseFloat($('#total-after-discount').text() || 0);
                let modePaiement = $('#payment-method').val();
                let discountType = $('#discount-type').val();
                let discountValue = parseFloat($('#total-discount').val() || 0);

                let data = {
                    cart: cart,
                    montant_recu: received,
                    montant_avant_remise: beforePay,
                    montant_total: toPay,
                    mode_paiement: modePaiement,
                    discount_type: discountType,
                    discount_value: discountValue,
                    _token: '{{ csrf_token() }}'
                };

                // Désactiver le bouton pour éviter les doubles clics
                $('#confirm-sale-btn').prop('disabled', true);

                $.ajax({
                    url: "{{ route('vente.store') }}",
                    method: "POST",
                    data: data,
                    success: function(response) {
                        $('#confirmSaleModal').modal('hide');
                        $('#confirm-sale-btn').prop('disabled', false);
                        if (response.status === 'success') {
                            window.location.href =
                                '{{ route('vente.show', ':idVente') }}'
                                .replace(':idVente', response.idVente);
                        } else {
                            $('#errorMessage').text(response.message ||
                                'Erreur lors de l\'enregistrement.');
                            $('.alert').removeClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        $('#confirmSaleModal').modal('hide');
                        $('#confirm-sale-btn').prop('disabled', false);
                        $('#errorMessage').text('Erreur serveur, veuillez réessayer.');
                        $('.alert').removeClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
