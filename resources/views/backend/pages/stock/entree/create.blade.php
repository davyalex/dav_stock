@extends('backend.layouts.master')
@section('title')
    Entrée
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Stock
        @endslot
        @slot('title')
            Créer une entrée
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Sélectionner des produits</h4>
                    <div class="row align-items-end">
                        <div class="col-md-8 mb-3">
                            <label for="product-select" class="form-label fw-semibold">Produit</label>
                            <select id="product-select" name="produit_id" class="form-select js-example-basic-single">
                                <option value="">Sélectionnez un produit</option>
                                @foreach ($data_produit as $produit)
                                    <option value="{{ $produit->id }}" data-stock="{{ $produit->stock }}">
                                        {{ $produit->nom }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold" for="currentDate">Date d'entrée <span class="text-danger">*</span></label>
                            <input type="datetime-local" id="currentDate" value="{{ date('Y-m-d\TH:i') }}" name="date_entree"
                                class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title mb-4 fw-bold text-primary">Liste des produits à entrer</h4>
                    <div class="table-responsive">
                        <div class="alert alert-danger d-none" role="alert">
                            <span id="errorMessage"></span>
                        </div>
                        <table class="table table-bordered align-middle" id="cart-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Produit</th>
                                    <th>Stock disponible</th>
                                    <th>Quantité à entrer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Dynamique JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="my-3">
                        <button id="submitEntree" class="btn btn-success w-100">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Enregistrer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // JS similaire à la sortie, adapter pour l'entrée
        let cart = [];
        $(document).ready(function() {
            $('#product-select').change(function() {
                let produitId = $(this).val();
                let produitNom = $(this).find('option:selected').text();
                let stockDisponible = $(this).find('option:selected').data('stock');
                if (produitId && !cart.find(item => item.id == produitId)) {
                    cart.push({ id: produitId, nom: produitNom, stock: stockDisponible, quantity: 1 });
                    renderCart();
                    // Enlever le message d'erreur si produit ajouté
                    $('#errorMessage').parent().addClass('d-none');
                }
            });
            $(document).on('input', '.quantity-input', function() {
                let produitId = $(this).data('id');
                let qty = parseInt($(this).val());
                cart = cart.map(item => item.id == produitId ? { ...item, quantity: qty } : item);
            });
            $(document).on('click', '.plus-btn', function() {
                let produitId = $(this).data('id');
                cart = cart.map(item => item.id == produitId ? { ...item, quantity: item.quantity + 1 } : item);
                renderCart();
            });
            $(document).on('click', '.minus-btn', function() {
                let produitId = $(this).data('id');
                cart = cart.map(item => item.id == produitId ? { ...item, quantity: Math.max(1, item.quantity - 1) } : item);
                renderCart();
            });
            $(document).on('click', '.remove-btn', function() {
                let produitId = $(this).data('id');
                cart = cart.filter(item => item.id != produitId);
                renderCart();
            });
            function renderCart() {
                let tbody = '';
                cart.forEach(item => {
                    tbody += `<tr>
                        <td>${item.nom}</td>
                        <td>${item.stock}</td>
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
            $('#submitEntree').click(function() {
                let dateEntree = $('#currentDate').val();
                if (!dateEntree || cart.length == 0) {
                    $('#errorMessage').text('Veuillez renseigner la date et ajouter au moins un produit.').parent().removeClass('d-none');
                    return;
                }
                $('#errorMessage').parent().addClass('d-none');
                $(this).find('.spinner-border').removeClass('d-none');
                $.ajax({
                    url: "{{ route('entree.store') }}",
                    method: 'POST',
                    data: {
                        date_entree: dateEntree,
                        cart: cart,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        window.location.href = "{{ route('entree.index') }}";
                    },
                    error: function(xhr) {
                        $('#errorMessage').text(xhr.responseJSON?.message || 'Erreur lors de l\'enregistrement.').parent().removeClass('d-none');
                    },
                    complete: function() {
                        $('#submitEntree .spinner-border').addClass('d-none');
                    }
                });
            });
        });
    </script>
@endsection
