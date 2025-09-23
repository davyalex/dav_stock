@extends('backend.layouts.master')
@section('title')
   Categorie
@endsection
@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            categorie
        @endslot
        @slot('title')
            Créer un sous-categorie
        @endslot
    @endcomponent

    <div class="row">
    
        <div class="col-lg-10 m-auto">
            <div class="card">

                <div class="card-body">
                    <form class="row g-3 needs-validation" method="post" action="{{route('categorie.add-subCat-store')}}" novalidate>
                        @csrf
                        <div class="col-md-12">
                            <h5>Categorie parent selectionnée : <strong class="text-primary">{{$data_categorie_parent['name']}}</strong></h5>
                            <input readonly type="text" name="categorie_parent" value="{{$data_categorie_parent['id']}}" class="form-control" id="validationCustom01"
                                placeholder="categorie1" hidden>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Nom de la sous categorie</label>
                            <small class="text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    La nouvelle catégorie sera créée sous : <span>{{$data_categorie_parent['name']}}</span>
                                </small>
                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        {{-- <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Url</label>
                            <input type="text" name="url" class="form-control" id="validationCustom01"
                                placeholder="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> --}}
                        {{-- 
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" id="validationCustom01"
                                placeholder="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> --}}

                        <div class="col-md-2">
                            <label for="validationCustom01" class="form-label">Statut</label>
                            <select name="status" class="form-control">
                                <option value="active">Activé</option>
                                <option value="desactive">Desactivé</option>

                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>


                        <div class="col-md-2 pt-2">
                            <label for="validationCustom01" class="form-label"></label>
                            <button type="submit" class="btn btn-primary w-100 ">Valider</button>
                        </div>
                </div>
               
                </form>
            </div>
        </div><!-- end row -->


           <!-- ========== Start categorie list ========== -->
           @include('backend.pages.categorie.categorie-list')
           <!-- ========== End categorie list ========== -->
   
    </div><!-- end col -->

    <!--end row-->

@section('script')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>

    {{-- <script src="{{ URL::asset('build/js/pages/form-editor.init.js') }}"></script> --}}
@endsection
@endsection
