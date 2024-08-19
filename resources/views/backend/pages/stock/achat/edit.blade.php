@extends('backend.layouts.master')

@section('content')


    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Achat
        @endslot
        @slot('title')
            Modifier un achat
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
                    <form method="POST" action="{{ route('achat.update', $data_achat['id']) }}" autocomplete="off"
                        class="needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Type de produit
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_achat['type_produit']['name'] }}" readonly>


                                            </div>
                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label" for="product-title-input">Produit
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_achat['produit']['nom'] }}" readonly>
                                            </div> --}}

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Format
                                                </label>
                                                <select class="form-control js-example-basic-single format" name="format_id"
                                                    required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    @foreach ($data_format as $format)
                                                        <option data-value={{ $format->libelle }}
                                                            value="{{ $format->id }}"
                                                            {{ $format->id == $data_achat->format_id ? 'selected' : '' }}>
                                                            {{ $format->libelle }}
                                                            ({{ $format->abreviation }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Nombre de
                                                    {{ $data_achat['format']['libelle'] }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_achat['quantite_format'] }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Fournisseur
                                                </label>
                                                <select class="form-control js-example-basic-single" name="fournisseur_id">
                                                    <option value="" disabled selected>Choisir</option>
                                                    @foreach ($data_fournisseur as $fournisseur)
                                                        <option value="{{ $fournisseur->id }}"
                                                            {{ $fournisseur->id == $data_achat->fournisseur_id ? 'selected' : '' }}>
                                                            {{ $fournisseur->nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Unite de vente
                                                </label>
                                                <select id="unite" class="form-control js-example-basic-single"
                                                    name="unite_id" required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    @foreach ($data_unite as $unite)
                                                        <option data-value="{{ $unite->libelle }}"
                                                            value="{{ $unite->id }}"
                                                            {{ $unite->id == $data_achat->unite_id ? 'selected' : '' }}>
                                                            {{ $unite->libelle }}
                                                            ({{ $unite->abreviation }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Quantité stocké
                                                </label>
                                                <input type="text" id="quantiteStocke" class="form-control"
                                                    value="{{ $data_achat['quantite_stockable'] }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
                                                <input type="number" id="prixAchatUnitaire"
                                                    value="{{ $data_achat['prix_achat_unitaire'] }}" class="form-control"
                                                    name="prix_achat_unitaire"readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat total </label>
                                                <input type="number" id="prixAchatTotal"
                                                    value="{{ $data_achat['prix_achat_total'] }}" class="form-control"
                                                    name="prix_achat_total" readonly>
                                            </div>
                                            <div
                                                class="col-md-3 mb-3 {{ $data_achat['prix_vente'] ? 'd-block' : 'd-none' }}">
                                                <label class="form-label" for="stocks-input">Prix de vente </label>
                                                <input type="number" value="{{ $data_achat['prix_vente'] }}"
                                                    class="form-control" name="prix_vente_unitaire"
                                                    {{ $data_achat['prix_vente'] ? 'required' : '' }}>
                                            </div>


                                            <div class="col-md-4">
                                                <label class="form-check-label" for="customAff">Activer le stock</label>

                                                <div class="form-check form-switch form-switch-lg col-md-2" dir="ltr">
                                                    <input type="checkbox" name="statut" class="form-check-input"
                                                        id="customAff"
                                                        {{ $data_achat['statut'] == 'active' ? 'checked' : '' }}>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                            <div class="col-lg-3">
                                <div class="card">
                                    <div class="card-body border border-primary border-dashed">
                                        <div class="mb-4">

                                            <p>Sku : <span class="fw-bold"
                                                    id="sku">{{ $data_achat['produit']['code'] }} </span></p>
                                            <p>Nom : <span class="fw-bold"
                                                    id="sku">{{ $data_achat['produit']['nom'] }} </span></p>
                                            <p>Stock actuel : <span class="fw-bold"
                                                    id="stock">{{ $data_achat['produit']['stock'] }}</span></p>
                                            <p>Stock alerte : <span class="fw-bold text-danger"
                                                    id="stockAlerte">{{ $data_achat['produit']['stock_alerte'] }}</span>
                                            </p>
                                            <p>Categorie : <span class="fw-bold"
                                                    id="categorie">{{ $data_achat['produit']['categorie']['name'] }}</span>
                                            </p>

                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded" id="product-img">
                                                            <img src="{{ asset($data_achat->produit->getFirstMediaUrl('ProduitImage')) }}"
                                                                id="product-img" class="avatar-md h-auto" />
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
    @endsection
@endsection
