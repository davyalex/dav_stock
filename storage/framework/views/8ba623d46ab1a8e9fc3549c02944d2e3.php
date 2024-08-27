<?php $__currentLoopData = $data_categorie_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-12">
        <?php
            //style manipulation
            $dNone =
                $categorie->produits->isEmpty() && $categorie->type != 'plats' && $categorie->children->isEmpty()
                    ? 'd-none'
                    : '';
            $textUpper = in_array($categorie->type, ['plats', 'boissons'])
                ? 'text-uppercase alert alert-primary alert-border-left fs-4 mt-4'
                : 'text-capitalize fw-bold';

            //get produit_menu for checked default store
            $menu_produit = [];
            foreach ($data_menu['produits'] as $value) {
                array_push($menu_produit, $value['id']);
            }
        ?>

        <h5 class="<?php echo e($dNone); ?> <?php echo e($textUpper); ?>"><?php echo e($categorie->name); ?></h5>

        <?php $__currentLoopData = $categorie->produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="form-check form-check-dark m-2 ">
                <input class="form-check-input fs-5 produit" value="<?php echo e($produit['id']); ?>" name="produits[]" type="checkbox"
                    id="formCheck<?php echo e($produit->id); ?>" <?php echo e(in_array($produit->id, $menu_produit) ? 'checked' : ''); ?>>
                <label class="form-check-label" for="formCheck<?php echo e($produit->id); ?>">
                    <?php echo e($produit->nom); ?> - <i class="text-danger">
                        <?php echo e($produit->prix); ?> FCFA</i>
                </label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <div class="m-3 ">
            <?php if($categorie->children->isNotEmpty()): ?>
                <?php echo $__env->make('backend.pages.menu.partials.categorieProductEdit', [
                    'data_categorie_produit' => $categorie->children,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </div><!--end col-->
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/menu/partials/categorieProductEdit.blade.php ENDPATH**/ ?>