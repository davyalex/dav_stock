@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        <link href="{{ URL::asset('build/libs/dropzone/dropzone.css') }}" rel="stylesheet">

        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Modifier un menu
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
                            <div class="col-lg-12">
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
                                                <input type="text" name="libelle" value="{{$data_menu['libelle']}}" class="form-control">
                                            </div>

                                            <div class="col-md-4 mb-3">
                                                <label class="form-label" for="meta-title-input">Date <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="date" id="currentDate" value="{{$data_menu['date_menu']}}"
                                                    name="date_menu" class="form-control" required>
                                            </div>

                                            <div class="col-lg-6">

                                            </div>

                                            <div class="row mt-4">
                                                 @php
                                                            //get produit_menu
                                                            $menu_produit = [];
                                                            foreach ($data_menu['produit_menu'] as  $value) {
                                                               array_push( $menu_produit , $value['id']);
                                                             
                                                            }
                                                            
                                                          

                                                        @endphp
                                                @foreach ($data_categorie_produit as $categorie)
                                                    <div class="col-md-6">
                                                        <h4 class="my-3 text-capitalize"> {{ $categorie['name'] }} </h4>
                                                       

                                                        @foreach ($categorie->produit_menus as $produit)
                                                                
                                                            <div class="form-check form-check-dark m-2 ">
                                                                <input class="form-check-input produit"
                                                                    value="{{ $produit['id'] }}" name="produits[]"
                                                                    type="checkbox" id="formCheck{{ $produit->id }}" {{in_array($produit->id ,$menu_produit ) ? 'checked' :  ''}}>
                                                                <label class="form-check-label"
                                                                    for="formCheck{{ $produit->id }}">
                                                                    {{ $produit->nom }} <i class="text-danger">
                                                                        {{ $produit->prix }} FCFA</i>
                                                                </label>
                                                            </div>
                                                        @endforeach


                                                    </div><!--end col-->
                                                @endforeach
                                            </div><!--end row-->

                                        </div>

                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->

                        </div>
                        <!-- end row -->
                        <!-- end card -->
                        <div class="text-end mb-3">
                            <button type="submit" id="btnSubmit" class="btn btn-success w-lg" disabled>Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div><!-- end row -->
        </div><!-- end col -->

        <!--end row-->
    @section('script')
        <script>
            $(function() {
                // Vérifier lors du clic
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

                    //disabled and enable button 
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
