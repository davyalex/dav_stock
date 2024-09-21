

<?php $__env->startSection('content'); ?>


    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Achat
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Modifier un achat
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>
    <style>
        form label {
            font-size: 11px
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('achat.update', $data_achat['id'])); ?>" autocomplete="off"
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
                                                    value="<?php echo e($data_achat['type_produit']['name']); ?>" readonly>


                                            </div>
                                            

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Format
                                                </label>
                                                <select class="form-control js-example-basic-single format" name="format_id"
                                                    required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    <?php $__currentLoopData = $data_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option data-value=<?php echo e($format->libelle); ?>

                                                            value="<?php echo e($format->id); ?>"
                                                            <?php echo e($format->id == $data_achat->format_id ? 'selected' : ''); ?>>
                                                            <?php echo e($format->libelle); ?>

                                                            (<?php echo e($format->abreviation); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Nombre de
                                                    <?php echo e($data_achat['format']['libelle']); ?>

                                                </label>
                                                <input type="text" class="form-control"
                                                    value="<?php echo e($data_achat['quantite_format']); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Fournisseur
                                                </label>
                                                <select class="form-control js-example-basic-single" name="fournisseur_id">
                                                    <option value="" disabled selected>Choisir</option>
                                                    <?php $__currentLoopData = $data_fournisseur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fournisseur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($fournisseur->id); ?>"
                                                            <?php echo e($fournisseur->id == $data_achat->fournisseur_id ? 'selected' : ''); ?>>
                                                            <?php echo e($fournisseur->nom); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Unite de vente
                                                </label>
                                                <select id="unite" class="form-control js-example-basic-single"
                                                    name="unite_id" required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option data-value="<?php echo e($unite->libelle); ?>"
                                                            value="<?php echo e($unite->id); ?>"
                                                            <?php echo e($unite->id == $data_achat->unite_id ? 'selected' : ''); ?>>
                                                            <?php echo e($unite->libelle); ?>

                                                            (<?php echo e($unite->abreviation); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Quantité stocké
                                                </label>
                                                <input type="text" id="quantiteStocke" class="form-control"
                                                    value="<?php echo e($data_achat['quantite_stockable']); ?>" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
                                                <input type="number" id="prixAchatUnitaire"
                                                    value="<?php echo e($data_achat['prix_achat_unitaire']); ?>" class="form-control"
                                                    name="prix_achat_unitaire"readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat total </label>
                                                <input type="number" id="prixAchatTotal"
                                                    value="<?php echo e($data_achat['prix_achat_total']); ?>" class="form-control"
                                                    name="prix_achat_total" readonly>
                                            </div>
                                            <div
                                                class="col-md-3 mb-3 <?php echo e($data_achat['prix_vente'] ? 'd-block' : 'd-none'); ?>">
                                                <label class="form-label" for="stocks-input">Prix de vente </label>
                                                <input type="number" value="<?php echo e($data_achat['prix_vente']); ?>"
                                                    class="form-control" name="prix_vente_unitaire"
                                                    <?php echo e($data_achat['prix_vente'] ? 'required' : ''); ?>>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-check-label" for="customAff">Activer le stock</label>

                                                <div class="form-check form-switch form-switch-lg col-md-2" dir="ltr">
                                                    <input type="checkbox" name="statut" class="form-check-input"
                                                        id="customAff"
                                                        <?php echo e($data_achat['statut'] == 'active' ? 'checked' : ''); ?>>
                                                </div>

                                            </div>
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
                                                    id="sku"><?php echo e($data_achat['produit']['code']); ?> </span></p>
                                            <p>Nom : <span class="fw-bold"
                                                    id="sku"><?php echo e($data_achat['produit']['nom']); ?> </span></p>
                                            <p>Stock actuel : <span class="fw-bold"
                                                    id="stock"><?php echo e($data_achat['produit']['stock']); ?></span></p>
                                            <p>Stock alerte : <span class="fw-bold text-danger"
                                                    id="stockAlerte"><?php echo e($data_achat['produit']['stock_alerte']); ?></span>
                                            </p>
                                            <p>Categorie : <span class="fw-bold"
                                                    id="categorie"><?php echo e($data_achat['produit']['categorie']['name']); ?></span>
                                            </p>

                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded" id="product-img">
                                                            <img src="<?php echo e(asset($data_achat->produit->getFirstMediaUrl('ProduitImage'))); ?>"
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
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/stock/achat/edit.blade.php ENDPATH**/ ?>