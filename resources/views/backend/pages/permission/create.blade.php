<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer une permission </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post"
                                action="{{ route('permission.store') }}" novalidate>
                                @csrf
                                
                                <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Module</label>
                                    <select name="module" class="form-control" id="module">
                                        <option disabled selected value>Selectionner</option>
                                        @foreach ($module as $modules)
                                            <option value="{{ $modules['id'] }}" data-name = "{{$modules['name']}}">{{ $modules['name'] }} </option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Roles</label>
                                    <select name="role" class="form-control">
                                        <option disabled selected value>Selectionner</option>
                                        @foreach ($role as $roles)
                                            <option value="{{ $roles['id'] }}">{{ $roles['name'] }} </option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                 <div class="col-md-4">
                                    <label for="validationCustom01" class="form-label">Permissions</label>
                                    <select name="permissions[]" class="form-control js-example-basic-multiple" multiple>
                                        @foreach ($permission as $permissions)
                                            <option value="{{ $permissions['name'] }}">{{ $permissions['name'] }} </option>
                                        @endforeach
                                    </select>

                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary ">Valider</button>
                        </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div><!-- end col -->
    </div><!-- end row -->
</div><!-- end col -->
</div>
<!--end row-->

{{-- @section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
@endsection --}}


