@extends('backend.layouts.master')

@section('content')
    @component('backend.components.breadcrumb')
        @slot('li_1')
            Menu
        @endslot
        @slot('title')
            Modifier un menu
        @endslot
    @endcomponent

    <div class="row">
        <!-- ========== Start menu list ========== -->
        @include('backend.pages.menu.menu-list')
        <!-- ========== End menu list ========== -->


        <div class="col-lg-6">
            <div class="card">

                <div class="card-body">
                    <form class="row g-3 needs-validation" method="post"
                        action="{{ route('menu.update', $data_menu_edit['id']) }}" novalidate>
                        @csrf
                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Menu principal </label>
                            <input type="text" name="name" value="{{ $data_menu_edit['name'] }}" class="form-control"
                                id="validationCustom01" placeholder="Menu1" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Position </label>
                            <select name="position" class="form-control">
                                @for ($i = 1; $i <= $data_count; $i++)
                                    <option value="{{ $i }}" {{ $data_menu_edit['position'] == $i ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>


                        <div class="col-md-8">
                            <label for="validationCustom01" class="form-label">Url</label>
                            <input type="text" name="url" class="form-control" id="validationCustom01"
                                value="{{ $data_menu_edit['url'] }}">
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
                                <option value="active" {{ $data_menu_edit['status'] == 'active' ? 'selected' : '' }}>
                                    Activé
                                </option>
                                <option value="desactive" {{ $data_menu_edit['status'] == 'desactive' ? 'selected' : '' }}>
                                    Desactivé
                                </option>
                            </select>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>



                </div>
                <div class="">
                    <button type="submit" class="btn btn-primary w-100 ">Modifier</button>
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
