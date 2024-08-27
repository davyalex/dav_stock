<ul>
    <?php $__currentLoopData = $categories_child; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <a href="<?php echo e($categorie->url); ?>"><?php echo e($categorie->name); ?></a>
          <span class=" float-end">
            <a href="<?php echo e(route('categorie.edit', $categorie['id'])); ?>" class="fs-5" style="margin-left:30px"> <i
                class=" ri ri-edit-2-fill ml-4"></i></a>

        <a href="<?php echo e(route('categorie.add-subCat', $categorie['id'])); ?>" class="fs-5"> <i
                class=" ri ri-add-circle-fill ml-4"></i>
        </a>
        <?php if(count($categorie->children) == 0): ?>
            <a href="#" class="fs-5 delete" data-id="<?php echo e($categorie['id']); ?>"> <i
                    class="ri ri-delete-bin-2-line text-danger"></i>
            </a>
        <?php endif; ?>
          </span>
            <?php if($categorie->children->count() > 0): ?>
                <?php echo $__env->make('backend.pages.categorie.partials.subcategorie', [
                    'categories_child' => $categorie->children,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>




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
<?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/categorie/partials/subcategorie.blade.php ENDPATH**/ ?>