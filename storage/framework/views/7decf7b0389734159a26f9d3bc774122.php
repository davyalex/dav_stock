<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer une permission </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post"
                                action="<?php echo e(route('permission.store')); ?>" novalidate>
                                <?php echo csrf_field(); ?>
                                
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Module</label>
                                    <select name="module" class="form-control" id="module">
                                        <option disabled selected value>Selectionner</option>
                                        <?php $__currentLoopData = $module; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($modules['id']); ?>" data-name = "<?php echo e($modules['name']); ?>"><?php echo e($modules['name']); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Roles</label>
                                    <select name="role" class="form-control">
                                        <option disabled selected value>Selectionner</option>
                                        <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($roles['id']); ?>"><?php echo e($roles['name']); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Permissions</label>
                                    <select name="permissions[]" class="form-control js-example-basic-multiple" multiple>
                                        <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permissions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($permissions['name']); ?>"><?php echo e($permissions['name']); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary ">Valider</button>
                        </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!-- end col -->
    </div><!-- end row -->
</div><!-- end col -->
</div>
<!--end row-->




<?php /**PATH C:\laragon\www\ticafriqueAdmin\resources\views/backend/pages/permission/create.blade.php ENDPATH**/ ?>