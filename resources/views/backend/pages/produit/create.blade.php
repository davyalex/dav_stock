@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Produit
        @endslot
        @slot('title')
            Créer un nouveau produit
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                    @endif
                    <form method="POST" action="{{ route('produit.store') }}" autocomplete="off" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- Colonne principale -->
                            <div class="col-lg-8">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="form-label">Catégorie <span
                                                        class="text-danger">*</span></label>
                                                <select id="categorie-filter" class="form-control js-example-basic-single"
                                                    name="categorie_id" required>
                                                    <option value="" disabled selected>Selectionner</option>

                                                    @foreach ($data_categorie as $categorie)
                                                        @include(
                                                            'backend.pages.produit.partials.subCategorieOption',
                                                            ['category' => $categorie]
                                                        )
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Libellé <span class="text-danger">*</span></label>
                                                <input type="text" name="nom" class="form-control" id="nomProduit"
                                                    required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Prix de vente
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="prix" class="form-control "
                                                    id="prixVenteHide" required>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label" for="meta-title-input">Stock alerte <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" name="stock_alerte" class="form-control"
                                                    id="stockAlerte" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label>Description</label>
                                        <textarea name="description" id="ckeditor-classic" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- Colonne image -->
                            <div class="col-lg-4">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <label class="form-label">Image du produit</label>
                                        <input type="file" id="imageInput" name="image" accept="image/*"
                                            class="form-control mb-2">
                                        <div id="imagePreviewContainer" class="text-center">
                                            <img id="imagePreview" src="#" alt="Aperçu"
                                                class="img-fluid rounded d-none" style="max-height:200px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-end mb-3">
                            <button type="submit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
        document.getElementById('imageInput').addEventListener('change', function(event) {
            const input = event.target;
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
            }
        });
    </script>
    @endsection
@endsection
