<!doctype html>
<html class="no-js" lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo e(config('app.name')); ?> - <?php echo $__env->yieldContent('title'); ?> </title>
    <meta name="description" content="">
    <meta name="robots" content="noindex, follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">

    <?php echo $__env->make('site.layouts.vendor-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>
   
    <?php echo $__env->make('site.layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- header start -->

    <?php if(!Request::routeIs('accueil')): ?>
    <?php echo $__env->make('site.components.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?> <!-- content start -->

    <?php echo $__env->make('site.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <!-- footer start -->
</body>

</html>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/layouts/app.blade.php ENDPATH**/ ?>