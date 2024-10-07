
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.permissions'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            Liste
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Modifier les permissions
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <form action="<?php echo e(route('permission.update', $role->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Modifier le rôle</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="role_name" class="form-label">Nom du rôle</label>
                                <input type="text" class="form-control" id="role_name" name="name"
                                    value="<?php echo e($role->name); ?>" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Autorisations / Permissions</h5>
                            <button type="button" class="btn btn-sm btn-primary" id="toggle-all-modules">Tout
                                cocher/décocher</button>
                        </div>
                    </div>
                </div>
                <?php $__currentLoopData = $modules_with_permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0"><?php echo e($module->name); ?></h5>
                                <button type="button" class="btn btn-sm btn-primary toggle-all"
                                    data-module="<?php echo e($module->id); ?>">Tout cocher/décocher</button>
                            </div>
                            <div class="card-body">
                                <?php $__currentLoopData = $module->permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input module-<?php echo e($module->id); ?>" type="checkbox"
                                            name="permissions[]" value="<?php echo e($permission->id); ?>"
                                            id="permission_<?php echo e($permission->id); ?>"
                                            <?php echo e($role->hasPermissionTo($permission->name) ? 'checked' : ''); ?>>
                                        <label class="form-check-label" for="permission_<?php echo e($permission->id); ?>">
                                            <?php echo e($permission->name); ?>

                                        </label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Mettre à jour les permissions</button>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButtons = document.querySelectorAll('.toggle-all');

            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const moduleId = this.getAttribute('data-module');
                    const checkboxes = document.querySelectorAll(`.module-${moduleId}`);

                    const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

                    checkboxes.forEach(checkbox => {
                        checkbox.checked = !allChecked;
                    });

                    this.textContent = allChecked ? 'Tout cocher' : 'Tout décocher';
                });
            });


            // Fonction pour tout cocher en même temps
            const cocherTout = document.getElementById('toggle-all-modules');
            cocherTout.addEventListener('click', function() {
                const toutesLesCheckboxes = document.querySelectorAll('input[type="checkbox"]');
                const toutCoche = Array.from(toutesLesCheckboxes).every(checkbox => checkbox.checked);

                toutesLesCheckboxes.forEach(checkbox => {
                    checkbox.checked = !toutCoche;
                });

                cocherTout.textContent = toutCoche ? 'Tout cocher' : 'Tout décocher';

                // Mettre à jour le texte des boutons de chaque module
                const toggleButtons = document.querySelectorAll('.toggle-all');
                toggleButtons.forEach(button => {
                    button.textContent = toutCoche ? 'Tout cocher' : 'Tout décocher';
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/role-permission/edit.blade.php ENDPATH**/ ?>