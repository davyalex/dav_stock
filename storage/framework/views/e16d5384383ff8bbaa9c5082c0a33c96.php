<!-- mobile-menu-area-start -->
<li>
    <?php if($menu->children->isNotEmpty()): ?>
        <a href=""><?php echo e($menu['name']); ?>

        </a>
        <ul>
            <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('site.layouts.menu_mobile.menuchild', ['menu' => $child], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php else: ?>
        <a href="blog-rightsidebar.html"><?php echo e($menu['name']); ?> </a>
    <?php endif; ?>
</li>
<!-- mobile-menu-area-end -->


<?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/menu_mobile/menuchild.blade.php ENDPATH**/ ?>