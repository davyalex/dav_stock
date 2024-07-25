@extends('backend.layouts.master')

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
        <!-- ========== Start categorie list ========== -->
        @include('backend.pages.categorie.categorie-list')
        <!-- ========== End categorie list ========== -->


        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <form class="row g-3 needs-validation" method="post" action="{{route('categorie.add-subCat-store')}}" novalidate>
                        @csrf
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Ajouter une sous categorie </label>
                            <input readonly type="text" name="categorie_parent" value="{{$data_categorie_parent['name']}}" class="form-control" id="validationCustom01"
                                placeholder="categorie1" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom01" class="form-label">Sous categorie</label>
                            <input type="text" name="name" class="form-control" id="validationCustom01"
                                required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Url</label>
                            <input type="text" name="url" class="form-control" id="validationCustom01"
                                placeholder="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        {{-- 
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Position</label>
                            <input type="text" name="position" class="form-control" id="validationCustom01"
                                placeholder="">
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div> --}}

                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Statut</label>
                            <select name="status" class="form-control">
                                <option value="active">Activé</option>
                                <option value="desactive">Desactivé</option>

                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>



                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 ">Valider</button>
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
@endsection
@endsection
