<div class="col-md-5">
    <label class="form-label" for="product-title-input">Fournisseur
    </label>
    <select class="form-control js-example-basic-single" name="fournisseur_id">
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
    <select class="form-control js-example-basic-single format" name="format_id" required>
        <option value="" disabled selected>Choisir</option>
        <?php $__currentLoopData = $data_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option data-value=<?php echo e($format->libelle); ?> value="<?php echo e($format->id); ?>"><?php echo e($format->libelle); ?>

                (<?php echo e($format->abreviation); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-3 mb-3">
    <label class="form-label" for="stocks-input">Qté <span class="text-lowercase libFormat" id="libFormat"> de
            format</span></label>
    <input type="number" id="qteFormat" name="quantite_format" class="form-control" required>
</div>

<div class="col-md-4">
    <label class="form-label" for="product-title-input">Unité de mesure
    </label>
    <select id="unite" class="form-control js-example-basic-single" name="unite_id" required>
        <option value="" disabled selected>Choisir</option>
        <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option data-value="<?php echo e($unite->libelle); ?>" value="<?php echo e($unite->id); ?>"><?php echo e($unite->libelle); ?>

                (<?php echo e($unite->abreviation); ?>)
            </option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
</div>

<div class="col-md-4 mb-3 ">
    <label class="form-label" for="stocks-input">Quantité stockable <span class="text-danger" id="labelUnite"></span></label>
    <br><div class="input-step w-100">
        <button type="button" class="minus w-50 btn btn-primary"  onclick="decreaseValue()" >-</button>
        <input type="number" class="form-control" id="quantiteStockable"  value="1" name="quantite_stockable" required>
        <button type="button" class="plus w-50 btn btn-primary"  onclick="increaseValue()">+</button>
    </div>
</div>





<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
    <input type="number" id="prixAchatUnitaire" class="form-control" name="prix_achat_unitaire" required>
</div>
<div class="col-md-2 mb-3">
    <label class="form-label" for="stocks-input">Prix d'achat total </label>
    <input type="number" id="prixAchatTotal" class="form-control" name="prix_achat_total">
</div>

<div class="col-md-3">
    <label class="form-check-label" for="customAff">Activer le stock</label>

    <div class="form-check form-switch form-switch-lg col-md-2" dir="ltr">
        <input type="checkbox" name="statut" class="form-check-input" id="customAff">
    </div>
    <div class="valid-feedback">
        Looks good!
    </div>
</div>


<?php /**PATH /home1/maxisgwd/restaurant.maxisujets.net/resources/views/backend/pages/stock/achat/partials/ingredient.blade.php ENDPATH**/ ?>