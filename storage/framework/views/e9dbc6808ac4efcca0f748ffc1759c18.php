<!--Afficher les sous categories en option dans produit -->

<option value="<?php echo e($category->id); ?>" <?php echo e($data_produit['categorie_id'] == $category->id ? 'selected' :''); ?>><?php echo e(str_repeat('--', $level ?? 0)); ?> <?php echo e($category->name); ?></option>
<?php if($category->children): ?>
    <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make('backend.pages.produit.partials.subCategorieOptionEdit', ['category' => $child, 'level' => ($level ?? 0) + 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/backend/pages/produit/partials/subCategorieOptionEdit.blade.php ENDPATH**/ ?>