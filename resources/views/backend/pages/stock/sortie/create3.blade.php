@extends('backend.layouts.master')
@section('title')
    Sortie
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Stock
        @endslot
        @slot('title')
            Créer une sortie
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="card-title mb-4">Sélectionner des produits</h4> --}}
                    <div class="row">
                        <div class="col-md-10">
                            <label for="date_debut" class="form-label">Produit</label>
                            <select id="product-select" name="produit_id" class="form-select js-example-basic-single">
                                <option value="">Sélectionnez un produit</option>
                                @foreach ($data_produit as $produit)
                                    <option value="{{ $produit->id }}" data-stock="{{ $produit->stock }}">
                                        {{ $produit->nom }} {{ $produit->valeur_unite ?? '' }}
                                        {{ $produit->unite->libelle ?? '' }}
                                        {{ $produit->unite->abreviation ?? '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="meta-title-input">Date de sortie <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="datetime-local" id="currentDate" value="<?php echo date('Y-m-d H:i:s'); ?>" name="date_sortie"
                                class="form-control" required>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Listes des produits </h4>
                    <div class="table-responsive">
                        <div class="alert alert-danger d-none" role="alert">
                            <span id="errorMessage"></span>
                        </div>
                        <table class="table table-bordered" id="cart-table">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Stock actuel</th>
                                    <th>Quantité utilisée</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>



                    <!-- Bouton de validation -->
                    <div class="mt-5">
                        <button type="button" id="validate" class="btn btn-primary w-100">Enregistrer</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            let cart = []; // table des produits

            //recuperer les informations du produit
            $('#product-select').change(function() {
                let productId = $(this).val();

                //filtrer les informations du produit
                var dataProduit = @json($data_produit);
                var getProductInfo = dataProduit.find(item => item.id == productId)


                let productName = $(this).find('option:selected').text();
                let productStock = getProductInfo.stock;
                let productUniteSortie = getProductInfo.unite_sortie.libelle;
                // let productStockAlert = getProductInfo.stock_alerte;

                if (productId) {
                    addToCart(productId, productName, productStock, productUniteSortie);
                    updateCartTable();
                    verifyQty();
                    // $(this).val(null).trigger('change'); // Réinitialise Select2


                }
            });


            function addToCart(id, name, stock, uniteSortie) {
                let existingItem = cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity += 1;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        stock: stock,
                        quantity: 1,
                        uniteSortie: uniteSortie
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
                            <td>${item.stock} ${item.uniteSortie}</td>
                            <td>
                                <button class="btn btn-secondary btn-sm decrease-qty" data-index="${index}">-</button>
                                <input  type="number" class="form-control quantity-input d-inline-block text-center" value="${item.quantity}" min="0" step="any" style="width: 60px;" data-index="${index}">
                                <button class="btn btn-secondary btn-sm increase-qty" data-index="${index}">+</button>
                            </td>
                           
                            <td><button class="btn btn-danger btn-sm remove-item" data-index="${index}">Supprimer</button></td>
                        </tr>
                    `);
                });
            }



            $(document).on('click', '.increase-qty', function() {
                let index = $(this).data('index');
                cart[index].quantity += 1;
                updateCartTable();
                verifyQty();
            });

            $(document).on('click', '.decrease-qty', function() {
                let index = $(this).data('index');
                if (cart[index].quantity > 1) {
                    cart[index].quantity -= 1;
                    updateCartTable();
                    verifyQty();
                }
            });

            // ajouter la quantité manuellement
            $(document).on('input', '.quantity-input', function() {
                let index = $(this).data('index');
                let value = $(this).val();
                if (value > 0) {
                    cart[index].quantity = parseFloat(value);
                    // updateCartTable();
                    verifyQty();
                }

            });

            // $(document).on('change', '.quantity-input', function() {
            //     let index = $(this).data('index');
            //     let newQuantity = parseInt($(this).val());
            //     if (newQuantity >= 1) {
            //         cart[index].quantity = newQuantity;
            //         updateCartTable();
            //     }
            // });

            // verifier la quantité pour voir si elle ne depasse pas la quantité du stock
            // function verifyQty() {
            //     var dataProduct = @json($data_produit); // Données du contrôleur

            //     cart.forEach((item, index) => {
            //         // Trouver le produit dans dataProduct basé sur l'ID du produit dans le panier
            //         var product = dataProduct.find(function(dataItem) {
            //             return dataItem.id == item.id;
            //         });

            //         if (item.quantity > product.stock) {
            //             //swalfire
            //             Swal.fire({
            //                 title: 'Erreur',
            //                 text: 'La quantité entrée dépasse la quantité en stock pour le produit "' +
            //                     item.name + '"',
            //                 icon: 'error',
            //             });

            //             //mettre le button save en disabled
            //             $('#validate').prop('disabled', true);
            //         } else {
            //             //mettre le button save en enable
            //             $('#validate').prop('disabled', false);
            //         }
            //     });
            // }

            function verifyQty() {
                var dataProduct = @json($data_produit);
                var allQuantitiesValid = true; // Pour suivre si toutes les quantités sont valides

                cart.forEach((item) => {
                    var product = dataProduct.find(dataItem => dataItem.id == item.id);

                    if (item.quantity > product.stock) {
                        $('#errorMessage').text(
                            'La quantité entrée dépasse la quantité en stock pour le produit "' + item
                            .name + '"'
                        );
                        $('.alert').removeClass('d-none');

                        allQuantitiesValid =
                            false; // Marquer comme invalide si une quantité dépasse le stock
                    }
                });

                // Si toutes les quantités sont valides, masquer l'alerte
                if (allQuantitiesValid) {
                    $('.alert').addClass('d-none');
                }

                // Activer ou désactiver le bouton selon la validité des quantités
                $('#validate').prop('disabled', !allQuantitiesValid);
            }



            $(document).on('click', '.remove-item', function() {
                let index = $(this).data('index');
                cart.splice(index, 1);
                updateCartTable();
                verifyQty()
            });

            // verification de la date (la date doit etre inferieur a la date actuelle)
            let dateValue = $('#currentDate').val();


            $(document).on('change', '#currentDate', function() {
                var inventaireValue = @json($inventaire_existe);
                var dateInsert = $(this).val();

                if (inventaireValue == true) {
                    var currentDate = new Date();
                    var currentMonth = currentDate.getMonth() + 1;
                    var currentYear = currentDate.getFullYear();

                    var dateInsertMonth = new Date(dateInsert).getMonth() + 1;
                    var dateInsertYear = new Date(dateInsert).getFullYear();

                    if (dateInsertMonth > currentMonth && dateInsertYear == currentYear) {
                        Swal.fire({
                            title: 'Erreur',
                            text: 'La date doit être inférieure au mois en cours',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });

                        $('#validate').prop('disabled', true);
                    } else {
                        $('#validate').prop('disabled', false);
                    }
                }
            })




            $('#validate').click(function(e) {

                if (cart.length === 0) {
                    Swal.fire({
                        title: 'Erreur',
                        text: 'Aucun produit n\'a été ajouté',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                } else {
                    let currentDate = $('#currentDate').val();

                    let data = {
                        date_sortie: currentDate,
                        cart: cart,
                        _token: '{{ csrf_token() }}' // N'oubliez pas d'ajouter le token CSRF

                    }
                    // Envoi des données au contrôleur via AJAX
                    $.ajax({
                        url: '{{ route('sortie.store') }}', // Remplacez par votre route
                        method: 'POST',
                        data: data,

                        success: function(response) {
                            if (response.status == 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succès',
                                    text: 'Vente validée avec succès !',
                                });

                                window.location.href = '{{ route('sortie.index') }}';
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
