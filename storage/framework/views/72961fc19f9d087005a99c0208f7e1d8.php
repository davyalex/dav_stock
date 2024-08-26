

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Menu
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Créer un nouveau menu
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('menu.store')); ?>" autocomplete="off" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-3 row">
                                            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                                                role="alert">
                                                <i class="ri-airplay-line label-icon"></i><strong>Selectionnez les
                                                    differents plats pour composer votre menu : </strong>

                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>

                                            <div class="col-md-8">
                                                <label class="form-label" for="meta-title-input">Libellé
                                                </label>
                                                <input type="text" name="libelle" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta-title-input">Date <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="currentDate" value="<?php echo date('Y-m-d'); ?>"
                                                    name="date_menu" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6">

                                            </div>

                                            <div class="row mt-4">
                                                <?php $__currentLoopData = $data_categorie_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="col-md-6">
                                                        <h4 class="my-3 text-capitalize"> <?php echo e($categorie['name']); ?> </h4>

                                                        <?php $__currentLoopData = $categorie->produit_menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <div class="form-check form-check-dark m-2 ">
                                                                <input class="form-check-input produit"
                                                                    value="<?php echo e($produit['id']); ?>" name="produits[]"
                                                                    type="checkbox" id="formCheck<?php echo e($produit->id); ?>">
                                                                <label class="form-check-label"
                                                                    for="formCheck<?php echo e($produit->id); ?>">
                                                                    <?php echo e($produit->nom); ?> <i class="text-danger">
                                                                        <?php echo e($produit->prix); ?> FCFA</i>
                                                                </label>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                                    </div><!--end col-->
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div><!--end row-->

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
                            <button type="submit" id="btnSubmit" class="btn btn-success w-lg" disabled>Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->

        <!--end row-->
    <?php $__env->startSection('script'); ?>
        <script>
            $(function() {
                // Vérifier lors du clic
                var checkedItems = []
                $('.produit').change(function() {
                    if ($(this).is(':checked')) {
                        checkedItems.push($(this).val());
                    } else {
                        var index = checkedItems.indexOf($(this).val());
                        if (index !== -1) {
                            checkedItems.splice(index, 1);
                        }
                    }

                    //disabled and enable button 
                    if (checkedItems.length > 0) {
                        $('#btnSubmit').prop('disabled', false);
                    } else {
                        $('#btnSubmit').prop('disabled', true);
                    }
                });
            });
        </script>
    <?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/backend/pages/menu/create.blade.php ENDPATH**/ ?>