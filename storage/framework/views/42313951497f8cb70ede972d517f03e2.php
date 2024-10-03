

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Menu
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Modifier un menu
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="<?php echo e(route('menu.update' , $data_menu['id'])); ?>" autocomplete="off" class="needs-validation"
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
                                                <input type="text" name="libelle" value="<?php echo e($data_menu['libelle']); ?>"
                                                    class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta-title-input">Date <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="currentDate" value="<?php echo e($data_menu['date_menu']); ?>"
                                                    name="date_menu" class="form-control" required>
                                            </div>

                                            <!-- ========== Start product menu for checked ========== -->
                                            <?php echo $__env->make('backend.pages.menu.partials.categorieProductEdit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <!-- ========== End product menu for checked ========== -->

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
                            <button type="submit" id="btnSubmit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->

        <!--end row-->
    

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/menu/edit.blade.php ENDPATH**/ ?>