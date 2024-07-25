<ul>
    <?php $__currentLoopData = $categories_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a href="<?php echo e($categorie->url); ?>"><?php echo e($categorie->name); ?></a>
            <a href="<?php echo e(route('categorie.edit', $categorie['id'])); ?>" class="fs-5" style="margin-left:30px"> <i
                    class=" ri ri-edit-2-fill ml-4"></i></a>

            <a href="<?php echo e(route('categorie.add-subCat', $categorie['id'])); ?>" class="fs-5"> <i
                    class=" ri ri-add-circle-fill ml-4"></i>
            </a>
            <?php if(count($categorie->children) == 0): ?>
                <a href="<?php echo e(route('categorie.delete', $categorie['id'])); ?>" class="fs-5"> <i
                        class="ri ri-delete-bin-2-line text-danger"></i>
                </a>
            <?php endif; ?>
            <?php if($categorie->children->count() > 0): ?>
                <?php echo $__env->make('backend.pages.categorie.partials.subcategorie', [
                    'categories_child' => $categorie->children,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/categorie/partials/subcategorie.blade.php ENDPATH**/ ?>