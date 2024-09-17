 <!-- Default Modals -->
 <div id="myModalEdit<?php echo e($item['id']); ?>" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel">Modification </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 </button>
             </div>
             <div class="modal-body">

                 <form class="row g-3 needs-validation" method="post" action="<?php echo e(route('magasin.update', $item['id'])); ?>"
                     novalidate>
                     <?php echo csrf_field(); ?>
                     <div class="col-md-12">
                         <label for="validationCustom01" class="form-label">Libellé</label>
                         <input type="text" name="nom" value="<?php echo e($item['nom']); ?>" class="form-control"
                             id="validationCustom01" required>
                         <div class="valid-feedback">
                             Looks good!
                         </div>
                     </div>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                 <button type="submit" class="btn btn-primary ">Modifier</button>
             </div>
             </form>
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

 
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/configuration/magasin/edit.blade.php ENDPATH**/ ?>