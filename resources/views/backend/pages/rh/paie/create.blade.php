<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer une nouvelle paie </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post" action="{{ route('paie.store') }}"
                                novalidate>
                                @csrf
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Employé</label>
                                    <select class="form-select" id="validationCustom01" name="employe_id" required>
                                        <option value=""> Selectionner</option>
                                        @foreach ($data_employe as $employe)
                                            <option value="{{ $employe->id }}">{{ $employe->nom }}
                                                {{ $employe->prenom }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Type de paie</label>
                                    <select class="form-select" id="validationCustom01" name="type_paie" required>
                                        <option value=""> Selectionner</option>
                                        @foreach ($type_paie as $type)
                                            <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Mois de paie</label>
                                    <select class="form-select" id="validationCustom01" name="mois" required>
                                        <option value=""> Selectionner</option>
                                        @foreach ($mois as $key => $item)
                                            <option value="{{ $key }}"
                                                {{ $key == date('n') ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Année de paie</label>
                                    <select class="form-select" id="validationCustom01" name="annee" required>
                                        <option value=""> Selectionner</option>
                                        @for ($i = 2020; $i <= date('Y'); $i++)
                                            <option value="{{ $i }}"
                                                {{ $i == date('Y') ? 'selected' : '' }}>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Montant de la paie</label>
                                    <input type="number" name="montant" class="form-control" id="validationCustom01">
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">Statut</label>
                                    <select class="form-select" name="statut">
                                        <option value="paye">Payé</option>
                                        <option value="en attente">En attente</option>
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
