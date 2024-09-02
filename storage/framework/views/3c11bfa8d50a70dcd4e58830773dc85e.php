<div class="header-bottom transparent-bar black-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="main-menu">
                    <nav>
                        <ul>
                            <li><a href="<?php echo e(route('accueil')); ?>">Accueil</a></li>
                            
                              <?php $__currentLoopData = $menu_link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li><a href="<?php echo e(route('produit' , $menu->slug)); ?>"><?php echo e($menu->name); ?> </a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li><a href="#">Menu du jour</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- mobile-menu-area-start -->


<!-- mobile-menu-area-end -->
<?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/site/layouts/menu_desktop/menu.blade.php ENDPATH**/ ?>