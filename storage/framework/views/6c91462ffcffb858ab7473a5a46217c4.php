
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.settings'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xxl-9">
            <div class="card mt-xxl-n5">
                <div class="card-header">
                    <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab">
                                <i class="fas fa-home"></i> Mes informations
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#privacy" role="tab">
                                <i class="far fa-envelope"></i> Modifier mon mot de passe
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content">
                        <div class="tab-pane active" id="personalDetails" role="tabpanel">
                            <form class="needs-validation" novalidate method="POST"
                                action="<?php echo e(route('admin-register.update', Auth::user()->id)); ?>"
                                enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Nom</label>
                                    <input type="text" value="<?php echo e($data_admin['last_name']); ?>" name="last_name"
                                        class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Prenoms</label>
                                    <input type="text" value="<?php echo e($data_admin['first_name']); ?>" name="first_name"
                                        class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Email</label>
                                    <input type="email" value="<?php echo e($data_admin['email']); ?>" name="email"
                                        class="form-control" id="username" required>
                                </div>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Telephone</label>
                                    <input type="number" value="<?php echo e($data_admin['phone']); ?>" name="phone"
                                        class="form-control" id="username" required>
                                </div>

                                

                                

                                <div class="mt-3">
                                    <button class="btn btn-success w-100" type="submit">Modifier</button>
                                </div>


                            </form>

                        </div>
                        <!--end tab-pane-->


                        <div class="tab-pane" id="privacy" role="tabpanel">
                            <div class="mb-4 pb-2">
                                <form class="needs-validation" novalidate method="POST"
                                    action="<?php echo e(route('admin-register.new-password')); ?>"
                                    enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Ancien mot de passe</label>
                                        <input type="password" name="old_password" class="form-control" id="username" required>
                                    </div>


                                     <div class="mb-3">
                                        <label for="username" class="form-label">Nouveau mot de passe</label>
                                        <input type="password" name="new_password" class="form-control" id="username" required>
                                    </div>



                                    <div class="mt-3">
                                        <button class="btn btn-success w-100" type="submit">Modifier</button>
                                    </div>


                                </form>

                            </div>
                        </div>
                        <!--end tab-pane-->
                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/js/pages/profile-setting.init.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\admin\Laravel\master\resources\views/backend/pages/auth-admin/register/profil.blade.php ENDPATH**/ ?>