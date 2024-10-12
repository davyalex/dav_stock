
<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.signin'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if($setting != null): ?>
        <style>
            .auth-one-bg {
                background-image: url('<?php echo e($setting->getFirstMediaUrl('cover')); ?>');
                background-position: center;
                background-size: cover;
            }
        </style>
    <?php else: ?>
        <style>
            .auth-one-bg {
                background-image: url(/build/icons/auth-one-bg.jpg);
                background-position: center;
                background-size: cover;
            }
        </style>
    <?php endif; ?>



    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>

                                <?php if($setting != null): ?>
                                    <a href="index" class="d-inline-block auth-logo">
                                        <img src="<?php echo e(URL::asset($setting->getFirstMediaUrl('logo_header'))); ?>"
                                            alt=""  width="50" class="rounded-circle">
                                    </a>
                                    <p class="mt-3 fs-15 fw-medium"> <?php echo e($setting['projet_title'] ?? ''); ?> </p>
                                <?php else: ?>
                                    <h3>PROJET NAME</h3>
                                <?php endif; ?>

                            </div>
                            <p class="mt-3 fs-15 fw-medium"> <?php echo e($setting['projet_description'] ?? ''); ?> </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">
                            <?php echo $__env->make('backend.components.alertMessage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Bienvenue ! <?php echo e(Auth::user()->first_name); ?> </h5>
                                    <p class="text-muted">Veuillez sélectionner une caisse pour continuer</p>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="<?php echo e(route('caisse.select.post')); ?>" method="post" class="needs-validation"
                                        novalidate>
                                        <?php echo csrf_field(); ?>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Selectionner une caisse</label>
                                            <select class="form-control" name="caisse" required>
                                                <option disabled value selected>Selectionner</option>
                                                <?php $__currentLoopData = $data_caisse; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->libelle); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Valider</button>
                                        </div>

                                       
                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                       

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> <?php echo e(config('app.name')); ?>. Conçu avec <i
                                class="mdi mdi-heart text-danger"></i> par
                            Ticafrique</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/particles.js/particles.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/particles.app.js')); ?>"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/password-addon.init.js')); ?>"></script>


    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master-without-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/auth-admin/select-caisse.blade.php ENDPATH**/ ?>