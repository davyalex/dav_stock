
<div class="slider-area-2">
    <div class="slider-active owl-dot-style owl-carousel">
        <?php $__currentLoopData = $data_slide->where('type', 'carrousel'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $item->getMedia('carrousel'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $media): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="single-slider pt-210 pb-220 bg-img" style="background-image:url('<?php echo e($media->getUrl()); ?>');">
                    <div class="container">
                        <div class="slider-content slider-animated-2 text-center">
                            <h1 class="animated"><?php echo e($item->title); ?></h1>
                            <h3 class="animated"><?php echo e($item->subtitle); ?></h3>
                            <?php if($item->btn_url && $item->btn_name): ?>
                                <div class="slider-btn mt-90">
                                    <a class="animated" href="<?php echo e($item->btn_url); ?>"><?php echo e($item->btn_name); ?></a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<?php /**PATH C:\laragon\www\restaurant\Restaurant-chez-jeanne\resources\views/site/sections/slider.blade.php ENDPATH**/ ?>