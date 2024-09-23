

<?php $__env->startSection('content'); ?>


    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Nouveau stock
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Créer un nouveau stock
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <style>
        form label {
            font-size: 11px
        }

        .form-duplicate {
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            background: white;
            padding: 10px;
        }


        .select-no-interaction {
            pointer-events: none;
            /* Empêche les interactions */
            cursor: not-allowed;
            /* Change le curseur en "non autorisé" */
            background-color: #d6d6d6;
            /* Change la couleur de fond pour indiquer que c'est désactivé */
        }
    </style>



    <div class="row">
        <div class="col-lg-12">
            
            <form method="POST" action="<?php echo e(route('achat.store')); ?>" autocomplete="off" class="needs-validation" novalidate
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="row mb-3">

                            <div id="static-input">
                                <div class="row">

                                    <div class="col-md-3 mb-3">
                                        <label class="form-label" for="meta-title-input">Type de facture
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select name="type" class="form-control" required>
                                            <option value="" disabled selected>Choisir</option>
                                            <option value="facture">Facture</option>
                                            <option value="bon de commande">Bon de commande</option>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="meta-title-input">N° facture
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="numero_facture" class="form-control" required>
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label" for="product-title-input">Fournisseur
                                            <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" name="fournisseur_id" required>
                                            <option value="" disabled selected>Choisir</option>
                                            <?php $__currentLoopData = $data_fournisseur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fournisseur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($fournisseur->id); ?>">
                                                    <?php echo e($fournisseur->nom); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="meta-title-input">Montant 
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" name="montant" class="form-control" required>
                                    </div>

                                    <div class="col-md-2 mb-3">
                                        <label class="form-label" for="meta-title-input">Date <span
                                                class="text-danger">*</span>
                                        </label>
                                        <input type="date" id="currentDate" value="<?php echo date('Y-m-d'); ?>" name="date_achat"
                                            class="form-control" required>
                                    </div>

                                  

                                </div>
                            </div>


                            <div id="form-container">
                                <!-- ========== Start form duplicate ========== -->
                                <!-- Formulaire modèle (caché) -->


                                <!-- ========== End form duplicate ========== -->
                            </div>

                            <!-- Bouton "Plus" -->
                            <div class="mb-3">
                                <button type="button" id="add-more" class="btn btn-primary">Ajouter
                                    plus <i class="ri ri-add-circle-line"></i></button>
                            </div>





                        </div>
                        
                        <!-- end card -->
                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
                <!-- end card -->
                <div class="text-end mb-3">
                    <button type="submit" class="btn btn-success w-lg btn-save">Enregistrer</button>
                </div>
            </form>


            <!-- start form duplicate-->
            <div id="product-form-template" style="display: none;">
                <div class="row mb-3 form-duplicate">
                    <div class="col-md-8 mb-3">
                        <label class="form-label" for="product-title-input">Produits
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control productSelected selectView" id="produitId" name="produit_id[]" required>
                            <option disabled selected value>Selectionner un produit
                            </option>
                            <?php $__currentLoopData = $data_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($produit->id); ?>"><?php echo e($produit->nom); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label" for="product-title-input">Magasin
                            <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" name="magasin_id" required>
                            <option value="" disabled selected>Choisir</option>
                            <?php $__currentLoopData = $data_magasin; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $magasin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($magasin->id); ?>">
                                    <?php echo e($magasin->libelle); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="stocks-input">Qté acquise</label>
                        <input type="number" name="quantite_format[]" class="form-control qteAcquise" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label" for="product-title-input">Format</label>
                        <select class="form-control selectView format" id="format_id" name="format_id[]" required>
                            <option value="" disabled selected>Choisir</option>
                            <?php $__currentLoopData = $data_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($format->id); ?>">
                                    <?php echo e($format->libelle); ?> (<?php echo e($format->abreviation); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="stocks-input">Qté format</label>
                        <input type="number" name="quantite_in_format[]" class="form-control qteFormat" required>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="stocks-input">Qté stocké</label>
                        <input type="number" name="quantite_stocke[]" class="form-control qteStockable" readonly>
                    </div>

                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="stocks-input">Prix
                            unitaire du format</label>
                        <input type="number" name="prix_unitaire_format[]" class="form-control prixUnitaireFormat">
                    </div>

                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="stocks-input">Total
                            dépensé</label>
                        <input type="number" name="prix_total_format[]" class="form-control prixTotalFormat" readonly>
                    </div>


                    <div class="col-md-3 mb-3">
                        <label class="form-label" for="meta-title-input">Unité de
                            sortie</label>
                        <select id="uniteMesure" class="form-control selectView " name="unite_sortie[]" required>
                            <option value="" disabled selected>Choisir</option>
                            <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($unite->id); ?>">
                                    <?php echo e($unite->libelle); ?> (<?php echo e($unite->abreviation); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-md-3 mb-3 prixAchatUniteDiv">
                        <label class="form-label" for="stocks-input">Coût achat de
                            l'unité</label>
                        <input type="number" name="prix_achat_unitaire[]" class="form-control prixAchatUnite" readonly>
                    </div>



                    <div class="col-md-3 mb-3 prixVenteDiv">
                        <label class="form-label" for="stocks-input">Prix de
                            vente</label>
                        <input type="number" name="prix_vente_unitaire[]" class="form-control prixVente">
                    </div>

                    

                    <!-- Bouton pour supprimer ce bloc -->
                    <div class="text-end">
                        <button type="button" class="btn btn-success validate">valider</button>
                        <button type="button" class="btn btn-success edit">modifier</button>

                        <button type="button" class="btn btn-danger remove-form">Supprimer</button>
                    </div>
                </div>
            </div>
            <!-- end form duplicate-->



            <!-- end row -->
        </div><!-- end col -->


        <!--end row-->

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/modal.init.js')); ?>"></script>
        
        <script src="<?php echo e(URL::asset('build/tinymce/tinymce.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')); ?>"></script>

        <script src="<?php echo e(URL::asset('build/libs/dropzone/dropzone-min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/ecommerce-product-create.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {



                let formCount = 1;
                updateSelect2(); // Mettre à jour Select2 après suppression d'un formulaire
                // Fonction pour réinitialiser les champs dupliqués
                function resetFields(clonedForm, formCount) {
                    let inputs = clonedForm.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        if (input.tagName === 'INPUT') {
                            input.value = ''; // Réinitialise les valeurs des inputs
                            input.id = input.id.replace(/_\d+$/, '_' + formCount);
                        } else if (input.tagName === 'SELECT') {
                            input.selectedIndex = 0; // Réinitialise la sélection des dropdowns
                            input.id = input.id.replace(/_\d+$/, '_' + formCount);
                        }
                    });


                    // Ajouter le formCount à la classe js-example-basic-single
                    clonedForm.querySelectorAll('.selectView').forEach(function(select) {
                        // Ajoute un identifiant unique à la classe
                        select.classList.add('js-example-basic-single-' + formCount);
                    });
                }

                // Fonction pour ajouter un nouveau formulaire
                function addNewForm() {

                    let formContainer = document.getElementById('form-container');

                    // Clone le formulaire modèle
                    let templateForm = document.getElementById('product-form-template');
                    let clonedForm = templateForm.cloneNode(true);

                    // Affiche le formulaire cloné et met à jour l'ID
                    clonedForm.style.display = 'block';
                    clonedForm.id = 'product-form-' + formCount;

                    // Réinitialise les champs du formulaire cloné
                    resetFields(clonedForm, formCount);

                    // Ajoute le formulaire cloné dans le conteneur
                    formContainer.appendChild(clonedForm);



                    // // Réinitialise Select2 sur le nouveau champ
                    // $(clonedForm).find('.js-example-basic-single').select2();

                    // Initialiser Select2 pour le nouveau champ avec une classe unique
                    $(clonedForm).find('.js-example-basic-single-' + formCount).select2();


                    // Activer le 'required' pour les champs du formulaire cloné
                    setRequiredFields(clonedForm);

                    formCount++;


                }

                // Fonction pour activer le 'required' uniquement pour les champs visibles
                function setRequiredFields(formBlock) {
                    formBlock.querySelectorAll('input, select').forEach(function(input) {
                        if (input.hasAttribute('data-required')) {
                            input.setAttribute('required', 'true');
                        }
                    });
                }

                // Fonction pour désactiver les champs 'required' pour le formulaire modèle
                function disableRequiredInTemplate() {
                    let templateForm = document.getElementById('product-form-template');
                    templateForm.querySelectorAll('input[required], select[required]').forEach(function(input) {
                        input.removeAttribute('required');
                        // Ajouter un attribut temporaire pour les champs initialement required
                        input.setAttribute('data-required', 'true');
                    });
                }

                // Désactiver les champs 'required' dans le formulaire modèle au chargement
                disableRequiredInTemplate();



                // Fonction pour réinitialiser Select2 sur les formulaires dupliqués
                function updateSelect2() {
                    // Compter le nombre de duplications dans le conteneur
                    let totalForms = document.querySelectorAll('#form-container .row').length;

                    // Boucler à travers chaque formulaire dupliqué
                    for (let i = 1; i <= totalForms; i++) {
                        // Initialiser Select2 pour chaque champ dupliqué en utilisant la classe unique
                        $('.js-example-basic-single-' + i).select2();
                    }
                }

                // Écouteur pour le bouton "Ajouter un produit"
                document.getElementById('add-more').addEventListener('click', function() {
                    addNewForm();
                });

                //cacher le bouton modifier par defaut
                $('.edit').hide();

                // Utiliser la délégation d'événements pour le bouton "Supprimer"
                document.getElementById('form-container').addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-form')) {
                        e.target.closest('.form-duplicate').remove();
                        updateSelect2(); // Mettre à jour Select2 après suppression d'un formulaire
                    }



                     // Au clic du bouton "valider"
                     if (e.target && e.target.classList.contains('validate')) {
                        let row = e.target.closest('.form-duplicate');
                        row.querySelectorAll('input, select').forEach(input => {
                            if (input.tagName === 'INPUT') {
                                // Pour les éléments input
                                // input.readOnly = true;
                                input.classList.add('select-no-interaction');
                            } else if (input.tagName === 'SELECT') {
                                // Ajouter une classe empêchant les interactions sur Select2
                                input.classList.add('select-no-interaction');

                                // Récupérer le conteneur Select2 et désactiver les interactions
                                let select2Container = $(input).next('.select2-container');
                                select2Container.find('.select2-selection').css({
                                    'pointer-events': 'none',
                                    'cursor': 'not-allowed',
                                    'background-color': '#d6d6d6',


                                });
                            }
                        });

                        // Cacher le bouton "valider" et afficher le bouton "modifier"
                        $(row).find('.validate').hide();
                        $(row).find('.edit').show();
                    }


                    // Au clic du bouton "modifier"
                    if (e.target && e.target.classList.contains('edit')) {
                        let row = e.target.closest('.form-duplicate');
                        row.querySelectorAll('input, select').forEach(input => {
                            if (input.tagName === 'INPUT') {
                                // Pour les éléments input
                                // input.readOnly = false;
                                input.classList.remove('select-no-interaction');
                            } else if (input.tagName === 'SELECT') {
                                // Supprimer la classe empêchant les interactions sur Select2
                                input.classList.remove('select-no-interaction');

                                // Récupérer le conteneur Select2 et réactiver les interactions
                                let select2Container = $(input).next('.select2-container');
                                select2Container.find('.select2-selection').css({
                                    'pointer-events': 'auto',
                                    'cursor': 'default',
                                    'background-color': '#fff',
                                    
                                });
                            }
                        });

                        // Cacher le bouton "modifier" et afficher le bouton "valider"
                        $(row).find('.edit').hide();
                        $(row).find('.validate').show();
                    }


                });


            });









            // $('.btn-save').click(function(e) {
            //     e.preventDefault();
            //     var form = $(this).closest('.row');
            //     form.find('input[required], select[required]').each(function() {
            //         $(this).prop('required', false);
            //     });
            // });














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

                var dataProduct = <?php echo e(Js::from($data_produit)); ?>; // Données du contrôleur

                console.log(dataProduct);

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


            // Fonction pour cacher les champs en fonction du type de produit selectionné
            function addProductSelectListener(form) {
                var dataProduct = <?php echo e(Js::from($data_produit)); ?>; // Données du contrôleur
                var dataCategory = <?php echo e(Js::from($data_categorie)); ?>; // Données du contrôleur

                var productSelected = form.find('.productSelected').val(); // Récupère la valeur du select actuel
                var filteredCatRestaurant = dataCategory.filter(function(item) {
                    return item.type == 'restaurant';
                });

                var filteredProduct = dataProduct.filter(function(item) {
                    return item.id == productSelected;
                });

                if (filteredProduct[0].type_id == filteredCatRestaurant[0].id) {

                    form.find('.prixAchatUniteDiv').hide()
                    form.find('.prixVenteDiv').hide()
                    form.find('.prixAchatUnite').val('')

                } else {
                    form.find('.prixAchatUniteDiv').show()
                    form.find('.prixVenteDiv').show()
                }


            }


            $(document).on('change', '.productSelected', function() {
                var form = $(this).closest('.row');
                addProductSelectListener(form);
            });






            // $(document).on('input', '.qteFormat, .prixAchatUnitaire', function() {
            //     var form = $(this).closest('.row');
            //     calculatePrixAchatTotal(form);
            // });




            //get product select and show detail of product selected
            // $('.productSelected').change(function(e) {
            //     var dataProduct = <?php echo e(Js::from($data_produit)); ?> // from controller

            //     e.preventDefault();
            //     var productSelected = $('.productSelected option:selected').val();

            //     var filteredProduct = dataProduct.filter(function(item) {
            //         return item.id == productSelected;
            //     });
            //     console.log(filteredProduct[0].media);


            //     //update stock , sku ,  category of product selected
            //     $('#stock').html(filteredProduct[0].stock)
            //     $('#stockAlerte').html(filteredProduct[0].stock_alerte)

            //     $('#sku').html(filteredProduct[0].code)
            //     $('#categorie').html(filteredProduct[0].categorie.name)

            //     var img = filteredProduct[0].media[0].original_url
            //     $('#product-img').html(`<img src="${img}"  class="avatar-md h-auto" />`)

            // });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/stock/achat/create.blade.php ENDPATH**/ ?>