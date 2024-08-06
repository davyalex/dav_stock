<div class="col-md-4">
    <label class="form-label" for="product-title-input">Fournisseur
    </label>
    <select class="form-control js-example-basic-single" name="categorie">
        <option value="" disabled selected>Choisir</option>
        <?php $__currentLoopData = $data_fournisseur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fournisseur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($fournisseur->id); ?>"><?php echo e($fournisseur->nom); ?>

            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-4 mb-3">
    <label class="form-label" for="product-title-input">Format
    </label>
    <select class="form-control js-example-basic-single format" name="format" required>
        <option value="" disabled selected>Choisir</option>
        <?php $__currentLoopData = $data_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option data-value=<?php echo e($format->libelle); ?> value="<?php echo e($format->id); ?>"><?php echo e($format->libelle); ?>

                (<?php echo e($format->abreviation); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Qté <span class="text-lowercase libFormat"
            id="libFormat"> de format</span></label>
    <input type="number" class="form-control" required>
</div>
<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Qté total <span class="text-lowercase libFormat"
            id="libPiece">/ format</span></label>
    <input type="number" class="form-control">
</div>
<div class="col-md-4">
    <label class="form-label" for="product-title-input">Unité de mesure
    </label>
    <select id="unite" class="form-control js-example-basic-single" name="unite" required>
        <option value="" disabled selected>Choisir</option>
        <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option data-value="<?php echo e($unite->libelle); ?>" value="<?php echo e($unite->id); ?>"><?php echo e($unite->libelle); ?>

                (<?php echo e($unite->abreviation); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Unité unitaire <span class="text-lowercase libUnite"
            id="libPiece"></span></label>
    <input type="number" class="form-control" name="unite_unitaire" required>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Unité globale <span class="text-lowercase libUnite"
            id="libPiece"></span></label>
    <input type="number" class="form-control" name="unite_globale" required>
</div>

<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat </label>
    <input type="number" class="form-control" name="prix_achat" required>
</div>
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/produit/entree/restaurantProduct.blade.php ENDPATH**/ ?>