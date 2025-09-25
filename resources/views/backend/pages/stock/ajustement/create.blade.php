@extends('backend.layouts.master')
@section('title')
    Ajustement de stock
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Stock
        @endslot
        @slot('title')
            Ajustement de stock
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Sélectionner des produits à ajuster</h4>
                    <div class="row align-items-end">
                        <div class="col-md-9 mb-3">
                            <label for="product-select" class="form-label fw-semibold">Produit</label>
                            <select id="product-select" name="produit_id" class="form-select js-example-basic-single">
                                <option value="">Sélectionnez un produit</option>
                                @foreach ($data_produit as $produit)
                                    <option value="{{ $produit->id }}" 
                                        data-stock="{{ $produit->stock }}" >
                                        {{ $produit->nom }} {{ $produit->stock <= 0 ? '- (Stock épuisé)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="col-md-3 mb-3">
                            <label for="ajustement-type" class="form-label fw-semibold">Type d'ajustement</label>
                            <select id="ajustement-type" class="form-select">
                                <option value="" selected>Sélectionnez</option>
                                <option value="ajouter">Ajouter</option>
                                <option value="reduire">Réduire</option>
                            </select>
                        </div> --}}
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-semibold" for="currentDate">Date d'ajustement <span
                                    class="text-danger">*</span></label>
                            <input type="datetime-local" id="currentDate" value="{{ date('Y-m-d\TH:i') }}"
                                name="date_ajustement" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Liste des produits à ajuster</h4>
                    <div class="table-responsive">
                        <div class="alert alert-danger d-none" role="alert">
                            <span id="errorMessage"></span>
                        </div>
                        <table class="table table-bordered align-middle" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Stock disponible</th>
                                    <th>Type ajustement</th>
                                    <th>Quantité à ajuster</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamique JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        <button id="submitAjustement" class="btn btn-success w-100">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Enregistrer l'ajustement
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let cart = [];
        $(document).ready(function() {
            $('#product-select').change(function() {
                let produitId = $(this).val();
                let produitNom = $(this).find('option:selected').text();
                let stockDisponible = $(this).find('option:selected').data('stock');
                let typeAjustement = $('#ajustement-type').val();
                if (produitId && !cart.find(item => item.id == produitId)) {
                    cart.push({
                        id: produitId,
                        nom: produitNom,
                        stock_disponible: stockDisponible,
                        type_ajustement: typeAjustement,
                        quantity: 1
                    });
                    renderCart();
                    $('#errorMessage').parent().addClass('d-none');
                }
            });

            $('#ajustement-type').change(function() {
                let typeAjustement = $(this).val();
                cart = cart.map(item => ({
                    ...item,
                    type_ajustement: typeAjustement
                }));
                renderCart();
            });

            $(document).on('input', '.quantity-input', function() {
                let produitId = $(this).data('id');
                let qty = parseInt($(this).val());
                let item = cart.find(i => i.id == produitId);

                // Si "réduire" est choisi, empêcher de saisir plus que le stock disponible
                if (item.type_ajustement === 'reduire' && qty > item.stock_disponible) {
                    qty = item.stock_disponible;
                    $(this).val(qty);
                    $('#errorMessage').text('La quantité à réduire ne peut pas dépasser le stock disponible.').parent().removeClass('d-none');
                } else {
                    $('#errorMessage').parent().addClass('d-none');
                }
                cart = cart.map(item => item.id == produitId ? { ...item, quantity: qty } : item);
            });

            $(document).on('click', '.plus-btn', function() {
                let produitId = $(this).data('id');
                let item = cart.find(i => i.id == produitId);
                // Si "réduire", empêcher d'incrémenter au-delà du stock disponible
                if (item.type_ajustement === 'reduire') {
                    if (item.quantity < item.stock_disponible) {
                        item.quantity += 1;
                        $('#errorMessage').parent().addClass('d-none');
                    } else {
                        $('#errorMessage').text('La quantité à réduire ne peut pas dépasser le stock disponible.').parent().removeClass('d-none');
                    }
                } else {
                    item.quantity += 1;
                    $('#errorMessage').parent().addClass('d-none');
                }
                renderCart();
            });

            $(document).on('click', '.minus-btn', function() {
                let produitId = $(this).data('id');
                cart = cart.map(item => item.id == produitId ? {
                    ...item,
                    quantity: Math.max(1, item.quantity - 1)
                } : item);
                renderCart();
            });

            $(document).on('click', '.remove-btn', function() {
                let produitId = $(this).data('id');
                cart = cart.filter(item => item.id != produitId);
                renderCart();
            });

            function renderCart() {
                let tbody = '';
                cart.forEach((item, idx) => {
                    tbody += `<tr>
                    <td>${item.nom}</td>
                    <td>${item.stock_disponible}</td>
                    <td>
                        <select class="form-select form-select-sm type-ajustement-select" data-id="${item.id}">
                            <option value="" ${!item.type_ajustement ? 'selected' : ''}>Sélectionnez</option>
                            <option value="ajouter" ${item.type_ajustement === 'ajouter' ? 'selected' : ''}>Ajouter</option>
                            <option value="reduire" ${item.type_ajustement === 'reduire' ? 'selected' : ''}>Réduire</option>
                        </select>
                    </td>
                    <td>
                        <div class="input-group" style="max-width:140px;">
                            <button class="btn btn-outline-secondary btn-sm minus-btn" type="button" data-id="${item.id}">-</button>
                            <input type="number" min="1" value="${item.quantity}" class="form-control quantity-input" data-id="${item.id}" style="text-align:center;">
                            <button class="btn btn-outline-secondary btn-sm plus-btn" type="button" data-id="${item.id}">+</button>
                        </div>
                    </td>
                    <td><button class="btn btn-danger btn-sm remove-btn" data-id="${item.id}"><i class="ri-delete-bin-2-line"></i></button></td>
                </tr>`;
                });
                $('#cart-table tbody').html(tbody);
            }

            $(document).on('change', '.type-ajustement-select', function() {
                let produitId = $(this).data('id');
                let typeAjustement = $(this).val();
                cart = cart.map(item => item.id == produitId ? { ...item, type_ajustement: typeAjustement } : item);

                // Si "réduire" est choisi, vérifier la quantité
                let item = cart.find(i => i.id == produitId);
                if (typeAjustement === 'reduire' && item.quantity > item.stock_disponible) {
                    item.quantity = item.stock_disponible;
                    renderCart();
                    $('#errorMessage').text('La quantité à réduire ne peut pas dépasser le stock disponible.').parent().removeClass('d-none');
                } else {
                    $('#errorMessage').parent().addClass('d-none');
                }
            });

            $('#submitAjustement').click(function() {
                let dateAjustement = $('#currentDate').val();
                let erreur = '';

                if (!dateAjustement || cart.length == 0) {
                    erreur = 'Veuillez renseigner la date et ajouter au moins un produit.';
                } else {
                    // Vérifier que chaque produit a un type d'ajustement
                    let ligneSansType = cart.find(item => !item.type_ajustement);
                    if (ligneSansType) {
                        erreur = 'Veuillez sélectionner le type d\'ajustement pour chaque produit.';
                    }
                }

                if (erreur) {
                    $('#errorMessage').text(erreur).parent().removeClass('d-none');
                    return;
                }

                $('#errorMessage').parent().addClass('d-none');
                $(this).find('.spinner-border').removeClass('d-none');
                $.ajax({
                    url: "{{ route('ajustement.store') }}",
                    method: 'POST',
                    data: {
                        date_ajustement: dateAjustement,
                        cart: cart,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.href = "{{ route('ajustement.index') }}";
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message ||
                            'Erreur lors de l\'enregistrement.').parent().removeClass(
                            'd-none');
                    },
                    complete: function() {
                        $('#submitAjustement .spinner-border').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
