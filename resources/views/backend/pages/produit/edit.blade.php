@extends('backend.layouts.master')
@section('title')
   Produit
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Produit
        @endslot
        @slot('title')
            Modifier un nouveau produit
        @endslot
    @endcomponent

    <style>
        .non-selectable {
            pointer-events: none;
            /* Empêche l’interaction utilisateur */
            background-color: #e9ecef;
            /* Style visuel de champ en lecture seule */
            color: #6c757d;
            /* Couleur du texte en lecture seule */
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="mb-3 row">

                                            <div class="mb-3 col-md-6">
                                                <label class="form-label" for="product-title-input">Sélectionner une
                                                    categorie <span class="text-danger">*</span>
                                                </label>
                                                <select id="categorie" class="form-control js-example-basic-single"
                                                    name="categorie_id" required>
                                                    <option value="" disabled selected>Selectionner</option>

                                                    @foreach ($data_categorie as $categorie)
                                                        @include(
                                                            'backend.pages.produit.partials.subCategorieOptionEdit',
                                                            ['category' => $categorie]
                                                        )
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label" for="meta-title-input">Libellé <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="nom" value="{{ $data_produit['nom'] }}"
                                                    class="form-control" id="nomProduit" required>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">valeur de l'unité
                                                    <i class="ri ri-information-line fs-6  text-warning p-1 rounded fw-bold"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        title="Information"
                                                        data-bs-content="exemple 1.5 L , utiliser un . ou , exemple 1,5"></i>

                                                </label>

                                                <input type="number" name="valeur_unite"
                                                    class="form-control customNumberInput" id="quantiteUnite" step="0.01"
                                                    value="{{ $data_produit->valeur_unite }}">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">Unité
                                                </label>
                                                <select id="uniteProduit" class="form-control js-example-basic-single"
                                                    name="unite_id">
                                                    <option value="" selected>Choisir</option>
                                                    @foreach ($data_unite as $unite)
                                                        <option value="{{ $unite->id }}" @selected($data_produit->unite_id == $unite->id)>
                                                            {{ $unite->libelle }}
                                                            ({{ $unite->abreviation }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            {{-- <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">Format
                                                </label>
                                                <select id="formatProduit" class="form-control js-example-basic-single"
                                                    name="format_id">
                                                    <option value=""  selected>Choisir</option>
                                                    @foreach ($data_format as $format)
                                                        <option value="{{ $format->id }}" @selected($data_produit->format_id == $format->id)>
                                                            {{ $format->libelle }}
                                                            ({{ $format->abreviation }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">valeur du format
                                                    <i class="ri ri-information-line fs-5  text-warning p-1 rounded fw-bold"
                                                        data-bs-toggle="popover" data-bs-trigger="hover focus"
                                                        title="Information"
                                                        data-bs-content="exemple pack de 6 bouteilles , 6"></i>
                                                </label>

                                                <input type="number" name="valeur_format"
                                                    class="form-control customNumberInput" id="quantiteUnite" step="0.01"
                                                    value="{{ $data_produit->valeur_format }}">
                                            </div> --}}

                                            <div class="col-md-3 mb-3 divUniteSortie">
                                                <label class="form-label" for="meta-title-input">Unité de sortie ou vente
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-control js-example-basic-single uniteSortie"
                                                    name="unite_sortie_id" required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    @foreach ($data_unite as $unite)
                                                        <option value="{{ $unite->id }}" @selected($data_produit->unite_sortie_id == $unite->id)>
                                                            {{ $unite->libelle }}
                                                            ({{ $unite->abreviation }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>


                                            <div class="col-md-3 mb-3 d-none ">
                                                <label class="form-label" for="meta-title-input">Prix de vente
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="prix" value="{{ $data_produit->prix }}"
                                                    class="form-control " id="prixVenteHide">
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="meta-title-input">Stock alerte <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="stock_alerte" class="form-control"
                                                    id="stockAlerte" value="{{ $data_produit->stock_alerte }}" required>
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
                                                    {{-- <div class="row variante-row mb-4">
                                                        <div class="col-2">
                                                            <label for="prix">Quantité :</label>
                                                            <input type="number" class="form-control"
                                                                name="variantes[0][quantite]" value="1" readonly>
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="variante">Nom de la Variante :</label>
                                                            <select name="variantes[0][libelle]" class="form-control"
                                                                @readonly(true)>
                                                                @foreach ($data_variante as $variante)
                                                                    @if ($variante->slug == 'bouteille')
                                                                        <option value="{{ $variante->id }}">
                                                                            {{ $variante->libelle }}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-4">
                                                            <label for="prix">Prix unitaire de vente :</label>
                                                            <input type="number" step="0.01"
                                                                class="form-control prixVente" name="variantes[0][prix]"
                                                                required>
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <button type="button" class="btn btn-primary mb-3"
                                                    id="add-variante">Ajouter
                                                    une Variante</button>

                                            </div>

                                            <!-- ========== End Variante ========== -->




                                        </div>
                                        <div>
                                            <label>Description</label>
                                            <textarea name="description" id="ckeditor-classic"></textarea>
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label class="form-check-label" for="customAff">Statut du produit </label>

                                            <div class="form-check form-switch form-switch-lg col-md-2" dir="ltr">
                                                <input type="checkbox" name="statut" class="form-check-input"
                                                    id="customAff"
                                                    {{ $data_produit['statut'] == 'active' ? 'checked' : '' }}>
                                            </div>
                                            <div class="valid-feedback">
                                                Looks good!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-4">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="mb-4">
                                            <h5 class="fs-14 mb-1">Image principale <span class="text-danger">*</span>
                                            </h5>
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
                                                            type="file" name="imagePrincipale" accept="image/*">
                                                        <div class="invalid-feedback">Ajouter une image</div>
                                                    </div>
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded">
                                                            <img src="{{ $data_produit->getFirstMediaUrl('ProduitImage') }}"
                                                                id="product-img" class="avatar-md h-auto" />
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

    @section('script')
        <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
        <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
        <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
        {{-- <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script> --}}
        <script src="{{ URL::asset('build/tinymce/tinymce.min.js') }}"></script>
        <script src="{{ URL::asset('build/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js') }}"></script>

        <script src="{{ URL::asset('build/libs/dropzone/dropzone-min.js') }}"></script>
        <script src="{{ URL::asset('build/js/pages/ecommerce-product-create.init.js') }}"></script>
        <script src="{{ URL::asset('build/js/app.js') }}"></script>

        <script>
            //gestion des variante dejà enregister

            let dataVariante = @json($data_produit->variantes);
            let idVariante = dataVariante.map(variante => variante.id); // Récupérer les IDs des variantes

            let nombreVariantes = dataVariante.length;
            for (let i = 0; i < nombreVariantes; i++) {
                const container = document.getElementById('variantes-container');
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'variante-row', 'mb-4');
                newRow.innerHTML = `
                        <div class="col-2">
                            <label for="quantite">Quantité :</label>
                            <input type="number" name="variantes[${i}][quantite]" class="form-control" required value="${dataVariante[i].pivot.quantite}">
                        </div>
                        <div class="col-4">
                            <label for="libelle">Nom de la Variante :</label>
                            <select class="form-control" name="variantes[${i}][libelle]" required>
                                <option value="" selected>Choisir</option>
                                @foreach ($data_unite as $item)
                                    <option value="{{ $item->id }}">{{ $item->libelle }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4">
                            <label for="prix">Prix unitaire par quantité :</label>
                            <input type="number" step="0.01" class="form-control" name="variantes[${i}][prix]" required value="${dataVariante[i].pivot.prix}">
                        </div>
                        <div class="col-2 mt-2">
                            <button type="button" class="btn btn-danger remove-variante mt-3"> <i class="mdi mdi-delete remove-variante"></i></button>
                        </div>
                    `;

                container.appendChild(newRow);

                // Sélectionner automatiquement la bonne option dans le select
                const selectElement = newRow.querySelector(`select[name="variantes[${i}][libelle]"]`);
                const optionToSelect = selectElement.querySelector(`option[value="${dataVariante[i].id}"]`);
                if (optionToSelect) {
                    optionToSelect.selected = true;
                    // if (dataVariante[i].libelle === 'Bouteille') {
                    //     newRow.querySelector('.remove-variante').style.display = 'none';
                    //     newRow.querySelector(`input[name="variantes[${i}][quantite]"]`).readOnly = true;
                    //     newRow.querySelector(`input[name="variantes[${i}][quantite]"]`).style.backgroundColor = '#eff2f7';
                    //     selectElement.classList.add('non-selectable');

                    //     // Empêcher le changement de valeur via JavaScript
                    //     selectElement.addEventListener('mousedown', (e) => {
                    //         e.preventDefault();
                    //     });
                    // }

                    if (i === 0) {
                        newRow.querySelector('.remove-variante').style.display = 'none';
                    }
                }


            }




            //gestion des variantes
            let varianteIndex = parseInt(dataVariante.length);

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
                        @foreach ($data_unite as $variante)
                            <option value="{{ $variante->id }}">{{ $variante->libelle }}</option>
                        @endforeach
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

            //recuperer la valeur de la categorie par defaut
            var defaultCategorie = @json($data_produit->categorie->famille);

            if (defaultCategorie == 'restaurant') {
                $('.prixVente').prop('required', false)
                $('.divVariante').hide();
                $('.prixVente').val('')



                $('.divUniteSortie').show();
                $('.uniteSortie').prop('required', true);



            } else {

                $('.prixVente').prop('required', true)
                $('.divVariante').show();

                $('.divUniteSortie').hide();
                $('.uniteSortie').prop('required', false);
            }


            // Afficher les champs en fonction de la categorie selectionné
            let categoryFamille;
            var categorieData = @json($categorieAll) // from product controller




            //recuperer la categorie selectionné
            $('#categorie').change(function(e) {
                e.preventDefault();

                var categorieSelect = $(this).val()

                //filtrer pour recuperer la categorie selectionnée
                var categorieFilter = categorieData.filter(function(item) {
                    return item.id == categorieSelect
                })


                // si categorieFilter = restaurant , required false
                if (categorieFilter[0].famille == 'restaurant') {
                    $('.prixVente').prop('required', false)
                    $('.divVariante').hide();
                    $('.prixVente').val('')


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


            //get gallery Image from controller for edit
            var getGalleryProduct = {{ Js::from($galleryProduit) }}

            for (let i = 0; i < getGalleryProduct.length; i++) {
                const element = getGalleryProduct[i];
                var image = ` <div class="col-12 d-flex justify-content-between border border-secondary rounded"><img src="data:image/jpeg;base64,${element}" class="img-thumbnail rounded float-start" width="50" height="100">
                                   <button type="button" class="btn btn-danger my-2 remove-image">Delete</button>
                                    </div>  `;
                console.log('edit:', image);
                $('#imageTableBody').append(image);
            }



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

                // var variantes = document.querySelector('select[name="variantes[0][libelle]"] option[value="Bouteille"]');
                // var prixVariante = variantes[0].value;
                // var prixVenteHide = $('#prixVenteHide').val(prixVariante);

                var productId = {{ Js::from($id) }} // product Id
                var formData = new FormData(this);

                $('#imageTableBody div').each(function() {
                    var imageFile = $(this).find('img').attr('src');
                    formData.append('images[]', imageFile)
                });

                $.ajax({
                    url: "/admin/produit/update/" + productId, // Adjust the route as needed
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
                            var url = "{{ route('produit.index') }}" // redirect route product list

                            window.location.replace(url);
                        } else if (response == 'The nom has already been taken.') {
                            Swal.fire({
                                title: 'Ce produit existe déjà ?',
                                text: $('#nomProduit').val(),
                                icon: 'warning',
                                customClass: {
                                    confirmButton: 'btn btn-primary w-xs me-2 mt-2',
                                    cancelButton: 'btn btn-danger w-xs mt-2',
                                },
                                buttonsStyling: false,
                                showCloseButton: true
                            })
                        }
                    },

                });
            });
        </script>
    @endsection
@endsection
