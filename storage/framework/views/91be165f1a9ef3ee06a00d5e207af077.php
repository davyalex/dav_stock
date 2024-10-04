

<?php $__env->startSection('content'); ?>


    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Vente
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Faire une vente
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

        .error-text {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            text-shadow: none;
            /* Cacher le texte par défaut */
        }

        .btn-custom-size {
            padding: 4px 8px;
            /* Ajuste la taille du bouton */
            font-size: 10px;
            /* Ajuste la taille du texte */
        }

        .btn-custom-size i {
            font-size: 14px;
            /* Ajuste la taille de l'icône */
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
            
            <form id="myForm" method="POST" action="<?php echo e(route('vente.store')); ?>" autocomplete="off" novalidate
                enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-12">
                        
                        <div class="row mb-3">

                            

                            <div id="form-container">
                                <!-- ========== Start form duplicate ========== -->
                                <!-- Formulaire modèle (caché) -->
                                <!-- ========== End form duplicate ========== -->
                            </div>

                            <!-- Bouton "Plus" -->
                            <div class="mb-3">
                                <button type="button" id="add-more" class="btn btn-primary">Ajouter
                                    un produit <produit class=""></produit> <i
                                        class="ri ri-add-circle-line"></i></button>
                            </div>

                        </div>

                    </div>
                    <!-- end col -->

                </div>
                <!-- end row -->
                <!-- end card -->
                <div class="col-md-4 card mb-3 float-end">
                    <div class="card-body">
                        <h5 class="card-title">Montant total</h5>
                        <p class="card-text h3 " id="montantTotal">0 FCFA</p>
                    </div>
                    <input type="number" name="montant_total"  class="montant_total" hidden>
                </div>


                <div class="mb-3">
                    <button type="submit" id="save" class="btn btn-success w-100 btn-save"
                        disabled>Enregistrer</button>
                </div>
            </form>


            <!-- start form duplicate-->
            <div id="product-form-template" style="display: none;">
                <div class="row mb-3 form-duplicate m-auto">
                    <!-- Bouton pour supprimer ce bloc -->

                    <div class="col-md-5 mb-3">
                        <label class="form-label" for="product-title-input">Produits
                            <span class="text-danger">*</span>
                        </label>
                        <span class="error-text">Champ obligatoire</span> <!-- Conteneur pour l'erreur -->
                        <select class="form-control productSelected selectView" name="produit_id[]" required>
                            <option disabled selected value>Selectionner un produit
                            </option>
                            <?php $__currentLoopData = $data_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($produit->id); ?>"><?php echo e($produit->nom); ?> <?php echo e($produit->quantite_unite); ?>

                                    <?php echo e($produit->unite->libelle ?? ''); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>



                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="prix-input">Prix unitaire
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="prix_unitaire[]" class="form-control prixUnitaire" readonly>
                    </div>

                    <div class="col-md-2 mb-3 ">
                        <label class="form-label" for="quantite-input">Quantité <span></span> <span class="text-danger"
                                id="labelUnite"></span></label>
                        <br>
                        <div class="input-step w-100">
                            <button type="button" class="minus w-25 btn btn-primary decreaseValue">-</button>
                            <input type="number" class="form-control quantite w-100" value="1" name="quantite[]"
                                readonly>
                            <button type="button" class="plus w-25 btn btn-primary increaseValue">+</button>
                        </div>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label" for="sous-total-input">Sous-total
                            <span class="text-danger">*</span>
                        </label>
                        <input type="number" name="sous_total[]" class="form-control sousTotal" readonly>
                    </div>
                    <div class="col-md-1 mb-3 pt-4">
                        <button type="button" class="btn btn-danger remove-form btn-custom-size"> <i
                                class="ri ri-delete-bin-fill fs-5 remove-form"></i> </button>
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

                // Fonction pour vérifier et activer/désactiver le bouton "Enregistrer"
                function toggleEnregistrerButton() {
                    let formDuplicates = document.querySelectorAll('.form-duplicate');

                    // Si il n'y a qu'un seul élément, désactiver le bouton
                    if (formDuplicates.length <= 1) {
                        document.getElementById('save').disabled = true;
                    } else {
                        document.getElementById('save').disabled = false;
                    }

                }


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

                    // Initialiser Select2 pour le nouveau champ avec une classe unique
                    $(clonedForm).find('.js-example-basic-single-' + formCount).select2();


                    // Activer le 'required' pour les champs du formulaire cloné
                    setRequiredFields(clonedForm);

                    formCount++;

                    toggleEnregistrerButton(); // Vérifier si "Enregistrer" doit être actif
                }


                // Initial check when the page loads
                toggleEnregistrerButton();

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

                    toggleEnregistrerButton(); // Vérifier si "Enregistrer" doit être actif

                });



                //cacher le bouton modifier par defaut
                $('.edit').hide();

                // Utiliser la délégation d'événements pour le bouton "Supprimer"
                document.getElementById('form-container').addEventListener('click', function(e) {
                    if (e.target && e.target.classList.contains('remove-form')) {
                        e.target.closest('.form-duplicate').remove();
                        updateSelect2(); // Mettre à jour Select2 après suppression d'un formulaire

                        toggleEnregistrerButton(); // Vérifier si "Enregistrer" doit être actif

                    }

                });
                // Fonction pour incrémenter et décrémenter la quantité
                function updateQuantity(form, action) {
                    var input = form.find(".quantite");
                    var value = parseInt(input.val(), 10);
                    value = isNaN(value) ? 1 : value; // Valeur par défaut à 1 si non numérique

                    if (action === 'increase') {
                        value++;
                    } else if (action === 'decrease' && value > 1) {
                        value--;
                    }

                    input.val(value);
                    verifyQty(form);
                    calculerMontantTotal();
                }

                // Gestionnaire d'événements pour les boutons + et -
                $(document).on('click', '.increaseValue, .decreaseValue', function() {
                    var form = $(this).closest('.row');
                    var action = $(this).hasClass('increaseValue') ? 'increase' : 'decrease';
                    updateQuantity(form, action);
                    calculateSousTotal(form);
                });

                //fonction pour calculer le prix total
                function calculateSousTotal(form) {
                    var prixUnitaire = form.find('.prixUnitaire').val();
                    var quantite = form.find('.quantite').val();
                    var sousTotal = prixUnitaire * quantite;
                    form.find('.sousTotal').val(sousTotal);
                }



                function calculerMontantTotal() {
                    let total = 0;
                    const prixUnitaires = document.querySelectorAll('.prixUnitaire');
                    const quantites = document.querySelectorAll('.quantite');

                    for (let i = 0; i < prixUnitaires.length; i++) {
                        total += parseFloat(prixUnitaires[i].value || 0) * parseFloat(quantites[i].value || 0);
                    }

                    document.getElementById('montantTotal').textContent = new Intl.NumberFormat('fr-FR', {
                        style: 'currency',
                        currency: 'XOF'
                    }).format(total);
                    $('input[name="montant_total"]').val(total);
                }

                // Calculer le montant total initialement
                calculerMontantTotal();

                // Recalculer le montant total lorsque les quantités ou les prix changent
                document.querySelectorAll('.prixUnitaire, .quantite').forEach(input => {
                    input.addEventListener('change', calculerMontantTotal);
                });

                // Recalculer le montant total lorsqu'un produit est ajouté ou supprimé
                const observer = new MutationObserver(calculerMontantTotal);
                observer.observe(document.getElementById('form-container'), {
                    childList: true,
                    subtree: true
                });


                // Fonction pour  verifier la quantité entrée , elle ,e dois pas depasser la quantité en stock
                function verifyQty(form) {
                    var dataProduct = <?php echo json_encode($data_produit, 15, 512) ?>; // Données du contrôleur

                    // Récupérer la quantité utilisée et l'ID du produit sélectionné
                    var qte = form.find('.quantite').val(); // quantité entrée
                    var productSelected = form.find('.productSelected')
                        .val(); // Assurez-vous que la classe est correcte

                    // Trouver le produit dans dataProduct basé sur l'ID sélectionné
                    var product = dataProduct.find(function(item) {
                        return item.id == productSelected;
                    });
                    //si le produit a un achat on verifier la quantite en stock 
                    if (product.achats && product.achats.length > 0) {
                        if (qte > product.achats[0].quantite_stocke) {
                            //swalfire
                            Swal.fire({
                                title: 'Erreur',
                                text: 'La quantité entrée dépasse la quantité en stock',
                                icon: 'error',
                            });
                            //mettre le button save en disabled
                            $('#save').prop('disabled', true)

                        } else {
                            //mettre le button save en enable
                            $('#save').prop('disabled', false)
                        }
                    }
                }

                $(document).on('input change', '.quantite , .productSelected ', function() {
                    var form = $(this).closest('.row'); // Cibler le formulaire ou la ligne parent
                    verifyQty(form); // Appeler la fonction avec le formulaire
                });


                // Fonction pour verifier si un produit est selectionner 2 fois
                function validateProductSelection() {
                    let selectedProducts = [];

                    $('.productSelected').each(function(index, element) {
                        let produitId = $(element).val();
                        let form = $(element).closest('.row');
                        // Vérifier si le produit a déjà été sélectionné
                        if (selectedProducts.includes(produitId)) {
                            Swal.fire({
                                title: 'Erreur',
                                text: 'Ce produit a déjà été sélectionné.',
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });


                            // Réinitialiser le champ select pour éviter la sélection en double
                            $(element).val(null).trigger('change.select2');

                        } else {
                            selectedProducts.push(produitId);

                        }
                    });
                }


                //fonction pour remplir les champs stock initial et stock restante
                function getProductInfo(form) {
                    //recuperer les infos de produit
                    var dataProduct = <?php echo json_encode($data_produit, 15, 512) ?>; // Données du contrôleur
                    var productId = form.find('.productSelected').val();
                    var product = dataProduct.find(function(item) {
                        return item.id == productId;
                    });
                    console.log(product);
                    form.find('.quantite').val(1); // quantite par defaut
                    //si le produit a un achat
                    if (product.achats.length > 0) {
                        form.find('.prixUnitaire').val(product.achats[0].prix_vente_unitaire);
                        form.find('.sousTotal').val(product.achats[0].prix_vente_unitaire);
                    } else {
                        form.find('.prixUnitaire').val(product.prix);
                    }
                    form.find('.prixTotal').val(product.prix_vente);
                    form.find('.sousTotal').val(product.prix_vente);
                }

                // Attacher l'événement de changement aux champs select des produits
                $(document).on('change', '.productSelected', function() {
                    validateProductSelection();
                    var form = $(this).closest('.row');
                    getProductInfo(form);
                    calculateSousTotal(form);
                });



                $('#myForm').on('submit', function(event) {
                    event.preventDefault(); // Empêcher le rechargement de la page

                    let hasError = false;

                    // Parcourir tous les champs ayant l'attribut `required`
                    $(this).find('[required]').each(function() {
                        // Vérifier si le champ est vide
                        if (!$(this).val()) {
                            hasError = true;
                            let fieldName = $(this).attr('name'); // Récupérer le nom du champ
                            let label = $(this).closest('div').find('label').text() ||
                                fieldName; // Trouver le label ou utiliser le nom du champ

                            // Ajouter le texte d'erreur sous le champ
                            // $(this).closest('div').find('.error-text').text(
                            //     `Le champ ${label} est obligatoire.`).show();
                            $(this).closest('div').find('.error-text').text('Champs obligatoire')
                                .show();


                            // Afficher une alerte avec SweetAlert
                            Swal.fire({
                                title: 'Erreur',
                                text: `Le champ ${label} est obligatoire.`,
                                icon: 'error',
                                confirmButtonText: 'OK',
                            });

                            return false; // Stopper l'itération et éviter l'envoi
                        } else {
                            // Cacher le message d'erreur si le champ est rempli
                            $(this).closest('div').find('.error-text').hide();
                        }
                    });


                    // Si une erreur a été trouvée, arrêter l'envoi
                    if (hasError) {
                        return false;
                    }

                    // Si tout est correct, soumettre le formulaire avec Ajax
                    let formData = $(this).serialize(); // Récupérer les données du formulaire
                    $.ajax({
                        url: $(this).attr('action'), // URL de la soumission du formulaire
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        success: function(response, textStatus, xhr) {

                            let statusCode = xhr.status;

                            // Si la soumission est réussie
                            if (statusCode === 200) {
                                Swal.fire({
                                    title: 'Succès',
                                    text: response.message,
                                    icon: 'success',
                                });

                                // Rediriger vers la liste des sortie
                                var url =
                                    "<?php echo e(route('vente.index')); ?>"; // Rediriger vers la route liste sortie
                                window.location.replace(url);
                            }
                        },
                        error: function(xhr, textStatus, errorThrown) {
                            let statusCode = xhr.status;

                            // Si une erreur serveur (500) est rencontrée
                            if (statusCode === 500) {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: xhr.responseJSON ? xhr.responseJSON.message :
                                        'Une erreur est survenue.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            } else {
                                Swal.fire({
                                    title: 'Erreur',
                                    text: xhr.responseJSON ? xhr.responseJSON.message :
                                        'Une erreur est survenue.',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                });
                            }
                        }
                    });
                });





            });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/vente/create.blade.php ENDPATH**/ ?>