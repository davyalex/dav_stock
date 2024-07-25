

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <?php $__env->slot('li_1'); ?>
            MEDIA
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Modifier un media
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Titre du media</label>
                            <input type="text" name="title" value="<?php echo e($data_media_content['title']); ?>"
                                class="form-control" id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">Categories</label>
                            <select name="categorie" class="form-control" required>
                                <option disabled selected value>Sélectionner...</option>
                                <?php $__currentLoopData = $data_media_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category['id']); ?>"
                                        <?php echo e($data_media_content['media_categories_id'] == $category['id'] ? 'selected' : ''); ?>>
                                        <?php echo e($category['name']); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                          <div class="col-md-3">
                            <label for="validationCustom01" class="form-label">Statut </label>
                            <select name="status" class="form-control">
                                <option value="active" <?php echo e($data_media_content['status'] == 'active' ? 'selected' : ''); ?>>
                                    Activé
                                </option>
                                <option value="desactive"
                                    <?php echo e($data_media_content['status'] == 'desactive' ? 'selected' : ''); ?>>
                                    Desactivé
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Image du media</label>
                            <input type="file" id="imageInput" accept="image/*" multiple class="form-control">

                            <div class="row" id="imageTableBody"></div>

                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Url de redirection</label>
                            <input type="text" name="url" value="<?php echo e($data_media_content['url']); ?>"
                                class="form-control" id="validationCustom01">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                      
                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 ">Valider</button>
                </div>
                </form>
            </div>
        </div><!-- end row -->
    </div><!-- end col -->
    </div>
    <!--end row-->

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="<?php echo e(URL::asset('build/js/pages/modal.init.js')); ?>"></script>
    
    <script src="<?php echo e(URL::asset('build/tinymce/tinymce.min.js')); ?>"></script>

    <script>
        //get gallery Image from controller for edit
        var getGalleryMedia = <?php echo e(Js::from($galleryMedia)); ?>


        for (let i = 0; i < getGalleryMedia.length; i++) {
            const element = getGalleryMedia[i];
            var image = ` <div class="col-4"><img src="data:image/jpeg;base64,${element}" width="100" height="100">
                                    <br><button type="button" class="btn btn-danger my-2 remove-image">Delete</button>
                                    </div>`;

            console.log('edit:', image);
            $('#imageTableBody').append(image);
        }



        //script for to send data images gallery
        $('#imageInput').on('change', function(e) {
            var files = e.target.files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {


                    var image = ` <div class="col-4"><img src="${e.target.result}" width="100" height="100">
                                    <br><button type="button" class="btn btn-danger my-2 remove-image">Delete</button>
                                    </div>`;

                    console.log(image);

                    $('#imageTableBody').append(image);
                }
                reader.readAsDataURL(files[i]);
            }
        });

        $(document).on('click', '.remove-image', function() {
            $(this).closest('div').remove();
        });

        $('#formSend').on('submit', function(e) {

            e.preventDefault();
            var formData = new FormData(this);

            $('#imageTableBody div').each(function() {
                var imageFile = $(this).find('img').attr('src');
                formData.append('images[]', imageFile);

            });


            var getMediaId = <?php echo e(Js::from($id)); ?>


            $.ajax({
                url: "/media-content/update/" + getMediaId, // Adjust the route as needed
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#imageTableBody').empty();

                    if (response.message == 'operation reussi') {
                        Swal.fire({
                            title: 'Good job!',
                            text: 'You clicked the button!',
                            icon: 'success',
                            showCancelButton: true,
                            customClass: {
                                confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                cancelButton: 'btn btn-danger w-xs mt-2',
                            },
                            buttonsStyling: false,
                            showCloseButton: true
                        })

                        location.reload()
                    }
                },

            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\admin\ticafriqueAdmin\resources\views/backend/pages/media/content/edit.blade.php ENDPATH**/ ?>