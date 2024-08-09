@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Nouveau stock
        @endslot
        @slot('title')
            Créer un nouveau stock
        @endslot
    @endcomponent
    <style>
        form label {
            font-size: 11px
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="product-title-input">Type de produit
                                                </label>
                                                <select class="form-control typeSelected js-example-basic-single"
                                                    name="type_produit" required>
                                                    <option value="" disabled selected></option>
                                                    @foreach ($type_produit as $type)
                                                        <option value="{{ $type->id }}">
                                                            {{ $type->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label class="form-label" for="product-title-input">Sélectionner un produit
                                                </label>
                                                <a href="{{ route('produit.create') }}"
                                                    class="float-end text-decoration-underline">
                                                    <i class="ri ri-add-fill"></i>
                                                    Ajouter un nouveau produit
                                                </a>
                                                <select class="form-control productSelected  js-example-basic-single"
                                                    name="produit" required>
                                                </select>
                                            </div>


                                            <!-- ========== Start include entree  ========== -->
                                            <div class="row" id="entree"></div>
                                            <!-- ========== End include entree  ========== -->


                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-3">
                                <div class="card">
                                    {{-- <div class="card-header">
                                        <h5 class="card-title mb-0">Gallerie Images</h5>
                                    </div> --}}

                                    <div class="card-body border border-primary border-dashed">
                                        <div class="mb-4">
                                            <p>Sku : <span class="fw-bold" id="sku">0</span></p>
                                            <p>Stock actuel : <span class="fw-bold" id="stock">0</span></p>
                                            <p>Stock alerte : <span class="fw-bold text-danger" id="stockAlerte">0</span>
                                            </p>
                                            <p>Categorie : <span class="fw-bold" id="categorie">??</span></p>

                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded" id="product-img">
                                                            {{-- <img src="" id="product-img" class="avatar-md h-auto" /> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        {{-- <div class="col-md-12 mt-3">
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
                                        </div> --}}

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
            //script for field form
            // get name selected format


            //get list product of type product
            $('.typeSelected').change(function(e) {
                e.preventDefault();
                var typeSelected = $('.typeSelected option:selected').val();
                var typeProduct = {{ Js::from($type_produit) }} // from contrioller
                var filterType = typeProduct.filter(function(item) {
                    return item.id == typeSelected
                })



                //show include entree form
                if (filterType[0].name == 'bar') {
                    var barForm = ` @include('backend.pages.stock.entree.partials.barProduct')`
                    $('#entree').html(barForm)
                } else if (filterType[0].name == 'restaurant') {
                    var restaurantForm = ` @include('backend.pages.stock.entree.partials.restaurantProduct')`
                    $('#entree').html(restaurantForm)
                } else {
                    $('#entree').html('')
                }

                // script for field form
                if (filterType[0].name) {
                    //format field
                    $('.format').change(function(e) {
                        e.preventDefault();
                        var formatSelected = $('.format option:selected').attr('data-value');
                        $('#libFormat').html(' de ' + formatSelected)
                        $('#libPiece').html(' par ' + formatSelected)
                    })


                    //unite field
                    // $('#unite').change(function(e) {
                    //     e.preventDefault();
                    //     var uniteSelected = $('#unite option:selected').attr('data-value');
                    //     $('.libUnite').html(' de ' + uniteSelected)
                    //     $('.libUnite').html(' par ' + uniteSelected)

                    // })

                    // calculate qte unite global
                    function calculateQteGlobale() {
                        var qte_format = $("#qteFormat").val() || 0;
                        var unite_unitaire = $("#qteUniteUnitaire").val() || 0;
                        var prix_achat_unitaire = $("#prixAchatUnitaire").val() || 0;

                        var qteUniteGlobale = qte_format * unite_unitaire

                        $('#qteUniteGlobale').val(qteUniteGlobale) //update

                    }
                    $('#qteFormat ,#qteUniteUnitaire').on('input', calculateQteGlobale)


                    //calculate prix achat 
                    function calculatePrixAchat() {
                        var qte_format = $("#qteFormat").val() || 0;
                        var prix_achat_total = $("#prixAchatTotal").val() || 0;

                        var prixAchatUnitaire = prix_achat_total / qte_format
                        var prixAchatTotal = qte_format * prixAchatUnitaire

                        $('#prixAchatUnitaire').val(prixAchatUnitaire)

                    }

                    $('#qteFormat ,#prixAchatTotal').on('input', calculatePrixAchat)


                    // //calculate prix achat total
                    function calculatePrixAchatTotal() {
                        var qte_format = $("#qteFormat").val() || 0;
                        var prix_achat_unitaire = $("#prixAchatUnitaire").val() || 0;

                        var prixAchatTotal = qte_format * prix_achat_unitaire

                        $('#prixAchatTotal').val(prixAchatTotal)

                    }

                    $('#qteFormat , #prixAchatUnitaire').on('input', calculatePrixAchatTotal)








                }



                //filter product of typeSelected
                var dataProduct = {{ Js::from($data_produit) }} // from controller
                var productList = dataProduct.filter(function(item) {
                    return item.type_id == typeSelected;
                });

                $('.productSelected').empty();
                $('.productSelected').append('<option disabled selected value="">Selectionner un produit</option>');
                $.each(productList, function(key, value) {
                    $('.productSelected').append('<option value="' + value.id + '">' + value.nom +
                        '</option>');
                });


            });

            //get product select and show detail of product selected
            $('.productSelected').change(function(e) {
                var dataProduct = {{ Js::from($data_produit) }} // from controller

                e.preventDefault();
                var productSelected = $('.productSelected option:selected').val();

                var filteredProduct = dataProduct.filter(function(item) {
                    return item.id == productSelected;
                });
                console.log(filteredProduct[0].media);


                //update stock , sku ,  category of product selected
                $('#stock').html(filteredProduct[0].stock)
                $('#stockAlerte').html(filteredProduct[0].stock_alerte)

                $('#sku').html(filteredProduct[0].code)
                $('#categorie').html(filteredProduct[0].categorie.name)

                var img = filteredProduct[0].media[0].original_url
                $('#product-img').html(`<img src="${img}"  class="avatar-md h-auto" />`)



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
                    url: "{{ route('produit.create') }}", // Adjust the route as needed
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
                            var url = "{{ route('stock.create') }}" // redirect route 

                            window.location.replace(url);
                        }
                    },

                });
            });
        </script>
    @endsection
@endsection
