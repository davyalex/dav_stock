@extends('backend.layouts.master')
@section('title')
    Menu
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Créer un nouveau menu
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('menu.store') }}" autocomplete="off" class="needs-validation"
                        novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mb-3 row">
                                        <div class="alert alert-info alert-dismissible alert-label-icon label-arrow fade show material-shadow"
                                            role="alert">
                                            <i class="ri-airplay-line label-icon"></i><strong>Selectionnez les
                                                differents plats pour composer votre menu : </strong>

                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>

                                        <div class="col-md-8">
                                            <label class="form-label" for="meta-title-input">Libellé
                                            </label>
                                            <input type="text" name="libelle" class="form-control">
                                        </div>

                                        <div class="col-md-4 mb-3">
                                            <label class="form-label" for="meta-title-input">Date <span
                                                    class="text-danger">*</span>
                                            </label>
                                            <input type="date" id="currentDate" value="<?php echo date('Y-m-d'); ?>"
                                                name="date_menu" class="form-control" required>
                                        </div>

                                        <!-- ========== Start product menu for checked ========== -->
                                        {{-- @include('backend.pages.menu.partials.categorieProduct') --}}
                                        <!-- ========== End product menu for checked ========== -->


                                        <div class="container my-4 divVariante">

                                            <div id="variantes-container">
                                                <div class="row variante-row mb-4">

                                                    <div class="col-4">
                                                        <label for="variante">Categorie</label>
                                                        <div class="d-flex">
                                                            <select name="variantes[0][libelle]"
                                                                class="form-control"required>
                                                                <option value="" selected> Selectionner</option>
                                                                {{-- @foreach ($data_unite as $variante)
                                                                <option value="{{ $variante->id }}">
                                                                    {{ $variante->libelle }}</option>
                                                            @endforeach --}}
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <label for="variante">Plats :</label>
                                                        <div class="d-flex">
                                                            <select name="variantes[0][libelle]"
                                                                class="form-control"required>
                                                                <option value="" selected> Selectionner</option>
                                                                {{-- @foreach ($data_unite as $variante)
                                                                <option value="{{ $variante->id }}">
                                                                    {{ $variante->libelle }}</option>
                                                            @endforeach --}}
                                                            </select>
                                                            <button type="button" class="btn btn-primary ml-2"
                                                                data-bs-toggle="modal" data-bs-target="#createPlatModal"> <i
                                                                    class="mdi mdi-plus"></i> </button>
                                                        </div>

                                                    </div>
                                                    <div class="col-4">
                                                        <label for="variante">Complements :</label>
                                                        <div class="d-flex">
                                                            <select name="variantes[0][libelle]"
                                                                class="form-control"required>
                                                                <option value="" selected> Selectionner</option>
                                                                {{-- @foreach ($data_unite as $variante)
                                                                    <option value="{{ $variante->id }}">
                                                                        {{ $variante->libelle }}</option>
                                                                @endforeach --}}
                                                            </select>
                                                            <button type="button" class="btn btn-primary ml-2"
                                                                data-bs-toggle="modal" data-bs-target="#createPlatModal"> <i
                                                                    class="mdi mdi-plus"></i> </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-primary mb-3" id="add-variante">Ajouter <i
                                                    class="mdi mdi-plus"></i>
                                            </button>

                                        </div>

                                        @include('backend.pages.menu.plat-menu.partials.create-modal-plat' , ['data_categorie' => $categorie_menu])

                                    </div>

                                </div>
                            </div>
                            <!-- end card -->

                            <!-- end col -->

                        </div>
                        <!-- end row -->
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" id="btnSubmit" class="btn btn-success w-lg">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->


        <!--end row-->
    @section('script')

        <script>
            $(function() {
                // Vérifier si un plat est choisi ? bouton save active : disabled
                var checkedItems = []
                $('.produit').change(function() {
                    if ($(this).is(':checked')) {
                        checkedItems.push($(this).val());
                    } else {
                        var index = checkedItems.indexOf($(this).val());
                        if (index !== -1) {
                            checkedItems.splice(index, 1);
                        }
                    }

                    //disabled and enable button save 
                    if (checkedItems.length > 0) {
                        $('#btnSubmit').prop('disabled', false);
                    } else {
                        $('#btnSubmit').prop('disabled', true);
                    }
                });
            });
        </script>
    @endsection

@endsection
