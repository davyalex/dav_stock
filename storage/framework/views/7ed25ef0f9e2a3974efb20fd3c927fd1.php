  <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
              <div class="d-flex justify-content-between">
                  <h5>Liste des categories</h5>
                  <a href="<?php echo e(route('categorie.create')); ?>" class="btn btn-primary">
                      <i class="ri ri-add-fill"></i>
                      Ajouter</a>
              </div>
              <!-- Accordions with Plus Icon -->
              <?php $__currentLoopData = $data_categorie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
                  <div>
                      <hr>
                      <li class="" style="list-style: none">
                        <i class="ri-drag-move-fill align-bottom handle"></i> <a class="fs-5 fw-medium" href="<?php echo e($categorie->url); ?>"><?php echo e($categorie->name); ?></a>
                          <a href="<?php echo e(route('categorie.edit', $categorie['id'])); ?>" class="fs-5"
                              style="margin-left:30px"> <i class=" ri ri-edit-2-fill ml-4 text-success"></i></a>

                          <a href="<?php echo e(route('categorie.add-subCat', $categorie['id'])); ?>" class="fs-5"> <i
                                  class=" ri ri-add-circle-fill ml-4"></i>
                          </a>
                          <?php if($categorie['children_count'] == 0): ?>
                              <a href="#" data-id="<?php echo e($categorie['id']); ?>" class="fs-5 delete"> <i
                                      class="ri ri-delete-bin-2-line text-danger "></i>
                              </a>
                          <?php endif; ?>

                          <?php if($categorie->children->count() > 0): ?>
                              <?php echo $__env->make('backend.pages.categorie.partials.subcategorie', [
                                  'categories_child' => $categorie->children,
                              ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          <?php endif; ?>
                      </li>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

      </div>
  </div><!-- end row -->



  <?php $__env->startSection('script'); ?>
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

      <script>
          $(document).ready(function() {
              $('.delete').on("click", function(e) {
                  e.preventDefault();
                  var Id = $(this).attr('data-id');
                  Swal.fire({
                      title: 'Etes-vous sûr(e) de vouloir supprimer ?',
                      text: "Cette action est irréversible!",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonText: 'Supprimer!',
                      cancelButtonText: 'Annuler',
                      customClass: {
                          confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                          cancelButton: 'btn btn-danger w-xs mt-2',
                      },
                      buttonsStyling: false,
                      showCloseButton: true
                  }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                              type: "GET",
                              url: "/categorie/delete/" + Id,
                              dataType: "json",

                              success: function(response) {
                                  if (response.status == 200) {
                                      Swal.fire({
                                          title: 'Deleted!',
                                          text: 'Your file has been deleted.',
                                          icon: 'success',
                                          customClass: {
                                              confirmButton: 'btn btn-primary w-xs mt-2',
                                          },
                                          buttonsStyling: false
                                      })

                                      //   $('#row_' + Id).remove();
                                      location.reload();
                                  }
                              }
                          });
                      }
                  });
              });
          });
      </script>
  <?php $__env->stopSection(); ?>
<?php /**PATH C:\laragon\www\Restaurant-NEUILLY-\resources\views/backend/pages/categorie/categorie-list.blade.php ENDPATH**/ ?>