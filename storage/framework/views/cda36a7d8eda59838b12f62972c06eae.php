

<?php $__env->startSection('content'); ?>


    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Nouveau Ajustement
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Créer un ajustement
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <style>
        form label {
            font-size: 11px
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                role="alert">
                <i class="ri-airplay-line label-icon"></i><strong>Pour ajuster le stock : </strong>
                <ol>
                    <li>Choisir le mouvement (Ajouter ou soustraire)</li>
                    <li>Ajouter la quantité</li>
                    <li>Vous pouvez desactiver ou activer le stock en cliquant sur le bouton statut en bas</li>
                </ol>
                <button type="button" class="btn-close" data-bs-dismiss=" alert" aria-label="Close"></button>
            </div>
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('ajustement.store')); ?>" autocomplete="off"
                        class="needs-validation" novalidate enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Type de produit
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_ajustement['type_produit']['name']); ?>" readonly>


                                            </div>
                                            

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Format
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_ajustement['format']['libelle'] ?? ''); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Nombre de
                                                    <?php echo e($data_ajustement['format']['libelle']); ?>

                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_ajustement['quantite_format']); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Fournisseur
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_ajustement['fournisseur']['nom'] ?? ''); ?>" readonly>
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Unite de vente
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_ajustement['unite']['libelle']); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Quantité stocké
                                                </label>
                                                <input type="text" id="quantiteStocke" class="form-control"
                                                    value="<?php echo e($data_ajustement['quantite_stockable']); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
                                                <input type="number" id="prixAchatUnitaire"
                                                    value="<?php echo e($data_ajustement['prix_achat_unitaire']); ?>"
                                                    class="form-control" name="prix_achat_unitaire" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat total </label>
                                                <input type="number" id="prixAchatTotal"
                                                    value="<?php echo e($data_ajustement['prix_achat_total']); ?>" class="form-control"
                                                    name="prix_achat_total" readonly>
                                            </div>


                                            <div class="d-flex justify-content-between">
                                                <hr class="w-50" size="5">
                                                <h5>Ajustement</h5>
                                                <hr class="w-50 text-primary" size="5">
                                            </div>
                                            <p id="MsgError" class="text-danger fw-bold"></p>
                                            <div class="col-md-6">
                                                <label class="form-label" for="product-title-input">Mouvement du stock
                                                </label>
                                                <select id="mouvementStock" class="form-control js-example-basic-single"
                                                    name="mouvement" required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    <option value="ajouter">Ajouter</option>
                                                    <option value="retirer">Retirer</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3 ">
                                                <label class="form-label" for="stocks-input">Quantité <span></span> <span
                                                        class="text-danger" id="labelUnite"></span></label>
                                                <br>
                                                <div class="input-step w-100">
                                                    <button type="button" class="minus w-50 btn btn-primary decreaseValue"
                                                        disabled>-</button>
                                                    <input type="number" class="form-control" id="quantiteStockable"
                                                        value="0" name="stock_ajustement" readonly>
                                                    <button type="button" class="plus w-50 btn btn-primary increaseValue"
                                                        disabled>+</button>
                                                </div>
                                            </div>

                                            

                                            <input type="text" name="achat_id" value="<?php echo e($data_ajustement['id']); ?>"
                                                hidden>

                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body border border-primary border-dashed">
                                        <div class="mb-4">

                                            <p>Sku : <span class="fw-bold"
                                                    id="sku"><?php echo e($data_ajustement['produit']['code']); ?> </span></p>
                                            <p>Nom : <span class="fw-bold"
                                                    id="sku"><?php echo e($data_ajustement['produit']['nom']); ?> </span></p>
                                            <p>Stock actuel : <span class="fw-bold"
                                                    id="stock"><?php echo e($data_ajustement['produit']['stock']); ?></span></p>
                                            <p>Stock alerte : <span class="fw-bold text-danger"
                                                    id="stockAlerte"><?php echo e($data_ajustement['produit']['stock_alerte']); ?></span>
                                            </p>
                                            <p>Categorie : <span class="fw-bold"
                                                    id="categorie"><?php echo e($data_ajustement['produit']['categorie']['name']); ?></span>
                                            </p>

                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded" id="product-img">
                                                            <img src="<?php echo e(asset($data_ajustement->produit->getFirstMediaUrl('ProduitImage'))); ?>"
                                                                id="product-img" class="avatar-md h-auto" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        

                                    </div>
                                </div>
                                <!-- end card -->


                            </div>
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
            // script for quantity stock increase and dicrease
            $(document).ready(function() {

                //recuperer le type du mouvement selectionné
                $('#mouvementStock').change(function() {
                    var mouvementStock = $('#mouvementStock option:selected').val();
                    $('#quantiteStockable').prop('readonly', false)
                    $('#quantiteStockable').val(0) // nouvelle quantité a stocké
                    if (mouvementStock == 'ajouter') {
                        $('.increaseValue').prop('disabled', false)
                        $('.decreaseValue').prop('disabled', true)

                    } else if (mouvementStock == 'retirer') {
                        $('.decreaseValue').prop('disabled', false)
                        $('.increaseValue').prop('disabled', true)
                        verifiyQty()

                    } else {
                        $('.increaseValue').prop('disabled', true)
                        $('.decreaseValue').prop('disabled', true)
                    }

                });


                //increase and decrease Qty stock
                $('.increaseValue').click(function(e) {
                    e.preventDefault();
                    var input = document.getElementById("quantiteStockable");
                    var value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    value++;
                    input.value = value;
                });


                $('.decreaseValue').click(function(e) {
                    e.preventDefault();
                    var qteStock = $('#quantiteStocke').val() // qté stocké du stock
                    var input = document.getElementById("quantiteStockable");
                    var value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    // value < 1 ? value = 1 : '';
                    // if (value > 1) {
                    //     value--;
                    // }
                    // value--;
                    if (value < qteStock - 1) {
                        value++;
                    }

                    input.value = value;
                    // verifiyQty()
                });


                // verifier le nombre entrer en reel de quantité
                function verifiyQty() {
                    $('#quantiteStockable').on('input', function() {
                        var qteStock = $('#quantiteStocke').val() // qté stocké du stock
                        let currentValue = parseInt($(this).val());
                        if (currentValue > qteStock-1) {
                            // $(this).val(qteStock - 1);
                            $('#MsgError').html('La quantité entrée est supérieur ou égale à la quantité stockée ')
                        }else{
                            $('#MsgError').html('')
                        }
                    });
                }

            });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/stock/ajustement/create.blade.php ENDPATH**/ ?>