<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                            <?php $__currentLoopData = $menu_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('site.layouts.menu.menuchild', ['menu' => $menu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area-start -->
<div class="mobile-menu-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="mobile-menu">
                    <nav id="mobile-menu-active">
                        <ul class="menu-overflow" id="nav">
                            <li><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                            <?php $__currentLoopData = $menu_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('site.layouts.menu.menuchild', ['menu' => $menu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area-end -->
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/menu/menu.blade.php ENDPATH**/ ?>