
<?php $__currentLoopData = $data_slide; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php if($item->type=='carrousel'): ?>
<div class="slider-area-2">
    <div class="slider-active owl-dot-style owl-carousel">
        <div class="single-slider pt-210 pb-220 bg-img"
            style="background-image:url('<?php echo e($item->getFirstMediaUrl('slideImage')); ?>');">
            <div class="container">
                <div class="slider-content slider-animated-2 text-center">
                    <h1 class="animated"> <?php echo e($item->title); ?> </h1>
                    <h3 class="animated"> <?php echo e($item->subtitle); ?></h3>
                    <div class="slider-btn mt-90">
                        <a class="animated" href="<?php echo e($item->btn_url); ?>">  <?php echo e($item->btn_name); ?>  </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/site/sections/slider.blade.php ENDPATH**/ ?>