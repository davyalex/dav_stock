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
                    action="<?php echo e(route('libelle-depense.update', $item['id'])); ?>" novalidate>
                    <?php echo csrf_field(); ?>

                    <div class="row">
                       

                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01" class="form-label">Categorie</label>
                            <select name="categorie_depense_id" class="form-control" required>
                                <option disabled selected value="">Selectionner</option>
                                <?php $__currentLoopData = $categorie_depense; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($data['id']); ?>"
                                        <?php echo e($data['id'] == $item['categorie_depense_id'] ? 'selected' : ''); ?>>
                                        <?php echo e($data['libelle']); ?> </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                        <div class="col-md-12 mb-3">
                            <label for="validationCustom01" class="form-label">Libelle</label>
                            <input type="text" name="libelle" value="<?php echo e($item['libelle']); ?>" class="form-control"
                                id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
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
<?php /**PATH C:\laragon\www\restaurant\Restaurant-chez-jeanne\resources\views/backend/pages/depense/libelle-depense/edit.blade.php ENDPATH**/ ?>