<ul>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <h4><?php echo e($category->name); ?></h4>

            <!-- Afficher les produits de cette catégorie -->
            <?php if(isset($groupedProducts[$category->id])): ?>
                <ul>
                    <?php $__currentLoopData = $groupedProducts[$category->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($product->nom); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php endif; ?>

            <!-- Appel récursif pour afficher les sous-catégories -->
            <?php if($category->children->isNotEmpty()): ?>
                <?php echo $__env->make('site.pages.category_recursive', [
                    'categories' => $category->children,
                    'groupedProducts' => $groupedProducts
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/pages/category_recursive.blade.php ENDPATH**/ ?>