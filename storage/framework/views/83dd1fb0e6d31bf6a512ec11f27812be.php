

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Nouveau produit
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Créer un nouveau produit
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class="col-md-2">
                                                <label class="form-label" for="product-title-input">Type
                                                </label>
                                                <select id="choices-single-default" class="form-control typeSelected"
                                                    name="type_produit" data-choices data-choices-sorting-false required>
                                                    <option value="" disabled selected></option>
                                                    <?php $__currentLoopData = $type_produit; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($type->id); ?>">
                                                            <?php echo e($type->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-8">
                                                <label class="form-label" for="product-title-input">Sélectionner un produit
                                                </label>
                                                <a href="<?php echo e(route('produit.createNewProduct')); ?>"
                                                    class="float-end text-decoration-underline">
                                                    <i class="ri ri-add-fill"></i>
                                                    Ajouter un nouveau produit
                                                </a>
                                                <select class="form-control productSelected  js-example-basic-single "
                                                    name="categorie"  required>
                                                    
                                                    
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label" for="stocks-input">Stocks actuelle</label>
                                                <input type="text" class="form-control" id="stock" disabled>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="product-title-input">Fournisseur
                                                </label>
                                                <select id="choices-single-default" class="form-control" name="categorie"
                                                    data-choices data-choices-sorting-false>
                                                    <option value="" disabled selected>Selectionner</option>
                                                    <?php $__currentLoopData = $data_fournisseur; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fournisseur): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($fournisseur->id); ?>"><?php echo e($fournisseur->nom); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="product-title-input">Format
                                                </label>
                                                <select id="choices-single-default" class="form-control" name="categorie"
                                                    data-choices data-choices-sorting-false>
                                                    <option value="" disabled selected>Selectionner</option>
                                                    <?php $__currentLoopData = $data_format; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $format): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($format->id); ?>"><?php echo e($format->libelle); ?>

                                                            (<?php echo e($format->abreviation); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label" for="stocks-input">Quantité</label>
                                                <input type="text" class="form-control" id="stocks-input" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Gallerie Images</h5>
                                    </div>

                                    <div class="card-body">
                                        <div class="mb-4">
                                            <h5 class="fs-14 mb-1">Image principale <span class="text-danger">*</span></h5>
                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="position-absolute top-100 start-100 translate-middle">
                                                        <label for="product-image-input" class="mb-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="right"
                                                            title="Select Image">
                                                            <div class="avatar-xs">
                                                                <div
                                                                    class="avatar-title bg-light border rounded-circle text-muted cursor-pointer">
                                                                    <i class="ri-image-fill"></i>
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <input class="form-control d-none" id="product-image-input"
                                                            type="file" name="imagePrincipale" accept="image/*" required>
                                                        <div class="invalid-feedback">Ajouter une image</div>
                                                    </div>
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded">
                                                            <img src="" id="product-img" class="avatar-md h-auto" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 mt-3">
                                            <label for="imageInput" class="form-label col-12">
                                                <div class="col-md-12 border border-dark rounded border-dashed text-center px-5 mt-4"
                                                    style=" cursor: pointer;">
                                                    <i class="ri ri-image-add-fill fs-1 "></i>
                                                    <h5>Ajouter des images</h5>
                                                </div>
                                            </label>
                                            <input type="file" id="imageInput" accept="image/*"
                                                class="form-control d-none" multiple>

                                            <div class="row" id="imageTableBody"></div>

                                            <div class="valid-feedback">
                                                Success!
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card -->


                            </div>
                        </div>
                        <!-- end row -->
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->


        <!--end row-->

    <?php $__env->startSection('script'); ?>
        <script src="<?php echo e(URL::asset('build/libs/prismjs/prism.js')); ?>"></script>
        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/modal.init.js')); ?>"></script>
        
        <script src="<?php echo e(URL::asset('build/tinymce/tinymce.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')); ?>"></script>

        <script src="<?php echo e(URL::asset('build/libs/dropzone/dropzone-min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/pages/ecommerce-product-create.init.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('build/js/app.js')); ?>"></script>

        <script>
            //get info product from controller
            var dataProduct = <?php echo e(Js::from($data_produit)); ?>



            //get list product of type product
            $('.typeSelected').change(function(e) {
                e.preventDefault();
                var typeSelected = $('.typeSelected option:selected').val();
                var productList = dataProduct.filter(function(item) {
                    return item.type_id == typeSelected;
                });
                console.log(productList);
                

                $('.productSelected').empty();
                $('.productSelected').append('<option value="">Selectionner un produit</option>');
                $.each(productList, function(key, value) {
                    $('.productSelected').append('<option value="' + value.id + '">' + value.nom +
                        '</option>');
                });


            });

            //get product select
            $('.productSelected').change(function(e) {
                e.preventDefault();
                var productSelected = $('.productSelected option:selected').val();

                var filteredProduct = dataProduct.filter(function(item) {
                    return item.id == productSelected;
                });

                //update stock of product selected
                $('#stock').val(filteredProduct[0].stock)

            });



            // product image principal
            document.querySelector("#product-image-input").addEventListener("change", function() {
                var preview = document.querySelector("#product-img");
                var file = document.querySelector("#product-image-input").files[0];
                var reader = new FileReader();
                reader.addEventListener("load", function() {
                    preview.src = reader.result;
                }, false);
                if (file) {
                    reader.readAsDataURL(file);
                }
            });


            $('#imageInput').on('change', function(e) {
                var files = e.target.files;
                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = function(e) {

                        var image = ` <div class="col-12 d-flex justify-content-between border border-secondary rounded"><img src="${e.target.result}" class="img-thumbnail rounded float-start" width="50" height="100">
                                   <button type="button" class="btn btn-danger my-2 remove-image">Delete</button>
                                    </div>  `;

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
                    formData.append('images[]', imageFile)
                });

                $.ajax({
                    url: "<?php echo e(route('produit.StoreNewProduct')); ?>", // Adjust the route as needed
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#imageTableBody').empty();

                        if (response.message == 'operation reussi') {
                            Swal.fire({
                                title: 'Produit ajouté avec success!',
                                // text: 'You clicked the button!',
                                icon: 'success',
                                showCancelButton: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                    cancelButton: 'btn btn-danger w-xs mt-2',
                                },
                                buttonsStyling: false,
                                showCloseButton: true
                            })
                            var url = "<?php echo e(route('produit.create')); ?>" // redirect route 

                            window.location.replace(url);
                        }
                    },

                });
            });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/produit/create.blade.php ENDPATH**/ ?>