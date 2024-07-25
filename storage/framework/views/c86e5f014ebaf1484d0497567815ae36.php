<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModalPosition<?php echo e($item['id']); ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Changer la position</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post" action="<?php echo e(route('media-category.position' , $item['id'])); ?>"
                                novalidate>
                                <?php echo csrf_field(); ?>
                              
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Position actuelle <span class="text-primary"><?php echo e($item['position']); ?> </span> </label>
                                    <select name="position" class="form-control">
                                     <?php for($i = 1; $i <= count($data_media_category); $i++): ?>
                                         <option value="<?php echo e($i); ?>" <?php echo e($item['position'] == $i ? 'selected' : ''); ?>>
                                            <?php echo e($i); ?>

                                        </option>
                                     <?php endfor; ?>

                                    </select>
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
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!-- end col -->
    </div><!-- end row -->
</div><!-- end col -->
</div>
<!--end row-->


<?php /**PATH C:\laragon\www\admin\ticafriqueAdmin\resources\views/backend/pages/media/category/position.blade.php ENDPATH**/ ?>