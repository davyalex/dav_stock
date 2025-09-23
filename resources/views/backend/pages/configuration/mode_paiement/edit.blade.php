
 <!-- Modal Modification Mode de Paiement -->
<div id="PaiementEdit{{ $item->id }}" class="modal fade" tabindex="-1" aria-labelledby="modePaiementModalEditLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modePaiementModalEditLabel{{ $item->id }}">Modifier le mode de paiement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" method="post" action="{{ route('mode_paiement.update', $item->id) }}" novalidate>
                    @csrf
             
                    <div class="col-md-12">
                        <label for="libelle{{ $item->id }}" class="form-label">Libellé</label>
                        <input type="text" name="libelle" value="{{ $item->libelle }}" class="form-control" id="libelle{{ $item->id }}" required>
                        <div class="invalid-feedback">
                            Veuillez saisir le libellé.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="description{{ $item->id }}" class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="description{{ $item->id }}" cols="30" rows="3">{{ $item->description }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="statut{{ $item->id }}" class="form-label">Statut</label>
                        <select name="statut" id="statut{{ $item->id }}" class="form-select" required>
                            <option value="active" {{ $item->statut == 'active' ? 'selected' : '' }}>Actif</option>
                            <option value="desactive" {{ $item->statut == 'desactive' ? 'selected' : '' }}>Désactivé</option>
                        </select>
                        <div class="invalid-feedback">
                            Veuillez choisir le statut.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Modifier</button>
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
