@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Vente
        @endslot
        @slot('title')
            Billeterie
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form id="formSend" autocomplete="off" class="needs-validation" novalidate enctype="multipart/form-data"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">


                                    <!-- ========== Start Monnaie ========== -->
                                    <div class="container my-4 divVariante">

                                        <div class="col-12 d-flex justify-content-center">
                                            <p>-------------------------------</p> <span class="fw-bold">Gestion de
                                                la billeterie</span>
                                            <p> -----------------------------</p>
                                        </div>

                                        <div id="variantes-container">
                                            <div class="row variante-row mb-4">
                                                <div class="col-3">
                                                    <label for="quantite" class="form-label">Quantité</label>
                                                    <select class="form-select" id="quantite" name="quantite" required>
                                                        <option selected disabled value="">Selectionner</option>
                                                        @for ($i = 1; $i <= 500; $i++)
                                                            <option value="{{ $i }}">{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <div class="col-3">
                                                    <label for="type_monnaie" class="form-label">Type de monnaie</label>
                                                    <select class="form-select" id="type_monnaie" name="type_monnaie"
                                                        required>
                                                        <option selected disabled value="">Selectionner</option>
                                                        @foreach ($type_monnaies as $key => $type_monnaie)
                                                            <option value="{{ $key }}">{{ $type_monnaie }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-3">
                                                    <label for="valeur" class="form-label">Valeur</label>
                                                    <select class="form-select" id="valeur" name="valeur" required>
                                                        <option selected disabled value="">Selectionner</option>
                                                        @foreach ($billets as $key => $billet)
                                                            <option value="{{ $key }}">{{ $billet }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                {{-- <div class="col-3">
                                                    <label for="piece" class="form-label">Pièce</label>
                                                    <select class="form-select" id="piece" name="piece">
                                                        @foreach ($pieces as $key => $piece)
                                                            <option value="{{ $key }}">{{ $piece }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="col-3">
                                                    <label for="total" class="form-label">Total</label>
                                                    <input type="text" class="form-control" id="total" name="total"
                                                        readonly>
                                                </div>

                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary mb-3" id="add-monnaie">Ajouter
                                        </button>

                                    </div>

                                    <!-- ========== End Monnaie ========== -->


                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
                <!-- end row -->
                <!-- end card -->

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
        // recuperer les donnees depuis le controller
        var typeMonnaieData = @json($type_monnaies);
        var billetData = @json($billets);
        var pieceData = @json($pieces);

        console.log(typeMonnaieData, billetData, pieceData);



        //gestion des variantes
        let varianteIndex = 1;

        document.getElementById('add-monnaie').addEventListener('click', function() {
            const container = document.getElementById('variantes-container');
            const newRow = document.createElement('div');
            newRow.classList.add('row', 'variante-row', 'mb-4');
            newRow.innerHTML = `
                  <div class="col-2">
                    <label for="quantite">Quantité :</label>
                        <input type="number" name="variantes[${varianteIndex}][quantite]" class="form-control" required>
                        </div>
        <div class="col-4">
            <label for="libelle">Nom de la Variante :</label>
            <select class="form-control" name="variantes[${varianteIndex}][libelle]" required>
                <option value="" selected>Choisir</option>
            </select>
        </div>
        <div class="col-4">
            <label for="prix">Prix unitaire par quantité :</label>
            <input type="number" step="0.01" class="form-control" name="variantes[${varianteIndex}][prix]" required>
        </div>
        <div class="col-2 mt-2">
            <button type="button" class="btn btn-danger remove-variante mt-3"> <i class="mdi mdi-delete"></i></button>
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




        $('#formSend').on('submit', function(e) {
            e.preventDefault();





            // $.ajax({
            //     url: "{{ route('produit.store') }}", // Ajustez la route si nécessaire
            //     type: 'POST',
            //     data: formData,
            //     contentType: false,
            //     processData: false,
            //     success: function(response) {
            //         if (response.success === true) {
            //             // $('#imageTableBody').empty();

            //             Swal.fire({
            //                 title: 'Produit ajouté avec succès !',
            //                 icon: 'success',
            //                 showCancelButton: false,
            //                 customClass: {
            //                     confirmButton: 'btn btn-primary w-xs me-2 mt-2',
            //                     cancelButton: 'btn btn-danger w-xs mt-2',
            //                 },
            //                 buttonsStyling: false,
            //                 showCloseButton: true
            //             });

            //             var url = "{{ route('produit.index') }}"; // Rediriger vers la route stock
            //             window.location.replace(url);
            //         }
            //     },
            //     error: function(xhr) {
            //         // Gérer les erreurs
            //         if (xhr.status === 409) {
            //             // Produit déjà existant
            //             Swal.fire({
            //                 title: 'Ce produit a déjà été enregistré',
            //                 text: $('#nomProduit').val(),
            //                 icon: 'warning',
            //                 customClass: {
            //                     confirmButton: 'btn btn-primary w-xs me-2 mt-2',
            //                     cancelButton: 'btn btn-danger w-xs mt-2',
            //                 },
            //                 buttonsStyling: false,
            //                 showCloseButton: true
            //             });
            //         } else {
            //             // Autres types d'erreurs
            //             Swal.fire({
            //                 title: 'Erreur',
            //                 text: 'Une erreur est survenue, veuillez réessayer.',
            //                 icon: 'error',
            //                 customClass: {
            //                     confirmButton: 'btn btn-primary w-xs me-2 mt-2',
            //                     cancelButton: 'btn btn-danger w-xs mt-2',
            //                 },
            //                 buttonsStyling: false,
            //                 showCloseButton: true
            //             });
            //         }
            //     }
            // });



        });
    </script>
@endsection



@endsection
