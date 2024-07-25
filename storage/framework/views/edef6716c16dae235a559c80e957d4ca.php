<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModalEdit<?php echo e($item['id']); ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel"
                aria-hidden="true" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Modification </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="needs-validation" novalidate method="POST"
                                action="<?php echo e(route('admin-register.update' , $item['id'])); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nom</label>
                                    <input type="text" value="<?php echo e($item['last_name']); ?>" name="last_name" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Prenoms</label>
                                    <input type="text" value="<?php echo e($item['first_name']); ?>" name="first_name" class="form-control" id="username"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Email</label>
                                    <input type="email" value="<?php echo e($item['email']); ?>" name="email" class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Telephone</label>
                                    <input type="number" value="<?php echo e($item['phone']); ?>" name="phone" class="form-control" id="username" required>
                                </div>

                                

                                <div class="mb-3">
                                    <label for="username" class="form-label">Role</label>
                                    <select class="form-control" name="role" id="" required>
                                        <option disabled selected value>Selectionner...</option>
                                        <?php $__currentLoopData = $data_role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($role['name']); ?>" <?php echo e($role['id'] == $item['roles'][0]['id'] ? 'selected' : ''); ?>><?php echo e($role['name']); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mt-3">
                                    <button class="btn btn-success w-100" type="submit">Valider</button>
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


<?php /**PATH C:\laragon\www\admin\Laravel\master\resources\views/backend/pages/auth-admin/register/edit.blade.php ENDPATH**/ ?>