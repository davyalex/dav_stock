<!-- Default Modals -->
<div id="myModalEdit<?php echo e($item['id']); ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
    style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Modification </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post"
                    action="<?php echo e(route('depense.update', $item['id'])); ?>" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Categorie</label>
                            <select name="categorie_depense" class="form-control categorie-select" required>
                                <option disabled selected value="">Selectionner</option>
                                <?php $__currentLoopData = $categorie_depense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!-- Si la catégorie a des libelleDepenses, rendre l'option non cliquable -->
                                    <option
                                        <?php echo e($data['id'] == $item['categorie_depense_id'] ? 'selected' : ''); ?>value="<?php echo e($data['id']); ?>"
                                        class="categorie" <?php if($data->libelleDepenses->isNotEmpty()): ?> disabled <?php endif; ?>>
                                        <?php echo e(strtoupper($data['libelle'])); ?>

                                    </option>

                                    <!-- Boucle pour les libelleDepenses de cette catégorie -->
                                    <?php $__currentLoopData = $data->libelleDepenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data_libelle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($data_libelle['id'] == $item['libelle_depense_id'] ? 'selected' : ''); ?>

                                            value="<?php echo e($data_libelle['id']); ?>" class="libelle-depense">
                                            &nbsp;&nbsp;&nbsp;&nbsp;<?php echo e($data_libelle['libelle']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label for="validationCustom01" class="form-label">Montant</label>
                            <input type="number" name="montant" value="<?php echo e($item['montant']); ?>" class="form-control"
                                id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="meta-title-input">Date <span
                                    class="text-danger">*</span>
                            </label>
                            <input type="date" id="currentDate" value="<?php echo e($item->date_depense); ?>" name="date_depense"
                                class="form-control" required>
                        </div>
                       
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Description</label>
                            <textarea class="form-control" name="description" id="" cols="30" rows="10">
                                <?php echo e($item['description']); ?>

                             </textarea>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary ">Valider</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/depense/edit.blade.php ENDPATH**/ ?>