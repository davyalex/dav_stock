@extends('backend.layouts.master')

@section('content')


    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Nouveau stock
        @endslot
        @slot('title')
            Créer un nouveau stock
        @endslot
    @endcomponent
    <style>
        form label {
            font-size: 11px
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('achat.store') }}" autocomplete="off" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta-title-input">N° facture
                                                </label>
                                                <input type="text" name="numero_facture" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta-title-input">Date <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="currentDate" value="<?php echo date('Y-m-d'); ?>"
                                                    name="date_menu" class="form-control" required>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-label" for="product-title-input">Fournisseur <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select class="form-control js-example-basic-single" name="fournisseur_id"
                                                    required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    @foreach ($data_fournisseur as $fournisseur)
                                                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div id="form-container">
                                                <!-- ========== Start form duplicate ========== -->
                                                <div class="row mb-3" id="product-form-0">
                                                    <div class="col-md-12 mb-3">
                                                        <select class="form-control productSelected js-example-basic-single"
                                                            id="produit_id" name="produit_id[]" required>
                                                            <option disabled selected value>Selectionner un produit</option>
                                                            @foreach ($data_produit as $produit)
                                                                <option value="{{ $produit->id }}">{{ $produit->nom }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label" for="stocks-input">Qté acquise</label>
                                                        <input type="number" name="quantite_acquise[]"
                                                            class="form-control qteAcquise" required>
                                                    </div>

                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label" for="product-title-input">Format</label>
                                                        <select class="form-control js-example-basic-single format"
                                                            id="format_id" name="format_id[]" required>
                                                            <option value="" disabled selected>Choisir</option>
                                                            @foreach ($data_format as $format)
                                                                <option value="{{ $format->id }}">{{ $format->libelle }}
                                                                    ({{ $format->abreviation }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label" for="stocks-input">Qté format</label>
                                                        <input type="number" name="quantite_format[]"
                                                            class="form-control qteFormat" required>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label" for="stocks-input">Qté stocké</label>
                                                        <input type="number" name="quantite_stocke[]"
                                                            class="form-control qteStockable" readonly>
                                                    </div>

                                                    <div class="col-md-2 mb-3">
                                                        <label class="form-label" for="stocks-input">Prix unitaire</label>
                                                        <input type="number" name="prix_unitaire_format[]"
                                                            class="form-control prixUnitaireFormat">
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label" for="stocks-input">Total dépensé</label>
                                                        <input type="number" name="prix_total_format[]"
                                                            class="form-control prixTotalFormat" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label" for="stocks-input">Coût achat de
                                                            l'unité</label>
                                                        <input type="number" name="prix_achat_unitaire[]"
                                                            class="form-control prixAchatUnite" readonly>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label" for="meta-title-input">Unité de
                                                            sortie</label>
                                                        <select id="uniteMesure"
                                                            class="form-control js-example-basic-single"
                                                            name="unite_sortie[]" required>
                                                            <option value="" disabled selected>Choisir</option>
                                                            @foreach ($data_unite as $unite)
                                                                <option value="{{ $unite->id }}">{{ $unite->libelle }}
                                                                    ({{ $unite->abreviation }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mb-3">
                                                        <label class="form-label" for="stocks-input">Prix de vente</label>
                                                        <input type="number" id="prixVente" name="prix_vente[]"
                                                            class="form-control">
                                                    </div>

                                                    <!-- Bouton pour supprimer ce bloc -->
                                                    <button type="button"
                                                        class="btn btn-danger remove-form">Supprimer</button>
                                                </div>
                                                <!-- ========== End form duplicate ========== -->
                                            </div>

                                            <!-- Bouton "Plus" -->
                                            <div class="mb-3">
                                                <button type="button" id="add-more" class="btn btn-primary">Ajouter
                                                    plus</button>
                                            </div>





                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                           
                        </div>
                        <!-- end row -->
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->


        <!--end row-->

    @section('script')
        <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
        <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
        {{-- <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script> --}}
        <script src="{{ URL::asset('build/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

        <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let formCount = 1;

                // Fonction pour réinitialiser les champs dupliqués
                function resetFields(clonedForm, formCount) {
                    let inputs = clonedForm.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        if (input.tagName === 'INPUT') {
                            input.value = ''; // Réinitialise la valeur des inputs
                            // Met à jour les IDs des champs input
                            input.id = input.id.replace(/_\d+$/, '_' + formCount);
                        } else if (input.tagName === 'SELECT') {
                            input.selectedIndex = 0; // Réinitialise la sélection des dropdowns
                            input.id = input.id.replace(/_\d+$/, '_' + formCount);


                        }
                    });

                    // Réinitialiser et recharger le select2 pour le nouveau select
                    $(clonedForm).find('.js-example-basic-single').select2();
                }

                // Écouter le clic sur le bouton "Ajouter plus"
                document.getElementById('add-more').addEventListener('click', function() {
                    let originalForm = document.querySelector(
                        '#product-form-0'); // Sélectionne le premier formulaire
                    let clonedForm = originalForm.cloneNode(true); // Clone le formulaire

                    // Met à jour l'ID du nouveau formulaire
                    clonedForm.id = 'product-form-' + formCount;

                    // Réinitialise les champs du formulaire cloné et met à jour les IDs
                    resetFields(clonedForm, formCount);

                    // Ajoute le formulaire cloné dans le conteneur
                    document.getElementById('form-container').appendChild(clonedForm);
                    formCount++;

                    // Ajoute un écouteur sur le bouton de suppression
                    clonedForm.querySelector('.remove-form').addEventListener('click', function() {
                        clonedForm.remove();
                    });
                });

                // Écouter le clic sur le bouton "Supprimer" du premier formulaire
                document.querySelector('#product-form-0 .remove-form').addEventListener('click', function() {
                    document.querySelector('#product-form-0').remove();
                });
            });








            // script for quantity stock increase and dicrease
            function increaseValue() {
                var input = document.getElementById("qteStockable");
                var value = parseInt(input.value, 10);
                value = isNaN(value) ? 0 : value;
                value++;
                input.value = value;
            }

            function decreaseValue() {
                var input = document.getElementById("qteStockable");
                var value = parseInt(input.value, 10);
                value = isNaN(value) ? 0 : value;
                value < 1 ? value = 1 : '';
                if (value > 1) {
                    value--;
                }
                input.value = value;


            }


            // Calculer la quantité stockable
            function qteStockable(form) {
                var qte_acquise = form.find(".qteAcquise").val() || 0; // combien de format
                var qte_format = form.find(".qteFormat").val() || 0; // combien dans le format
                var qte_stockable = qte_acquise * qte_format;
                form.find(".qteStockable").val(qte_stockable);
            }

            // Calculer le total dépensé
            function prixTotalDepense(form) {
                var qte_acquise = form.find(".qteAcquise").val() || 0; // combien de format
                var pu_unitaire_format = form.find(".prixUnitaireFormat").val() || 0; // prix unitaire d'un format
                var total_depense = qte_acquise * pu_unitaire_format;
                form.find(".prixTotalFormat").val(total_depense);
            }

            // Calculer le prix d'achat de l'unité
            function prixAchatUnite(form) {
                var qte_acquise = form.find(".qteAcquise").val() || 0;
                var pu_unitaire_format = form.find(".prixUnitaireFormat").val() || 0;
                var qte_stocke = form.find(".qteStockable").val() || 0;
                var prix_achat_unite = qte_acquise * pu_unitaire_format / qte_stocke;
                form.find(".prixAchatUnite").val(prix_achat_unite);
            }

            // Calculer le prix d'achat total
            function calculatePrixAchat(form) {
                var qte_format = form.find(".qteFormat").val() || 0;
                var prix_achat_total = form.find(".prixAchatTotal").val() || 0;
                var prixAchatUnitaire = prix_achat_total / qte_format;
                var prixAchatTotal = qte_format * prixAchatUnitaire;
                form.find(".prixAchatUnitaire").val(prixAchatUnitaire);
            }

            // Ajouter des écouteurs sur les champs dupliqués
            $(document).on('input', '.qteAcquise, .qteFormat, .prixUnitaireFormat', function() {
                var form = $(this).closest('.row');
                qteStockable(form);
                prixTotalDepense(form);
                prixAchatUnite(form);
            });

            // Ajout d'écouteurs pour les champs qui influencent le calcul du prix d'achat
            $(document).on('input', '.qteFormat, .prixAchatTotal', function() {
                var form = $(this).closest('.row');
                calculatePrixAchat(form);
            });

            // $(document).on('input', '.qteFormat, .prixAchatUnitaire', function() {
            //     var form = $(this).closest('.row');
            //     calculatePrixAchatTotal(form);
            // });




            //get product select and show detail of product selected
            $('.productSelected').change(function(e) {
                var dataProduct = {{ Js::from($data_produit) }} // from controller

                e.preventDefault();
                var productSelected = $('.productSelected option:selected').val();

                var filteredProduct = dataProduct.filter(function(item) {
                    return item.id == productSelected;
                });
                console.log(filteredProduct[0].media);


                //update stock , sku ,  category of product selected
                $('#stock').html(filteredProduct[0].stock)
                $('#stockAlerte').html(filteredProduct[0].stock_alerte)

                $('#sku').html(filteredProduct[0].code)
                $('#categorie').html(filteredProduct[0].categorie.name)

                var img = filteredProduct[0].media[0].original_url
                $('#product-img').html(`<img src="${img}"  class="avatar-md h-auto" />`)

            });
        </script>
    @endsection
@endsection
