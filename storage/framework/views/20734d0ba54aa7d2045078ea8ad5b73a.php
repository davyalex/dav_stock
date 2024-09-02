<!-- resources/views/partials/categorie_menu.blade.php -->
<ul id="faq">
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if($categorie->children->isNotEmpty()): ?>
                <a data-bs-toggle="collapse" data-bs-parent="#faq" 
                   href="#shop-categorie-<?php echo e($categorie->id); ?>" 
                   class="<?php echo e($categorieSelect->id == $categorie->id ? '' : 'collapsed'); ?>" 
                   aria-expanded="<?php echo e($categorieSelect->id == $categorie->id ? 'true' : 'false'); ?>">
                    <?php echo e($categorie->name); ?> <i class="ion-ios-arrow-down"></i>
                </a>
                <ul id="shop-categorie-<?php echo e($categorie->id); ?>" 
                    class="panel-collapse collapse <?php echo e($categorieSelect->id == $categorie->id ? 'show' : ''); ?>">
                    <?php $__currentLoopData = $categorie->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('site.sections.categorie.categoriechild', ['categories' => [$child], 'categorieSelect' => $categorieSelect], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            <?php else: ?>
                <a href="<?php echo e(route('produit' , $categorie->slug)); ?>"><?php echo e($categorie->name); ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/categorie/categoriechild.blade.php ENDPATH**/ ?>