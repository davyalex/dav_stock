<!-- categorie_menu.blade.php -->
<ul id="faq">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if($categorie->children->isNotEmpty()): ?>
                <a data-bs-toggle="collapse" data-bs-parent="#faq" 
                   href="#shop-categorie-<?php echo e($categorie->id); ?>" 
                   class="" 
                   aria-expanded="true">
                    <?php echo e($categorie->name); ?> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-<?php echo e($categorie->id); ?>" 
                    class="panel-collapse collapse show">
                    <?php $__currentLoopData = $categorie->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('site.sections.categorie.categoriemenu', ['categories' => [$child]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <a href="<?php echo e(route('produit' , $categorie->slug)); ?>"><?php echo e($categorie->name); ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/categorie/categoriemenu.blade.php ENDPATH**/ ?>