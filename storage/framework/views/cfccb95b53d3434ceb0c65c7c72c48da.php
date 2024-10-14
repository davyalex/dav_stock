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

                 <form class="row g-3 needs-validation" method="post" action="<?php echo e(route('slide.update', $item['id'])); ?>"
                     novalidate enctype="multipart/form-data">
                     <?php echo csrf_field(); ?>
                     <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                         role="alert">
                         <i class="ri-airplay-line label-icon"></i><strong>Dimensions (px) : </strong>
                         <ol>
                             <li>Carrousel : <strong>1920 * 685</strong></li>
                             <li>grande-banniere : <strong>1170 * 489</strong></li>
                             <li>petite-banniere : <strong>535 * 290</strong></li>
                             <li>banniere-best-seller : <strong>324 * 463</strong></li>


                         </ol>
                         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                     <?php
                         $type = ['carrousel', 'grande-banniere', 'petite-banniere', 'banniere-best-seller'];
                     ?>
                  
                  <div class="row">
                    <div class="col-md-3">
                        <label for="validationCustom01" class="form-label">Type</label>
                        <select name="type" class="form-control" required>
                            <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"
                                    <?php echo e($item->type == $value ? 'selected' : ''); ?>><?php echo e($value); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>
                    <div class="col-md-9">
                        <label for="validationCustom01" class="form-label">Titre du slide</label>
                        <input type="text" name="title" value="<?php echo e($item['title']); ?>" class="form-control"
                            id="validationCustom01">
                        <div class="valid-feedback">
                            Looks good!
                        </div>
                    </div>

                  </div>


                     <div class="col-md-12">
                         <label for="validationCustom01" class="form-label">Sous titre du slide</label>
                         <input type="text" name="subtitle" value="<?php echo e($item['subtitle']); ?>" class="form-control"
                             id="validationCustom01">
                         <div class="valid-feedback">
                             Looks good!
                         </div>
                     </div>

                     <!-- ========== Start button  ========== -->
                     <div class="row">
                         <div class="col-md-4">
                             <label for="validationCustom01" class="form-label">Nom du button</label>
                             <input type="text" name="btn_name" value="<?php echo e($item['btn_name']); ?>" class="form-control"
                                 id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-3">
                             <label for="validationCustom01" class="form-label">URl du bouton</label>
                             <input type="text" name="btn_url" value="<?php echo e($item['btn_url']); ?>" class="form-control"
                                 id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-3">
                             <label for="validationCustom01" class="form-label">couleur du bouton</label>
                             <input type="color" name="btn_color" value="<?php echo e($item['btn_color']); ?>"
                                 class="form-control" id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-2">
                             <label for="validationCustom01" class="form-label">Statut</label>
                             <select name="btn_status" class="form-control">
                                 <option value="active" <?php echo e($item['btn_status'] == 'active' ? 'selected' : ''); ?>>
                                     Activé
                                 </option>
                                 <option value="desactive" <?php echo e($item['btn_status'] == 'desactive' ? 'selected' : ''); ?>>
                                     Desactivé
                                 </option>
                             </select>
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                     </div>

                     <!-- ========== End button  ========== -->

                     <div class="row">
                         <div class="col-md-2">
                             <img class="rounded-circle" src="<?php echo e($item->getFirstMediaUrl('slideImage')); ?>"
                                 width="50px" alt="">
                         </div>
                         <div class="col-md-10">
                             <label for="validationCustom01" class="form-label">Image du slide</label>
                             <input type="file" name="image" class="form-control" id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>
                     </div>

                     <div class="col-md-12">
                         <label for="validationCustom01" class="form-label">Statut</label>
                         <select name="status" class="form-control">
                             <option value="active" <?php echo e($item['status'] == 'active' ? 'selected' : ''); ?>>
                                 Activé
                             </option>
                             <option value="desactive" <?php echo e($item['status'] == 'desactive' ? 'selected' : ''); ?>>
                                 Desactivé
                             </option>
                         </select>
                         <div class="valid-feedback">
                             Looks good!
                         </div>
                     </div>

                     <div class="modal-footer">
                         <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                         <button type="submit" class="btn btn-primary ">Valider</button>
                     </div>

                 </form>
             </div>
         </div><!-- /.modal-dialog -->
     </div><!-- /.modal -->
 </div><!-- end col -->

 
<?php /**PATH C:\laragon\www\restaurant\Restaurant-chez-jeanne\resources\views/backend/pages/slide/edit.blade.php ENDPATH**/ ?>