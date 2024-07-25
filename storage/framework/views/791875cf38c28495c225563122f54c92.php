  <div class="col-lg-6">
      <div class="card">
          <div class="card-body">
              <h5>Liste de menu</h5>
              <!-- Accordions with Plus Icon -->
              <?php $__currentLoopData = $data_menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  <div>
                      <hr>
                      <li>
                          <a class="fs-5 fw-medium" href="<?php echo e($menu->url); ?>"><?php echo e($menu->name); ?></a>
                          <a href="<?php echo e(route('menu.edit', $menu['id'])); ?>" class="fs-5" style="margin-left:30px"> <i
                                  class=" ri ri-edit-2-fill ml-4"></i></a>

                          <a href="<?php echo e(route('menu.add-item', $menu['id'])); ?>" class="fs-5"> <i
                                  class=" ri ri-add-circle-fill ml-4"></i>
                          </a>
                          <?php if($menu['children_count'] ==0): ?>
                          <a href="<?php echo e(route('menu.delete', $menu['id'])); ?>" class="fs-5"> <i
                                  class=" ri ri-delete-bin-2-line text-danger"></i>
                          </a>
                          <?php endif; ?>

                          <?php if($menu->children->count() > 0): ?>
                              <?php echo $__env->make('backend.pages.menu.partials.submenu', [
                                  'menus_child' => $menu->children,
                              ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                          <?php endif; ?>
                      </li>
                  </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>

      </div>
  </div><!-- end row -->
<?php /**PATH C:\laragon\www\admin\ticafriqueAdmin\resources\views/backend/pages/menu/menu-list.blade.php ENDPATH**/ ?>