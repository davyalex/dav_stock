<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" data-topbar="light" data-sidebar-image="none"
    data-theme="default" data-theme-colors="default">

<head>
    <meta charset="utf-8" />
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name')); ?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Tableau de bord d'administration pour le restaurant Chez Jeanne" name="description" />
    <meta content="Ticafrique" name="author" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- App favicon -->
    
    <link rel="apple-touch-icon" sizes="57x57" href="<?php echo e(asset('assets/img/favicon/apple-icon-57x57.png')); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo e(asset('assets/img/favicon/apple-icon-60x60.png')); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo e(asset('assets/img/favicon/apple-icon-72x72.png')); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo e(asset('assets/img/favicon/apple-icon-76x76.png')); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo e(asset('assets/img/favicon/apple-icon-114x114.png')); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo e(asset('assets/img/favicon/apple-icon-120x120.png')); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo e(asset('assets/img/favicon/apple-icon-144x144.png')); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo e(asset('assets/img/favicon/apple-icon-152x152.png')); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo e(asset('assets/img/favicon/apple-icon-180x180.png')); ?>">
    <link rel="icon" type="image/png" sizes="192x192"
        href="<?php echo e(asset('assets/img/favicon/android-icon-192x192.png')); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo e(asset('assets/img/favicon/favicon-32x32.png')); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?php echo e(asset('assets/img/favicon/favicon-96x96.png')); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo e(asset('assets/img/favicon/favicon-16x16.png')); ?>">
    <link rel="manifest" href="<?php echo e(asset('assets/img/favicon/manifest.json')); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?php echo e(asset('assets/img/favicon/ms-icon-144x144.png')); ?>">
    <meta name="theme-color" content="#ffffff">
    <?php echo $__env->make('backend.layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php echo $__env->make('sweetalert::alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->yieldContent('body'); ?>

<?php echo $__env->yieldContent('content'); ?>

<?php echo $__env->make('backend.layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html>
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/layouts/master-without-nav.blade.php ENDPATH**/ ?>