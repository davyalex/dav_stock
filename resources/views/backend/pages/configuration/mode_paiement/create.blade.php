<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer un nouvelle caisse </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post" action="{{ route('caisse.store') }}"
                                novalidate>
                                @csrf
                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Libelle</label>
                                    <input type="text" name="libelle" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Description</label>
                                        <textarea class="form-control" name="description"  cols="30" rows="5"></textarea>
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

<!-- Modal Création Mode de Paiement -->
<div id="myModalPaiement" class="modal fade" tabindex="-1" aria-labelledby="modePaiementModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modePaiementModalLabel">Créer un mode de paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" action="{{ route('mode_paiement.store') }}" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label for="libelle" class="form-label">Libellé</label>
                        <input type="text" name="libelle" class="form-control" id="libelle" required>
                        <div class="invalid-feedback">
                            Veuillez saisir le libellé.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description" cols="30" rows="3"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="statut" class="form-label">Statut</label>
                        <select name="statut" id="statut" class="form-select" required>
                            <option value="active" selected>Actif</option>
                            <option value="desactive">Désactivé</option>
                        </select>
                        <div class="invalid-feedback">
                            Veuillez choisir le statut.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Valider</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{-- @section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
@endsection --}}
