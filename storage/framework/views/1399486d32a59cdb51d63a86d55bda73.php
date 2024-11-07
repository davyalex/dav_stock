<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer un nouveau slide </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post" action="<?php echo e(route('slide.store')); ?>"
                                novalidate enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>

                                <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                                    role="alert">
                                    <i class="ri-airplay-line label-icon"></i><strong>Dimensions (px) : </strong>
                                    <ol>
                                        <li>Carrousel : <strong>1920 * 685</strong></li>
                                        <li>grande-banniere : <strong>1170 * 489</strong></li>
                                        <li>petite-banniere : <strong>535 * 290</strong></li>
                                        <li>banniere-meilleur-vente : <strong>324 * 463</strong></li>


                                    </ol>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>

                                <?php
                                    $type = ['carrousel', 'grande-banniere', 'petite-banniere' , 'banniere-best-seller'];
                                ?>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Type</label>
                                    <select name="type" class="form-control" required>
                                        <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="validationCustom01" class="form-label">Titre du slide</label>
                                    <input type="text" name="title" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>


                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Sous titre du slide</label>
                                    <input type="text" name="subtitle" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <!-- ========== Start button  ========== -->
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Nom du button</label>
                                    <input type="text" name="btn_name" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">URl du bouton</label>
                                    <input type="text" name="btn_url" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="validationCustom01" class="form-label">Couleur du bouton</label>
                                    <input type="color" name="btn_color" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Statut du bouton</label>
                                    <select name="btn_status" class="form-control">
                                        <option value="active">Activé</option>
                                        <option value="desactive">Desactivé</option>

                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <!-- ========== End button  ========== -->


                                <div class="col-md-8">
                                    <label for="validationCustom01" class="form-label">Image du slide</label>
                                    <input type="file" name="image" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Statut du slide</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Activé</option>
                                        <option value="desactive">Desactivé</option>

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


<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/slide/create.blade.php ENDPATH**/ ?>