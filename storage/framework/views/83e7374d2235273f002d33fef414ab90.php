<ul id="faq">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if($categorie->children->isNotEmpty()): ?>
                <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#shop-categorie-<?php echo e($categorie->id); ?>"
                    class="text-danger <?php echo e($categorie->famille == $categorieSelect->famille ? 'show' : 'collapsed'); ?>"
                    aria-expanded="<?php echo e($categorie->famille == $categorieSelect->famille ? 'true' : 'false'); ?>">
                    <strong class="fs-6">
                        <?php if($categorie->slug === 'bar'): ?>
                            Boissons
                        <?php elseif($categorie->slug === 'cuisine-interne'): ?>
                            Restaurant
                        <?php else: ?>
                            <?php echo e($categorie->name); ?>

                        <?php endif; ?>
                    </strong> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-<?php echo e($categorie->id); ?>"
                    class="panel-collapse collapse <?php echo e($categorie->famille == $categorieSelect->famille ? 'show' : ''); ?>">
                    <?php $__currentLoopData = $categorie->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('site.sections.categorie.categorieproduit', [
                            'categories' => [$child],
                            'categorieSelect' => $categorieSelect,
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <a href="<?php echo e(route('produit', $categorie->id)); ?>"
                    class="<?php echo e($categorie->id == $categorieSelect->id ? 'fw-bold' : ''); ?>">
                    <?php if($categorie->slug === 'bar'): ?>
                        Boissons
                    <?php elseif($categorie->slug === 'cuisine-interne'): ?>
                        Restaurant
                    <?php else: ?>
                       <span class="text-capitalize"> <?php echo e($categorie->name); ?></span>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/categorie/categorieproduit.blade.php ENDPATH**/ ?>