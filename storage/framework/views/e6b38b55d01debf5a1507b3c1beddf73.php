




<li>
    
    <!-- Afficher le lien de la catégorie avec un bouton pour la collapse -->
    <a data-bs-toggle="collapse" data-bs-parent="#faq" href="#subcategory-<?php echo e($categorie->id); ?>">
        


           <a href="/menu?categorie=<?php echo e($categorie->slug); ?>"> <?php echo e($categorie->name); ?></a>
        
    </a>

    <!-- Afficher les enfants de la catégorie actuelle, s'ils existent -->
    <?php if($categorie->children && $categorie->children->isNotEmpty()): ?>
        <ul id="subcategory-<?php echo e($categorie->id); ?>" class="panel-collapse collapse">
            <?php $__currentLoopData = $categorie->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subchild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <!-- Inclure la vue récursive pour chaque sous-catégorie -->
                <?php echo $__env->make('site.sections.categorie.categoriemenu', ['categorie' => $subchild], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    <?php endif; ?>
</li>


<?php /**PATH C:\laragon\www\restaurant\resources\views/site/sections/categorie/categoriemenu.blade.php ENDPATH**/ ?>