@extends('backend.layouts.master')

@section('content')


    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Nouveau Ajustement
        @endslot
        @slot('title')
            Créer un ajustement
        @endslot
    @endcomponent
    <style>
        form label {
            font-size: 11px
        }
    </style>

    <div class="row">
        <div class="col-lg-12">
            <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                role="alert">
                <i class="ri-airplay-line label-icon"></i><strong>Pour ajuster le stock : </strong>
                <ol>
                    <li>Choisir le mouvement (Ajouter ou soustraire)</li>
                    <li>Ajouter la quantité</li>
                    <li>Vous pouvez desactiver ou activer le stock en cliquant sur le bouton statut en bas</li>
                </ol>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('ajustement.store') }}" autocomplete="off"
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
                                                    value="{{ $data_ajustement['type_produit']['name'] }}" readonly>


                                            </div>
                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="form-label" for="product-title-input">Produit
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_ajustement['produit']['nom'] }}" readonly>
                                            </div> --}}

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Format
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_ajustement['format']['libelle'] ?? '' }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Nombre de
                                                    {{ $data_ajustement['format']['libelle'] }}
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_ajustement['quantite_format'] }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Fournisseur
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_ajustement['fournisseur']['nom'] ?? '' }}" readonly>
                                            </div>


                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Unite de vente
                                                </label>
                                                <input type="text" class="form-control"
                                                    value="{{ $data_ajustement['unite']['libelle'] }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="product-title-input">Quantité stocké
                                                </label>
                                                <input type="text" id="quantiteStocke" class="form-control"
                                                    value="{{ $data_ajustement['quantite_stockable'] }}" readonly>
                                            </div>

                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat unitaire </label>
                                                <input type="number" id="prixAchatUnitaire"
                                                    value="{{ $data_ajustement['prix_achat_unitaire'] }}"
                                                    class="form-control" name="prix_achat_unitaire" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="form-label" for="stocks-input">Prix d'achat total </label>
                                                <input type="number" id="prixAchatTotal"
                                                    value="{{ $data_ajustement['prix_achat_total'] }}" class="form-control"
                                                    name="prix_achat_total" readonly>
                                            </div>


                                            <div class="d-flex justify-content-between">
                                                <hr class="w-50" size="5">
                                                <h5>Ajustement</h5>
                                                <hr class="w-50 text-primary" size="5">
                                            </div>
                                            <p id="MsgError" class="text-danger fw-bold"></p>
                                            <div class="col-md-6">
                                                <label class="form-label" for="product-title-input">Mouvement du stock
                                                </label>
                                                <select id="mouvementStock" class="form-control js-example-basic-single"
                                                    name="mouvement" required>
                                                    <option value="" disabled selected>Choisir</option>
                                                    <option value="ajouter">Ajouter</option>
                                                    <option value="retirer">Retirer</option>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3 ">
                                                <label class="form-label" for="stocks-input">Quantité <span></span> <span
                                                        class="text-danger" id="labelUnite"></span></label>
                                                <br>
                                                <div class="input-step w-100">
                                                    <button type="button"
                                                        class="minus w-50 btn btn-primary decreaseValue"
                                                        disabled>-</button>
                                                    <input type="number" class="form-control" id="quantiteStockable"
                                                        value="0" name="stock_ajustement" readonly>
                                                    <button type="button" class="plus w-50 btn btn-primary increaseValue"
                                                        disabled>+</button>
                                                </div>
                                            </div>

                                            {{-- <div class="col-md-4">
                                                <label class="form-check-label" for="customAff">Activer le stock</label>

                                                <div class="form-check form-switch form-switch-lg col-md-2"
                                                    dir="ltr">
                                                    <input type="checkbox" name="statut" class="form-check-input"
                                                        id="customAff"
                                                        {{ $data_ajustement['statut'] == 'active' ? 'checked' : '' }}>
                                                </div>

                                            </div> --}}

                                            <input type="text" name="achat_id" value="{{ $data_ajustement['id'] }}"
                                                hidden>

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
                                                    id="sku">{{ $data_ajustement['produit']['code'] }} </span></p>
                                            <p>Nom : <span class="fw-bold"
                                                    id="sku">{{ $data_ajustement['produit']['nom'] }} </span></p>
                                            <p>Stock actuel : <span class="fw-bold"
                                                    id="stock">{{ $data_ajustement['produit']['stock'] }}</span></p>
                                            <p>Stock alerte : <span class="fw-bold text-danger"
                                                    id="stockAlerte">{{ $data_ajustement['produit']['stock_alerte'] }}</span>
                                            </p>
                                            <p>Categorie : <span class="fw-bold"
                                                    id="categorie">{{ $data_ajustement['produit']['categorie']['name'] }}</span>
                                            </p>

                                            <div class="text-center">
                                                <div class="position-relative d-inline-block">
                                                    <div class="avatar-lg">
                                                        <div class="avatar-title bg-light rounded" id="product-img">
                                                            <img src="{{ asset($data_ajustement->produit->getFirstMediaUrl('ProduitImage')) }}"
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
        <script>
            // script for quantity stock increase and dicrease
            $(document).ready(function() {

                //recuperer le type du mouvement selectionné
                $('#mouvementStock').change(function() {
                    var mouvementStock = $('#mouvementStock option:selected').val();
                    $('#quantiteStockable').prop('readonly', false)
                    $('#quantiteStockable').val(0) // nouvelle quantité a stocké
                    if (mouvementStock == 'ajouter') {
                        $('.increaseValue').prop('disabled', false)
                        $('.decreaseValue').prop('disabled', true)

                    } else if (mouvementStock == 'retirer') {
                        $('.decreaseValue').prop('disabled', false)
                        $('.increaseValue').prop('disabled', true)
                        verifiyQty()

                    } else {
                        $('.increaseValue').prop('disabled', true)
                        $('.decreaseValue').prop('disabled', true)
                    }

                });


                //increase and decrease Qty stock
                $('.increaseValue').click(function(e) {
                    e.preventDefault();
                    var input = document.getElementById("quantiteStockable");
                    var value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    value++;
                    input.value = value;
                });


                $('.decreaseValue').click(function(e) {
                    e.preventDefault();
                    var qteStock = $('#quantiteStocke').val() // qté stocké du stock
                    var input = document.getElementById("quantiteStockable");
                    var value = parseInt(input.value, 10);
                    value = isNaN(value) ? 0 : value;
                    // value < 1 ? value = 1 : '';
                    // if (value > 1) {
                    //     value--;
                    // }
                    // value--;
                    if (value < qteStock - 1) {
                        value++;
                    }

                    input.value = value;
                    // verifiyQty()
                });


                // verifier le nombre entrer en reel de quantité
                function verifiyQty() {
                    $('#quantiteStockable').on('input', function() {
                        var qteStock = $('#quantiteStocke').val() // qté stocké du stock
                        let currentValue = parseInt($(this).val());
                        if (currentValue > qteStock - 1) {
                            // $(this).val(qteStock - 1);
                            $('#MsgError').html(
                                'La quantité entrée est supérieur ou égale à la quantité stockée ')
                        } else {
                            $('#MsgError').html('')
                        }
                    });
                }

            });
        </script>
    @endsection
@endsection
