<div class="row">
    <div class="col-xxl-6">
        <div class="card">
            <!-- Default Modals -->
            <div id="myModal" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
                style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Créer une nouvelle depense </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">

                            <form class="row g-3 needs-validation" method="post" action="{{ route('depense.store') }}"
                                novalidate>
                                @csrf

                                <div class="col-md-8">
                                    <label for="validationCustom01" class="form-label">Categorie</label>
                                    <select name="categorie_depense" class="form-control categorie-select" required>
                                        <option disabled selected value="">Selectionner</option>
                                        @foreach ($categorie_depense as $item)
                                            <!-- Si la catégorie a des libelleDepenses, rendre l'option non cliquable -->
                                            <option value="{{ $item['id'] }}" class="categorie" 
                                                @if($item->libelleDepenses->isNotEmpty()) disabled @endif>
                                                {{ strtoupper($item['libelle']) }}
                                            </option>
                                
                                            <!-- Boucle pour les libelleDepenses de cette catégorie -->
                                            @foreach ($item->libelleDepenses as $libelle)
                                                <option value="{{ $libelle['id'] }}" class="libelle-depense">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;{{ $libelle['libelle'] }}
                                                </option>
                                            @endforeach
                                        @endforeach
                                    </select>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>
                                

                                <div class="col-md-2">
                                    <label for="validationCustom01" class="form-label">Montant</label>
                                    <input type="number" name="montant" class="form-control" id="validationCustom01"
                                        required>
                                    <div class="valid-feedback">
                                        Looks good!
                                    </div>
                                </div>

                                <div class="col-md-2 mb-3">
                                    <label class="form-label" for="meta-title-input">Date <span
                                            class="text-danger">*</span>
                                    </label>
                                    <input type="date" id="currentDate" value="<?php echo date('Y-m-d'); ?>" name="date_depense"
                                        class="form-control" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="validationCustom01" class="form-label">Objet</label>
                                    <textarea class="form-control" name="description" id="" cols="30" rows="10"></textarea>
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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Sélectionner toutes les options avec la classe 'categorie'
        let categories = document.querySelectorAll('.categorie-select .categorie');
        categories.forEach(function(option) {
            // Appliquer le style inline pour chaque catégorie
            option.style.fontWeight = 'bold'; // Texte en gras
            option.style.textTransform = 'uppercase'; // Texte en majuscule
        });
    });
</script>
