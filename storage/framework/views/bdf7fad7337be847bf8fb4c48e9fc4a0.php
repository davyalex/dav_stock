

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Menu
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Modifier un menu
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <!-- ========== Start menu list ========== -->
        <?php echo $__env->make('backend.pages.menu.menu-list', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ========== End menu list ========== -->


        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <form class="row g-3 needs-validation" method="post"
                        action="<?php echo e(route('menu.update', $data_menu_edit['id'])); ?>" novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Menu principal </label>
                            <input type="text" name="name" value="<?php echo e($data_menu_edit['name']); ?>" class="form-control"
                                id="validationCustom01" placeholder="Menu1" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Position </label>
                            <select name="position" class="form-control">
                                <?php for($i = 1; $i <= $data_count; $i++): ?>
                                    <option value="<?php echo e($i); ?>" <?php echo e($data_menu_edit['position'] == $i ? 'selected' : ''); ?>>
                                        <?php echo e($i); ?>

                                    </option>
                                <?php endfor; ?>
                            </select>
                        </div>


                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Url</label>
                            <input type="text" name="url" class="form-control" id="validationCustom01"
                                value="<?php echo e($data_menu_edit['url']); ?>">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        

                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Statut</label>
                            <select name="status" class="form-control">
                                <option value="active" <?php echo e($data_menu_edit['status'] == 'active' ? 'selected' : ''); ?>>
                                    Activé
                                </option>
                                <option value="desactive" <?php echo e($data_menu_edit['status'] == 'desactive' ? 'selected' : ''); ?>>
                                    Desactivé
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>



                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 ">Modifier</button>
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
    
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\admin\ticafriqueAdmin\resources\views/backend/pages/menu/menu-edit.blade.php ENDPATH**/ ?>