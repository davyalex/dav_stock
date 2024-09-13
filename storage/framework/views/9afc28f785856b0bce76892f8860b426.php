

<?php $__env->startSection('title', 'Connexion'); ?>
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    
    input[type="number"] {
        -moz-appearance: textfield;
    }
    </style>

<?php $__env->startSection('content'); ?>
<div class="login-register-area pt-95 pb-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-12 ml-auto mr-auto">
                <div class="login-register-wrapper">
                    <div class="login-register-tab-list nav">
                        <a class="active" data-bs-toggle="tab" href="#lg1">
                            <h4> Connexion </h4>
                        </a>
                        <a href="<?php echo e(route('user.register')); ?>">
                            <h4> Inscription </h4>
                        </a>
                    </div>
                    <div class="tab-content">
                        <div id="lg1" class="tab-pane active">
                            <div class="login-form-container">
                                <div class="login-register-form">
                                    <form action="<?php echo e(route('user.login.post')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="number" name="phone" placeholder="numero de telephone" required>
                                        
                                        <div class="button-box">
                                            
                                            <button type="submit"><span>Valider</span></button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('site.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/user-auth/login.blade.php ENDPATH**/ ?>