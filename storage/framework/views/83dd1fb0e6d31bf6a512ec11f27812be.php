

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('backend.components.breadcrumb'); ?>
        <link href="<?php echo e(URL::asset('build/libs/dropzone/dropzone.css')); ?>" rel="stylesheet">

        <?php $__env->slot('li_1'); ?>
            Produit
        <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?>
            Créer un nouveau produit
        <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data"
                        novalidate>
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    
                                    <div class="card-body">
                                        <div class="mb-3 row">

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label" for="product-title-input">Famille<span
                                                        class="text-danger">*</span>
                                                </label>
                                                <select id="categorie" class="form-control " name="famille" required>
                                                    <option value="" disabled selected>Selectionner</option>

                                                    <?php $__currentLoopData = $data_categorie; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categorie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <option value=" <?php echo e($categorie->id); ?> "><?php echo e($categorie->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <div class="mb-3 col-md-5">
                                                <label class="form-label" for="product-title-input">
                                                    Categorie <span class="text-danger">*</span>
                                                </label>
                                                <select id="categorie-filter"
                                                    class="form-control js-example-basic-single categorie-filter"
                                                    name="categorie_id" required>
                                                    <option value="" disabled selected>Selectionner</option>

                                                    
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label class="form-label" for="meta-title-input">Libellé <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="nom" class="form-control" id="nomProduit"
                                                    required>
                                            </div>

                                            


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">valeur de l'unité
                                                    <i class="ri ri-information-line fs-6  text-warning p-1 rounded fw-bold"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        title="Information"
                                                        data-bs-content="exemple 1.5 L , utiliser un . ou , exemple 1,5"></i>

                                                </label>

                                                <input type="number" name="valeur_unite"
                                                    class="form-control customNumberInput" id="quantiteUnite"
                                                    step="0.01">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">Unité du produit
                                                </label>
                                                <select id="uniteProduit" class="form-control js-example-basic-single"
                                                    name="unite_id">
                                                    <option value="" selected>Choisir</option>
                                                    <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($unite->id); ?>"><?php echo e($unite->libelle); ?>

                                                            (<?php echo e($unite->abreviation); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            

                                            <div class="col-md-3 mb-3 divUniteSortie ">
                                                <label class="form-label" for="meta-title-input">Unité en sortie ou vente
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control js-example-basic-single uniteSortie"
                                                    name="unite_sortie_id" required>
                                                    <option value="" selected>Choisir</option>
                                                    <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($unite->id); ?>"><?php echo e($unite->libelle); ?>

                                                            (<?php echo e($unite->abreviation); ?>)
                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>


                                            <div class="col-md-3 mb-3 d-none">
                                                <label class="form-label" for="meta-title-input">Prix de vente
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="prix" class="form-control "
                                                    id="prixVenteHide">
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">Stock alerte <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="stock_alerte" class="form-control"
                                                    id="stockAlerte" required>
                                            </div>
                                        </div>


                                        <!-- ========== Start Variante ========== -->
                                        <div class="container my-4 divVariante">

                                            <div class="col-12 d-flex justify-content-center">
                                                <p>-------------------------------</p> <span class="fw-bold">Gestion des
                                                    prix et
                                                    variantes</span>
                                                <p> -----------------------------</p>
                                            </div>

                                            <div id="variantes-container">
                                                <div class="row variante-row mb-4">
                                                    <div class="col-2">
                                                        <label for="prix">Quantité :</label>
                                                        <input type="number" class="form-control"
                                                            name="variantes[0][quantite]" value="1" readonly>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="variante">Unite de vente :</label>
                                                        <select name="variantes[0][libelle]" class="form-control"required>
                                                            <option value="" selected> Selectionner</option>
                                                            <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <option value="<?php echo e($variante->id); ?>">
                                                                    <?php echo e($variante->libelle); ?></option>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-4">
                                                        <label for="prix">Prix unitaire de vente :</label>
                                                        <input type="number" step="0.01"
                                                            class="form-control prixVente" name="variantes[0][prix]"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary mb-3" id="add-variante">Ajouter
                                                une Variante</button>

                                        </div>

                                        <!-- ========== End Variante ========== -->



                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div>
                                                    <label>Description</label>
                                                    <textarea name="description" id="ckeditor-classic"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-5">
                                                <div class="mb-4">
                                                    <h6 class="fs-14 mb-1">Image principale <span
                                                            class="text-danger">*</span>
                                                    </h6>
                                                    <div class="text-center">
                                                        <div class="position-relative d-inline-block">
                                                            <div
                                                                class="position-absolute top-100 start-100 translate-middle">
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
                                                                <input class="form-control d-none"
                                                                    id="product-image-input" type="file"
                                                                    name="imagePrincipale" accept="image/*" required>
                                                                <div class="invalid-feedback">Ajouter une image</div>
                                                            </div>
                                                            <div class="avatar-lg">
                                                                <div class="avatar-title bg-light rounded">
                                                                    <img src="" id="product-img"
                                                                        class="avatar-md h-auto" />
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
            //cacher la div variante par defaut
            $('.divVariante').hide();
            //gestion des variantes
            let varianteIndex = 1;

            document.getElementById('add-variante').addEventListener('click', function() {
                const container = document.getElementById('variantes-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'variante-row', 'mb-4');
                newRow.innerHTML = `
                  <div class="col-2">
                    <label for="prix">Quantité :</label>
                        <input type="number" name="variantes[${varianteIndex}][quantite]" class="form-control"  required >
                        </div>
        <div class="col-4">
            <label for="variante">Nom de la Variante :</label>
            <select class="form-control" name="variantes[${varianteIndex}][libelle]" required>
                <option value="" selected>Choisir</option>
                <?php $__currentLoopData = $data_unite; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variante): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($variante->id); ?>"><?php echo e($variante->libelle); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-4">
            <label for="prix">Prix unitaire par quantite :</label>
            <input type="number" step="0.01" class="form-control" name="variantes[${varianteIndex}][prix]" required>
        </div>
        <div class="col-2 mt-2">
            <button type="button" class="btn btn-danger remove-variante mt-3"> <i class="mdi mdi-delete remove-variante"></i></button>
        </div>
    `;
                container.appendChild(newRow);
                varianteIndex++;
            });

            document.getElementById('variantes-container').addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-variante')) {
                    e.target.closest('.variante-row').remove();
                }
            });



            // Par defaut cacher la div de unite de sortie et required a false
            $('.divUniteSortie').hide();
            $('.uniteSortie').prop('required', false);


            // Afficher les champs en fonction de la categorie selectionné
            let categoryFamille;
            var categorieData = <?php echo json_encode($categorieAll, 15, 512) ?> // from product controller
            var categorieFilter =
                <?php echo json_encode($data_categorie, 15, 512) ?> // from product controller--- categorie parent et leur sous categorie



            // Remplissage des sous categorie en fonction de la famille selectionnee

            // const categorieSelect = document.getElementById('categorie'); // Famille
            // const categorieFilterSelect = document.getElementById('categorie-filter'); // Catégorie


            // // Fonction pour filtrer les catégories de manière récursive
            // function filterCategories(parentId) {
            //     const filteredCategories = [];

            //     console.log(filteredCategories);


            //     function recurse(categories, level = 0) {
            //         categories.forEach(category => {
            //             if (category.parent_id === parentId) {
            //                 filteredCategories.push({
            //                     id: category.id,
            //                     name: `${'-'.repeat(level)} ${category.name}`,
            //                     children: category.children || [],
            //                 });
            //                 recurse(category.children || [], level + 1);
            //             }
            //         });
            //     }
            //     recurse(categorieData);
            //     return filteredCategories;
            // }

            // // Mettre à jour le select "Catégorie" avec les sous-catégories
            // function updateCategorieFilter(categories) {
            //     categorieFilterSelect.innerHTML = '<option value="" disabled selected>Selectionner</option>';
            //     categories.forEach(category => {
            //         const option = document.createElement('option');
            //         option.value = category.id;
            //         option.textContent = category.name;
            //         categorieFilterSelect.appendChild(option);
            //     });
            // }

            // // Événement : Quand la "Famille" change
            // categorieSelect.addEventListener('change', function() {
            //     const selectedFamilyId = parseInt(this.value, 10);
            //     if (selectedFamilyId) {
            //         const subCategories = filterCategories(selectedFamilyId);
            //         updateCategorieFilter(subCategories);
            //     } else {
            //         categorieFilterSelect.innerHTML = '<option value="" disabled selected>Selectionner</option>';
            //     }
            // });



            //###############################################///
            // // var categorieData = <?php echo json_encode($categorieAll, 15, 512) ?>; // Toutes les catégories (avec enfants)
            // var categorieFilterSelect = document.getElementById('categorie-filter'); // Le select des catégories

            // // Fonction pour filtrer et récupérer les sous-catégories de manière récursive
            // function filterCategories(parentId) {
            //     const filteredCategories = [];

            //     function recurse(categories, level = 0) {
            //         categories.forEach(category => {
            //             if (category.parent_id === parentId) {
            //                 // Ajouter la catégorie avec son niveau
            //                 filteredCategories.push({
            //                     id: category.id,
            //                     name: `${'-'.repeat(level)} ${category.name}`,
            //                     children: category.children || [],
            //                 });

            //                 // Récursivement récupérer les sous-catégories
            //                 recurse(category.children || [], level + 1);
            //             }
            //         });
            //     }

            //     // Lancer la récursion à partir de la liste de toutes les catégories
            //     recurse(categorieData);

            //     return filteredCategories;
            // }

            // // Fonction pour mettre à jour le select des sous-catégories
            // function updateCategorieFilter(categories) {
            //     categorieFilterSelect.innerHTML =
            //     '<option value="" disabled selected>Selectionner</option>'; // Réinitialiser le select

            //     categories.forEach(category => {
            //         const option = document.createElement('option');
            //         option.value = category.id;
            //         option.textContent = category.name;
            //         categorieFilterSelect.appendChild(option);

            //         // Ajouter récursivement les enfants
            //         if (category.children && category.children.length > 0) {
            //             category.children.forEach(child => {
            //                 const childOption = document.createElement('option');
            //                 childOption.value = child.id;
            //                 childOption.textContent =
            //                 `${'-'.repeat(1)} ${child.name}`; // Niveau 1 pour les sous-catégories directes
            //                 categorieFilterSelect.appendChild(childOption);
            //             });
            //         }
            //     });
            // }

            // // Événement : Quand la "Famille" change
            // document.getElementById('categorie').addEventListener('change', function() {
            //     const selectedFamilyId = parseInt(this.value, 10);
            //     if (selectedFamilyId) {
            //         // Filtrer les sous-catégories en fonction de la famille sélectionnée
            //         const subCategories = filterCategories(selectedFamilyId);
            //         updateCategorieFilter(subCategories);
            //     } else {
            //         // Réinitialiser si aucune famille n'est sélectionnée
            //         categorieFilterSelect.innerHTML = '<option value="" disabled selected>Selectionner</option>';
            //     }
            // });




            // // Données des catégories
            // var categorieData = <?php echo json_encode($categorieAll, 15, 512) ?>; // Toutes les catégories avec leurs enfants
            // var categorieSelect = document.getElementById('categorie'); // Select Famille
            // var categorieFilterSelect = document.getElementById('categorie-filter'); // Select Catégorie

            // // Fonction pour récupérer les sous-catégories de manière récursive (seulement le premier enfant)
            // function getFirstChildCategories(categories, parentId) {
            //     const result = [];
            //     let currentParentId = parentId;

            //     while (currentParentId !== null) {
            //         // Trouver le premier enfant correspondant au parent actuel
            //         const child = categories.find(category => category.parent_id === currentParentId);

            //         if (child) {
            //             // Ajouter cet enfant au résultat
            //             result.push({
            //                 id: child.id,
            //                 name: child.name,
            //             });

            //             // Passer au prochain niveau (le premier enfant de cet enfant)
            //             currentParentId = child.id;
            //         } else {
            //             // Pas d'autres enfants à explorer
            //             currentParentId = null;
            //         }
            //     }

            //     return result;
            // }

            // // Fonction pour mettre à jour le select "Catégorie"
            // function updateCategorieFilter(categories) {
            //     categorieFilterSelect.innerHTML =
            //         '<option value="" disabled selected>Selectionner</option>'; // Réinitialiser le select

            //     categories.forEach(category => {
            //         const option = document.createElement('option');
            //         option.value = category.id;
            //         option.textContent = category.name;
            //         categorieFilterSelect.appendChild(option);
            //     });
            // }

            // // Événement : Quand la "Famille" change
            // categorieSelect.addEventListener('change', function() {
            //     const selectedFamilyId = parseInt(this.value, 10);

            //     if (selectedFamilyId) {
            //         // Récupérer les catégories récursives du premier enfant de chaque niveau
            //         const filteredCategories = getFirstChildCategories(categorieData, selectedFamilyId);

            //         // Mettre à jour le select "Catégorie"
            //         updateCategorieFilter(filteredCategories);
            //     } else {
            //         // Réinitialiser si aucune famille n'est sélectionnée
            //         categorieFilterSelect.innerHTML = '<option value="" disabled selected>Selectionner</option>';
            //     }
            // });






            // Données des catégories
            var categorieData = <?php echo json_encode($categorieAll, 15, 512) ?>; // Toutes les catégories avec leurs enfants
            var categorieSelect = document.getElementById('categorie'); // Select Famille
            var categorieFilterSelect = document.getElementById('categorie-filter'); // Select Catégorie

            // Fonction pour récupérer toutes les sous-catégories récursivement
            function getRecursiveCategories(categories, parentId, level = 0) {
                const result = [];

                categories.forEach(category => {
                    if (category.parent_id === parentId) {
                        // Ajouter la catégorie actuelle avec une indentation selon le niveau
                        result.push({
                            id: category.id,
                            name: `${'--'.repeat(level)} ${category.name}`,
                        });

                        // Appeler la fonction récursivement pour ses enfants
                        const children = getRecursiveCategories(categories, category.id, level + 1);
                        result.push(...children);
                    }
                });

                return result;
            }

            // Fonction pour mettre à jour le select "Catégorie"
            function updateCategorieFilter(categories) {
                categorieFilterSelect.innerHTML =
                    '<option value="" disabled selected>Selectionner</option>'; // Réinitialiser le select

                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    categorieFilterSelect.appendChild(option);
                });
            }

            // Événement : Quand la "Famille" change
            categorieSelect.addEventListener('change', function() {
                const selectedFamilyId = parseInt(this.value, 10);

                if (selectedFamilyId) {
                    // Récupérer toutes les sous-catégories récursivement
                    const filteredCategories = getRecursiveCategories(categorieData, selectedFamilyId);

                    // Mettre à jour le select "Catégorie"
                    updateCategorieFilter(filteredCategories);
                } else {
                    // Réinitialiser si aucune famille n'est sélectionnée
                    categorieFilterSelect.innerHTML = '<option value="" disabled selected>Selectionner</option>';
                }
            });




            //recuperer la categorie selectionné
            $('#categorie').change(function(e) {
                e.preventDefault();

                var categorieSelect = $(this).val()



                //filtrer pour recuperer la categorie selectionnée
                var categorieFilter = categorieData.filter(function(item) {
                    return item.id == categorieSelect
                })


                console.log(categorieFilter);


                // si categorieFilter = restaurant , required false
                if (categorieFilter[0].famille == 'restaurant') {
                    $('.prixVente').prop('required', false)
                    $('.divVariante').hide();
                    var price = parseFloat($('.prixVente').val(''));
                    console.log(price);


                    $('.divUniteSortie').show();
                    $('.uniteSortie').prop('required', true);

                    // $('#quantiteUnite').prop('required', false)
                    // $('#quantiteUnite').prop('disabled', true)
                    // $('#quantiteUnite').val('')

                    // $('#uniteMesure').prop('required', false)
                    // $('#uniteMesure').prop('disabled', true)
                    // $('#uniteMesure').val('')
                } else {

                    $('.prixVente').prop('required', true)
                    $('.divVariante').show();

                    $('.divUniteSortie').hide();
                    $('.uniteSortie').prop('required', false);


                    // $('#quantiteUnite').prop('required', true)
                    // $('#quantiteUnite').prop('disabled', false)

                    // $('#uniteMesure').prop('required', true)
                    // $('#uniteMesure').prop('disabled', false)

                }

                // recuperer la famille de la categorie
                categoryFamille = categorieFilter[0];


            });



            //script for to send data 


            // product image
            document.querySelector("#product-image-input").addEventListener("change", function(event) {
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



                // si la famille est bar  on recupere le prix de la premiere variante
                var prixVente = parseFloat($('.prixVente').val());
                var prixVenteHide = $('#prixVenteHide').val(prixVente);






                // Vérifier si un champ avec required est vide
                // var requiredFields = document.querySelectorAll('[required]');
                // for (var i = 0; i < requiredFields.length; i++) {
                //     var field = requiredFields[i];

                //     if (field.value === '') {
                //         var label = document.querySelector('label[for="' + field.id + '"]');
                //         var fieldName = label ? label.textContent.trim() : field.getAttribute('name');

                //         alert('Le champ "' + fieldName + '" est requis.');
                //         return;
                //     }
                // }
                // on verifie si une image principale à éte inseré
                if ($('#product-image-input').val() === '' && categoryFamille === 'bar') {

                    e.preventDefault();
                } else {
                    var formData = new FormData(this);

                    $('#imageTableBody div').each(function() {
                        var imageFile = $(this).find('img').attr('src');
                        formData.append('images[]', imageFile)
                    });

                    $.ajax({
                        url: "<?php echo e(route('produit.store')); ?>", // Ajustez la route si nécessaire
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success === true) {
                                // $('#imageTableBody').empty();

                                Swal.fire({
                                    title: 'Produit ajouté avec succès !',
                                    icon: 'success',
                                    showCancelButton: false,
                                    customClass: {
                                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                        cancelButton: 'btn btn-danger w-xs mt-2',
                                    },
                                    buttonsStyling: false,
                                    showCloseButton: true
                                });

                                var url = "<?php echo e(route('produit.index')); ?>"; // Rediriger vers la route stock
                                window.location.replace(url);
                            }
                        },
                        error: function(xhr) {
                            // Gérer les erreurs
                            if (xhr.status === 409) {
                                // Produit déjà existant
                                Swal.fire({
                                    title: 'Ce produit a déjà été enregistré',
                                    text: $('#nomProduit').val(),
                                    icon: 'warning',
                                    customClass: {
                                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                        cancelButton: 'btn btn-danger w-xs mt-2',
                                    },
                                    buttonsStyling: false,
                                    showCloseButton: true
                                });
                            } else {
                                // Autres types d'erreurs
                                Swal.fire({
                                    title: 'Erreur',
                                    text: 'Une erreur est survenue, veuillez réessayer.',
                                    icon: 'error',
                                    customClass: {
                                        confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                        cancelButton: 'btn btn-danger w-xs mt-2',
                                    },
                                    buttonsStyling: false,
                                    showCloseButton: true
                                });
                            }
                        }
                    });


                }





            });
        </script>
    <?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\restaurant\resources\views/backend/pages/produit/create.blade.php ENDPATH**/ ?>