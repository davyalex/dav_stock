<header class="header-area">
    <?php echo $__env->make('site.layouts.topbar1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('site.layouts.topbar2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('site.layouts.menu_desktop.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('site.layouts.menu_mobile.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</header>
<?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/site/layouts/header.blade.php ENDPATH**/ ?>