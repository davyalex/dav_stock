 <!-- Default Modals -->
 <div id="myModalEdit{{ $item['id'] }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
     style="display: none;">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="myModalLabel">Modification </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                 </button>
             </div>
             <div class="modal-body">

                 <form class="row g-3 needs-validation" method="post"
                     action="{{ route('employe.update', $item['id']) }}" novalidate>
                     @csrf
                     <div class="row">
                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Nom</label>
                             <input type="text" name="nom" value="{{ $item['nom'] }}" class="form-control"
                                 id="validationCustom01" required>
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Prenoms</label>
                             <input type="text" name="prenom" value="{{ $item['prenom'] }}" class="form-control"
                                 id="validationCustom01" required>
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Telephone</label>
                             <input type="number" name="telephone" value="{{ $item['telephone'] }}"
                                 class="form-control" id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Email</label>
                             <input type="email" name="email" value="{{ $item['email'] }}" class="form-control"
                                 id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Adresse</label>
                             <input type="number" name="adresse" value="{{ $item['adresse'] }}" class="form-control"
                                 id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">date d'embauche</label>
                             <input type="date" name="date_embauche" value="{{ $item['date_embauche'] }}"
                                 class="form-control" id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>

                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Salaire de base</label>
                             <input type="number" name="salaire_base" value="{{ $item['salaire_base'] }}"
                                 class="form-control" id="validationCustom01">
                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>


                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Poste occupé</label>

                             <select class="form-select" name="poste_id">
                                 <option value="">Choisir un poste</option>
                                 @foreach ($data_poste as $item)
                                     <option value="{{ $item['id'] }}"
                                         {{ $item['id'] == $item['poste_id'] ? 'selected' : '' }}>
                                         {{ $item['libelle'] }}</option>
                                 @endforeach

                             </select>

                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>


                         <div class="col-md-6">
                             <label for="validationCustom01" class="form-label">Statut</label>
                             <select class="form-select" name="statut">
                                 <option value="active" @selected($item['statut'] == 'active')>Activer</option>
                                 <option value="desactive" @selected($item['statut'] == 'desactive')>Desactiver</option>
                             </select>

                             <div class="valid-feedback">
                                 Looks good!
                             </div>
                         </div>
                     </div>

             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-bs-dismiss="modal">Fermer</button>
                 <button type="submit" class="btn btn-primary ">Modifier</button>
             </div>
             </form>
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->

 {{-- @section('script')
    <script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
    <script src="https://cdn.lordicon.com/libs/mssddfmo/lord-icon-2.1.0.js"></script>
    <script src="{{ URL::asset('build/js/pages/modal.init.js') }}"></script>

    <script src="{{ URL::asset('build/js/app.js') }}"></script>
    
@endsection --}}
